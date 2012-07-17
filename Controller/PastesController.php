<?php
App::uses('Sanitize', 'Utility');
App::uses('Folder', 'Utility');

class PastesController extends AppController {

	var $nick = null;

	var $paginate = array(
		'Paste' => array(
			'saved',
			'order' => 'Paste.created DESC',
			'limit' => '40'
		)
	);

	var $components = array('Session', 'Security');

	function _validatePost() {
		if($this->request->action === 'edit'){
			$this->Security->blackHoleCallback = 'edit';
		} elseif($this->request->action === 'add') {
			$this->Security->blackHoleCallback = 'add';
		}
	}

	function beforeFilter() {
		$this->_validatePost();
		if (!empty($this->request->params['nick'])) {
			$this->nick = $this->request->params['nick'];
		}
		$this->set('nick', $this->nick);
	}

	function beforeRender() {
		if (!empty($this->request->data['Paste'])) {
			$this->request->data['NewPaste'] = $this->request->data['Paste'];
		}
	}

	function index() {
		$conditions = array();
		if ($this->nick) {
			$conditions['Paste.nick'] = $this->nick;
		}
		$this->Paste->recursive = 0;
		$pastes = $this->paginate('Paste', $conditions);
		$this->set('pastes', $pastes);
	}

	function nick() {
		$this->setAction('index');
	}

	function search() {
		$conditions = array();
		$q = null;
		if(!empty($this->request->params['url']['q'])) {
			$q = $this->request->params['url']['q'];
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

	function recent() {
		$this->Paste->recursive = 0;
		return $this->Paste->find('recent');
	}

	function recent_versions() {
		$this->Paste->recursive = 0;
		return $this->Paste->find('recentVersions');
	}

	function saved($id = null) {
		if (!$id) {
			return $this->setAction('index');
		}
		$this->Paste->recursive = 2;
		$this->request->data = $this->Paste->read(null, $id);
		if (!empty($this->request->data)) {
			$this->set('paste', $this->request->data);
			$this->set('original',  $this->request->data['Original']);
			$this->set('languages',$this->Paste->languages());//set geshi languages
			$this->__setPasteId();
			unset($this->request->data['Paste']['nick']);
			$this->render('view');
		} else {
			$this->redirect('/list');
		}
	}

	function view($temp = null) {
		if(!$temp && empty($this->request->data)) {
			return false;
		}
		if(empty($this->request->data)) {
			$this->Paste->unbindModel(array('hasMany'=>array('Version')));
			$this->request->data  = $this->Paste->findByTemp($temp, null, 'Paste.created DESC');
		}
		if(!empty($this->request->data)) {
			$this->set('paste', $this->request->data);
			$this->set('languages', $this->Paste->languages());//set geshi languages
			$this->__setPasteId();
			unset($this->request->data['Paste']['nick']);
		} else {
			$this->Session->setFlash('Invalid Paste');
			$this->redirect('/list');
		}
	}

	function tag($id = null) {
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
	function add() {
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

	function edit($id = null) {
		$this->set('nick', null);
		if (empty($this->request->data)) {
			if(!$id) {
				return false;
			}
			$this->set('languages',$this->Paste->languages());//set geshi languages
			$this->request->data = $this->Paste->read(null, $id);
			$this->__setPasteId();
			$this->set('nick', $this->request->data['Paste']['nick']);
			unset($this->request->data['Paste']['nick']);
			$this->render(); exit();
		} else if(!empty($this->request->data['Other']['comment']) || !empty($this->request->data['Other']['title']) || !empty($this->request->data['Other']['date'])) {
			$this->request->data['Paste']['created'] = date('Y-m-d H:i:s');
			$this->request->data['Tag'] = null;
			$this->view();
			$this->render('view');
		} else if(!empty($this->request->data['NewPaste'])) {

			$this->request->data['Paste'] = $this->request->data['NewPaste'];

			if(empty($this->request->data['Paste']['temp'])) {
				$this->request->data['Paste']['temp'] = abs(mt_rand());
			}
			if(!empty($this->request->data['Paste']['nick'])) {
				$allow = array(',', "'", '"', '_', '-', '|', '^', ':', '.');
				$this->request->data['Paste']['nick'] = Sanitize::paranoid($this->request->data['Paste']['nick'], $allow);
			}
			if(!empty($this->request->data['Paste']['paste_id'])) {
				$this->Paste->id = null;
				$this->request->data['Paste']['id'] = null;
			}

			Sanitize::clean($this->request->data);
			if($this->Paste->save($this->request->data)) {
				if($this->request->data['Paste']['save'] == '0') {
					$this->Session->setFlash('The Paste is just temporary.');
					$this->redirect('/view/'.$this->request->data['Paste']['temp']);
				} else {
					$this->Session->setFlash('The Paste is saved');
					$this->redirect('/saved/'.$this->Paste->id);
				}
			} else {
				$this->Session->setFlash('Please correct errors.');
				$this->set('nick', $this->Paste->field('nick'));
				$this->set('languages',$this->Paste->languages());//set geshi Paste->languages
			}
		}
	}

	function __purge() {
		$this->Paste->purgeTemporary();
	}

	function __setPasteId() {
		if($this->request->data['Paste']['save'] == '0') {
			if(!empty($this->request->data['Paste']['paste_id'])) {
				unset($this->request->data['Paste']['paste_id']);
			}
		} else {
			if(empty($this->request->data['Paste']['paste_id'])) {
				$this->request->data['Paste']['paste_id'] = $this->request->data['Paste']['id'];
			}
		}
	}
}
