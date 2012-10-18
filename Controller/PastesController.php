<?php
App::uses('AppController', 'Controller');
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
		if ($this->request->action === 'edit') {
			$this->Security->blackHoleCallback = 'edit';
		} elseif ($this->request->action === 'add') {
			$this->Security->blackHoleCallback = 'add';
		}
	}

	public function beforeFilter() {
		$this->_validatePost();
		if (!empty($this->request->params['nick'])) {
			$this->nick = $this->request->params['nick'];
		}
	}

	public function beforeRender() {
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
		$this->set('pastes', $this->paginate('Paste', $conditions));
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
		$this->set(compact('pastes', 'q'));
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
		$this->set('paste', $this->request->data);
		if (empty($this->request->data)) {
			return $this->redirect(array('action' => 'index'));
		}

		$this->set('original', $this->request->data['Original']);
		$this->set('languages', $this->Paste->languages());
		unset($this->request->data['Paste']['nick']);
		return $this->render('view');
	}

	/**
	 * View the paste in HTML with buttons!
	 *
	 * @param string $temp The temp id of the paste
	 */
	public function view($temp = null) {
		$this->_getPaste($temp);
		$this->set(array('languages' => $this->Paste->languages()));
	}

	/**
	 * View the raw text for a paste.
	 *
	 * @param string $temp The temp id of the paste
	 */
	public function raw($temp = null) {
		$this->_getPaste($temp);
		$this->layout = false;
		$this->response->type('text');
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

		if (!$this->request->is('post') && !$this->request->is('put')) {
			return;
		}

		$this->Paste->create($this->request->data);
		$result = $this->Paste->save();
		if (empty($result)) {
			$this->Session->setFlash('Please correct errors below.');
			$this->set('languages', $this->Paste->languages());
			return $this->render('add');
		}

		if ($result['Paste']['save'] == 0) {
			$this->Session->setFlash('The Paste is just temporary.');
			return $this->redirect(array('action' => 'view', $result['Paste']['temp']));
		}

		$this->Session->setFlash('The Paste is saved');
		return $this->redirect(array('action' => 'saved', $result['Paste']['id']));
	}

	/**
	 * Get the edit page, it submits to the save action.
	 */
	public function edit($id = null) {
		if (!$id) {
			throw new NotFoundException();
		}

		$this->nick = null;
		if (empty($this->request->data)) {
			$this->set('languages', $this->Paste->languages());
			$this->request->data = $this->Paste->read(null, $id);
		}
	}

	protected function _getPaste($temp) {
		if (!$temp) {
			throw new NotFoundException();
		}

		$paste = $this->Paste->findByTemp($temp);
		if (empty($paste)) {
			throw new NotFoundException();
		}

		$this->request->data = $paste;
		$this->set('paste', $paste);
		unset($this->request->data['Paste']['nick']);
	}

}
