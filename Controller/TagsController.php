<?php
App::uses('AppController', 'Controller');

class TagsController extends AppController
{
	function popular() {
		if ($this->request->params['bare'] != '1') {
			$this->redirect('/');
		}
		return $this->Tag->popular();
	}
	
	function show($keyname = null) {
		if (!$keyname) {
			throw new NotFoundException('No pastes match');
		}
		$this->set('tag', $this->Tag->findByKeyname($keyname));
		$this->set('recent', $this->Tag->Paste->find('recent'));
	}

}
