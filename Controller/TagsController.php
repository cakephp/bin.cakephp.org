<?php
App::uses('AppController', 'Controller');

class TagsController extends AppController {
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
		$this->Tag->unbindModel(array('hasAndBelongsToMany' => array('Paste')));
		$tag = $this->Tag->findByKeyname($keyname);
		$pastes = $this->Tag->Paste->find('tagged', array(
			'tagId' => $tag['Tag']['id'],
			'limit' => 20,
			'order' => 'Paste.created DESC'
		));
		$this->set(compact('tag', 'pastes'));
	}

}
