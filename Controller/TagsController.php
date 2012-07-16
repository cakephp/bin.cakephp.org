<?php
class TagsController extends AppController
{
	//var $scaffold;
	var $name = 'Tags';
	
	function popular() {
		if($this->request->params['bare'] != '1') {
			$this->redirect('/');
		}
		return $this->Tag->popular();
	}
	
	function show($keyname = null) {
		if(!$keyname) {
			return false;
		}
		$this->set('tag', $this->Tag->findByKeyname($keyname));
		$this->set('recent', $this->requestAction('/pastes/recent'));
	}
	
}
?>