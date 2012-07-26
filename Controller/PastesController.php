<?php
App::uses('Sanitize', 'Utility');
App::uses('Folder', 'Utility');

class PastesController extends AppController {

	public $nick = null;

	public $paginate = array(
		'Paste' => array(
			'saved',
			'order' => 'Paste.created DESC',
			'limit' => '40'
		)
	);

	public $components = array('Session', 'Security');

	protected function _validatePost() {
		if($this->request->action === 'edit'){
			$this->Security->blackHoleCallback = 'edit';
		} elseif($this->request->action === 'add') {
			$this->Security->blackHoleCallback = 'add';
		}
	}

	public function beforeFilter() {
		$this->_validatePost();
		if (!empty($this->request->params['nick'])) {
			$this->nick = $this->request->params['nick'];
		}
		$this->set('nick', $this->nick);
	}

	/**
	 * Display a list of saved posts.
	 */
	public function index() {
		$conditions = array();
		if ($this->nick) {
			$conditions['Paste.nick'] = $this->nick;
		}
		$this->Paste->recursive = 0;
		$pastes = $this->paginate('Paste', $conditions);
		$this->set('pastes', $pastes);
	}

	public function nick() {
		$this->setAction('index');
	}

	/**
	 * Search the saved posts.
	 */
	public function search() {
		$conditions = array();
		$q = null;
		if (!empty($this->request->query['q'])) {
			$q = $this->request->query['q'];
		}
		if ($q) {
			$conditions['OR'] = array(
				'Paste.nick LIKE' => '%' . $q . '%',
				'Paste.note LIKE' => '%' . $q . '%',
			);
		}
		$pastes = $this->paginate('Paste', $conditions);
		$this->set(array(
			'pastes' => $pastes,
			'q' => $q
		));
	}

	/**
	 * View a saved paste and its revisions.
	 */
	public function saved($id = null) {
		if (!$id) {
			return $this->setAction('index');
		}
		$this->Paste->recursive = 2;
		$this->request->data = $this->Paste->read(null, $id);
		if (!empty($this->request->data)) {
			$this->set('paste', $this->request->data);
			$this->set('original',  $this->request->data['Original']);
			$this->set('languages',$this->Paste->languages());//set geshi languages
			unset($this->request->data['Paste']['nick']);
			$this->render('view');
		} else {
			$this->redirect(array('action' => 'index'));
		}
	}

	public function view($temp = null) {
		if (!$temp) {
			throw new NotFoundException();
		}
		if (empty($this->request->data)) {
			$this->Paste->unbindModel(array('hasMany' => array('Version')));
			$this->request->data = $this->Paste->findByTemp($temp, null, 'Paste.created DESC');
		}
		if (!empty($this->request->data)) {
			$this->set('paste', $this->request->data);
			$this->set('languages', $this->Paste->languages());//set geshi languages
			unset($this->request->data['Paste']['nick']);
		}
	}

	public function tag($id = null) {
		$this->set('id', $id);
		$this->set('tags_added', false);
		$this->Paste->unbindModel(array('hasMany'=>array('Version')));
		$paste = $this->Paste->read('Paste.id', $id);
		if(!empty($this->request->data)) {
			$allow = array(',', "'", '"', '_', '-', '|', '^', ':', '.');
			$allow[] = " ";
			$tags = $this->Paste->Tag->saveTags(Sanitize::paranoid($this->request->data['Paste']['tags'],$allow));
			if(!empty($paste['Tag'])) {
				foreach($paste['Tag'] as $var) {
					$tags[] = $var['id'];
				}
			}
			$this->request->data['Paste']['id'] = $id;
			$this->request->data['Tag']['Tag'] = array_unique($tags);
			Sanitize::clean($this->request->data);
			if($this->Paste->save($this->request->data)) {
				$this->set('tags_added', true);
				$this->Paste->cacheQueries = false;
				$this->Paste->unbindModel(array('hasMany'=>array('Version')));
				$paste = $this->Paste->read('Paste.id', $id);
			}
		}

		$this->set('paste', $paste);
		$this->render();
	}

	/**
	 * Get the form to add a new paste.
	 */
	public function add() {
		$this->set('languages', $this->Paste->languages());
		$this->request->data = array(
			'Paste' => array(
				'nick' => $this->nick,
				'lang' => 'php',
			)
		);
	}

	/**
	 * Save a new or updated paste.
	 */
	public function save() {
		if ($this->request->is('get')) {
			return $this->redirect(array('action' => 'add'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			$this->Paste->create($this->request->data);
			$result = $this->Paste->save();
			if (!empty($result)) {
				if ($result['Paste']['save'] == 0) {
					$this->Session->setFlash('The Paste is just temporary.');
				} else {
					$this->Session->setFlash('The Paste is saved');
				}
				return $this->redirect(array('action' => 'view', $result['Paste']['temp']));
			} else {
				$this->Session->setFlash('Please correct errors below.');
				$this->set('languages', $this->Paste->languages());
				$this->render('add');
			}
		}
	}

	/**
	 * Get the edit page, it submits to the save action.
	 */
	public function edit($id = null) {
		if (!$id) {
			throw new NotFoundException();
		}
		$this->set('nick', null);
		if (empty($this->request->data)) {
			$this->set('languages',$this->Paste->languages());
			$this->request->data = $this->Paste->read(null, $id);
		}
	}

}
