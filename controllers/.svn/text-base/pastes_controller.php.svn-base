<?php
uses('sanitize');
class PastesController extends AppController
{
	var $name = 'Pastes';
	var $nick = null;
	var $paginate = array('order'=>'Paste.created DESC', 'limit'=>'40');

	var $components = array('Security');

	function __construct() {
		parent::__construct();
		$this->Sanitize = & new Sanitize();
	}

	function _validatePost() {
		if($this->action === 'edit'){
			$this->Security->blackHoleCallback = 'edit';
		} elseif($this->action === 'add') {
			$this->Security->blackHoleCallback = 'add';
		}

		$this->Security->requireAuth('add','edit');
	}

	function beforeFilter() {
		$this->_validatePost();
		if(!empty($this->params['nick'])) {
			$this->nick = $this->params['nick'];
		}
		$this->set('nick', $this->nick);
	}

	function beforeRender() {
		if(!empty($this->data['Paste'])) {
			$this->data['NewPaste'] = $this->data['Paste'];
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
		if(!empty($this->params['url']['q'])) {
			$q = $this->params['url']['q'];
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
			$this->action = 'index';
			$this->index();
			return;
		}
		$this->Paste->recursive = 2;
		$this->data  = $this->Paste->read(null, $id);
		if(!empty($this->data)) {
			$this->set('paste', $this->data);
			$this->set('original',  $this->data['Original']);
			$this->set('languages',$this->__languages());//set geshi languages
			$this->__setPasteId();
			unset($this->data['Paste']['nick']);
			$this->render('view');
		} else {
			$this->redirect('/list');
		}
	}

	function view($temp = null) {
		if(!$temp && empty($this->data)) {
			return false;
		}
		if(empty($this->data)) {
			$this->Paste->unbindModel(array('hasMany'=>array('Version')));
			$this->data  = $this->Paste->findByTemp($temp, null, 'Paste.created DESC');
		}
		if(!empty($this->data)) {
			$this->set('paste', $this->data);
			$this->set('languages',$this->__languages());//set geshi languages
			$this->__setPasteId();
			unset($this->data['Paste']['nick']);
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
		if(!empty($this->data)) {
			$allow = array(',', "'", '"', '_', '-', '|', '^', ':', '.');
			$allow[] = " ";
			$tags = $this->Paste->Tag->saveTags($this->Sanitize->paranoid($this->data['Paste']['tags'],$allow));
			if(!empty($paste['Tag'])) {
				foreach($paste['Tag'] as $var) {
					$tags[] = $var['id'];
				}
			}
			$this->data['Paste']['id'] = $id;
			$this->data['Tag']['Tag'] = array_unique($tags);
			$this->Sanitize->clean($this->data);
			if($this->Paste->save($this->data)) {
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
		if(empty($this->data)) {
			$this->set('languages',$this->__languages());//set geshi languages
			$this->data['Paste']['nick'] = $this->nick;
			$this->data['Paste']['lang'] = 'php';
			$this->render();
		} else if(!empty($this->data['Other']['comment']) || !empty($this->data['Other']['title']) || !empty($this->data['Other']['date'])) {
			$this->data['Paste']['created'] = date('Y-m-d H:i:s');
			$this->view();
			$this->render('view');
		} else if(!empty($this->data['NewPaste'])) {

			$this->data['Paste'] = $this->data['NewPaste'];

			$this->data['Paste']['temp'] = abs(mt_rand());
			if(!empty($this->data['Paste']['nick'])) {
				$allow = array(',', "'", '"', '_', '-', '|', '^', ':', '.');
				$this->data['Paste']['nick'] = $this->Sanitize->paranoid($this->data['Paste']['nick'], $allow);
			}
			if($this->data['Paste']['save'] == 1 && !empty($this->data['Paste']['tags'])) {
				$allow = array(" ",'.',',');
				$this->data['Tag']['Tag'] = $this->Paste->Tag->saveTags($this->Sanitize->paranoid($this->data['Paste']['tags'],$allow));
			}
			$this->Sanitize->clean($this->data);
			if($this->Paste->save($this->data)) {
				if($this->data['Paste']['save'] == 0) {
					$this->Session->setFlash('The Paste is just temporary.');
				} else {
					$this->Session->setFlash('The Paste is saved');
				}
				$this->redirect('/view/'.$this->data['Paste']['temp']);
			} else {
				$this->Session->setFlash('Please correct errors below.');
				$this->set('languages',$this->__languages());//set geshi languages
			}
		}
	}

	function edit($id = null) {
		$this->set('nick', null);
		if(empty($this->data)) {
			if(!$id) {
				return false;
			}
			$this->set('languages',$this->__languages());//set geshi languages
			$this->data = $this->Paste->read(null, $id);
			$this->__setPasteId();
			$this->set('nick', $this->data['Paste']['nick']);
			unset($this->data['Paste']['nick']);
			$this->render(); exit();
		} else if(!empty($this->data['Other']['comment']) || !empty($this->data['Other']['title']) || !empty($this->data['Other']['date'])) {
			$this->data['Paste']['created'] = date('Y-m-d H:i:s');
			$this->data['Tag'] = null;
			$this->view();
			$this->render('view');
		} else if(!empty($this->data['NewPaste'])) {

			$this->data['Paste'] = $this->data['NewPaste'];

			if(empty($this->data['Paste']['temp'])) {
				$this->data['Paste']['temp'] = abs(mt_rand());
			}
			if(!empty($this->data['Paste']['nick'])) {
				$allow = array(',', "'", '"', '_', '-', '|', '^', ':', '.');
				$this->data['Paste']['nick'] = $this->Sanitize->paranoid($this->data['Paste']['nick'], $allow);
			}
			if(!empty($this->data['Paste']['paste_id'])) {
				$this->Paste->id = null;
				$this->data['Paste']['id'] = null;
			}

			$this->Sanitize->clean($this->data);
			if($this->Paste->save($this->data)) {
				if($this->data['Paste']['save'] == '0') {
					$this->Session->setFlash('The Paste is just temporary.');
					$this->redirect('/view/'.$this->data['Paste']['temp']);
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
		uses('folder');
		$names = array();
		if (!($Folder = &new Folder(APP.'vendors'.DS.'geshi'))) {
			if (!($Folder = &new  Folder(ROOT . 'vendors' .DS. 'geshi'))) {
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
		if($this->data['Paste']['save'] == '0') {
			if(!empty($this->data['Paste']['paste_id'])) {
				unset($this->data['Paste']['paste_id']);
			}
		} else {
			if(empty($this->data['Paste']['paste_id'])) {
				$this->data['Paste']['paste_id'] = $this->data['Paste']['id'];
			}
		}
	}
}
?>