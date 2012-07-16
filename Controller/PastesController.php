<?php
App::uses('Utility', 'Sanitize');
App::uses('Utility', 'Folder');

class PastesController extends AppController
{
	var $name = 'Pastes';

	var $nick = null;

	var $paginate = array(
		'order'=>'Paste.created DESC',
		'limit'=>'40'
	);

	var $components = array('Security');

	function _validatePost() {
		if($this->request->action === 'edit'){
			$this->Security->blackHoleCallback = 'edit';
		} elseif($this->request->action === 'add') {
			$this->Security->blackHoleCallback = 'add';
		}

		$this->Security->requireAuth('add','edit');
	}

	function beforeFilter() {
		$this->_validatePost();
		if(!empty($this->request->params['nick'])) {
			$this->nick = $this->request->params['nick'];
		}
		$this->set('nick', $this->nick);
	}

	function beforeRender() {
		if(!empty($this->request->data['Paste'])) {
			$this->request->data['NewPaste'] = $this->request->data['Paste'];
		}
	}

	function index() {
		$conditions[] = "(Paste.save = '1' AND Paste.remove < '10')";
		if($this->nick) {
			$conditions[] .= "(Paste.nick = '{$this->nick}')";
		}
		$this->Paste->recursive = 0;
		$pastes = $this->paginate(null, $conditions);
		$this->set('pastes', $pastes);
	}

	function nick() {
		$conditions[] = "(Paste.save = '1' AND Paste.remove < '10' AND Paste.paste_id IS NULL)";
		if($this->nick) {
			$conditions[] .= "(Paste.nick = '{$this->nick}')";
		}
		$pastes = $this->paginate(null, $conditions);
		$this->set('pastes', $pastes);
		$this->render('index');
	}

	function search() {
		$q = null;
		if(!empty($this->request->params['url']['q'])) {
			$q = $this->request->params['url']['q'];
		}
		$this->set('q', $q);
		$conditions[] = "(Paste.save = '1' AND Paste.remove < '10' AND Paste.paste_id IS NULL)";
		if($q) {
			$conditions[] .= " (Paste.nick LIKE '%{$q}%' OR Paste.note LIKE '%{$q}%')";
		}
		$pastes = $this->paginate(null, $conditions);
		$this->set('pastes', $pastes);
	}

	function recent() {
		$this->Paste->recursive = 0;
		return $this->Paste->findAll("Paste.save = '1' AND Paste.remove < '10' AND Paste.paste_id IS NULL",
										null, 'Paste.created DESC', '10');
	}
	function recent_versions() {
		$this->Paste->recursive = 0;
		return $this->Paste->findAll("Paste.save = '1' AND Paste.remove < '10' AND Paste.paste_id != NULL",
										null, 'Paste.created DESC', '10');
	}
	function saved($id = null) {
		if(!$id) {
			$this->request->action = 'index';
			$this->index();
			return;
		}
		$this->Paste->recursive = 2;
		$this->request->data  = $this->Paste->read(null, $id);
		if(!empty($this->request->data)) {
			$this->set('paste', $this->request->data);
			$this->set('original',  $this->request->data['Original']);
			$this->set('languages',$this->__languages());//set geshi languages
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
			$this->set('languages',$this->__languages());//set geshi languages
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

	function add() {
		if(empty($this->request->data)) {
			$this->set('languages',$this->__languages());//set geshi languages
			$this->request->data['Paste']['nick'] = $this->nick;
			$this->request->data['Paste']['lang'] = 'php';
			$this->render();
		} else if(!empty($this->request->data['Other']['comment']) || !empty($this->request->data['Other']['title']) || !empty($this->request->data['Other']['date'])) {
			$this->request->data['Paste']['created'] = date('Y-m-d H:i:s');
			$this->view();
			$this->render('view');
		} else if(!empty($this->request->data['NewPaste'])) {

			$this->request->data['Paste'] = $this->request->data['NewPaste'];

			$this->request->data['Paste']['temp'] = abs(mt_rand());
			if(!empty($this->request->data['Paste']['nick'])) {
				$allow = array(',', "'", '"', '_', '-', '|', '^', ':', '.');
				$this->request->data['Paste']['nick'] = Sanitize::paranoid($this->request->data['Paste']['nick'], $allow);
			}
			if($this->request->data['Paste']['save'] == 1 && !empty($this->request->data['Paste']['tags'])) {
				$allow = array(" ",'.',',');
				$this->request->data['Tag']['Tag'] = $this->Paste->Tag->saveTags(Sanitize::paranoid($this->request->data['Paste']['tags'],$allow));
			}
			Sanitize::clean($this->request->data);
			if($this->Paste->save($this->request->data)) {
				if($this->request->data['Paste']['save'] == 0) {
					$this->Session->setFlash('The Paste is just temporary.');
				} else {
					$this->Session->setFlash('The Paste is saved');
				}
				$this->redirect('/view/'.$this->request->data['Paste']['temp']);
			} else {
				$this->Session->setFlash('Please correct errors below.');
				$this->set('languages',$this->__languages());//set geshi languages
			}
		}
	}

	function edit($id = null) {
		$this->set('nick', null);
		if(empty($this->request->data)) {
			if(!$id) {
				return false;
			}
			$this->set('languages',$this->__languages());//set geshi languages
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
				$this->set('languages',$this->__languages());//set geshi languages
			}
		}
	}

	function delete($id = null) {
		exit();
		if(!$id) {
			return false;
		}
		if($this->Paste->del($id)) {
			$this->Session->setFlash('The Paste deleted: id '.$id.'');
			$this->redirect('/Pastes/index');
		}
	}

	function __purge() {
		$data = $this->Paste->findAll("Paste.save !='1' AND   Paste.created <= DATE_SUB(CURDATE(),INTERVAL 1 DAY)");
		if(!empty($data)) {
			foreach($data as $paste)
			{
				$this->Paste->del($paste['Paste']['id']);
			}
		}
	}

	function __languages() {
		$names = array();
		if (!($Folder = new Folder(APP.'vendors'.DS.'geshi'))) {
			if (!($Folder = new  Folder(ROOT . 'vendors' .DS. 'geshi'))) {
				$names[] = 'No languages available!';
			}
		}
		$languages = $Folder->ls(true, true);
		if(!empty($languages[1])) {
			foreach($languages[1] as $lang) {
				$names[substr($lang, 0, strlen($lang) - 4)] = substr($lang, 0, strlen($lang) - 4);
			}
		}
		return $names;
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
