<?php

class Tag extends AppModel {
/**
 * Enter description here...
 *
 * @var string
 */
    var $name = 'Tag';
/**
 * Enter description here...
 *
 * @var unknown_type
 */
	var $validate = array('name' => 'notEmpty');
/**
 * Enter description here...
 *
 * @var array
 */
	var $hasAndBelongsToMany = array(
		'Paste' => array('className' => 'Paste')
	); 

	function saveTags($string = null) {
		$return = array();
		
		if($string) {
			$array = explode(',', $string);
			foreach($array as $tag) {
				if (!empty($tag)) {
					$this->data[$this->name]['name'] = trim($tag);
					$this->data[$this->name]['keyname'] = preg_replace('/[^a-z0-9]/', '', strtolower($tag));
					$this->recursive = -1;
					$existing = $this->find("keyname = '{$this->data[$this->name]['keyname']}'");  
					if(!empty($existing)) {
						$return[] = $existing[$this->name][$this->primaryKey];
					} else {
						$this->id = null;
						if($this->save($this->data)) {
							$return[] = $this->id;
						}
					} 
				}	
			} 
		}   
		
		return $return;
	}
	
	function popular() {
		return $this->query("SELECT `Tag`.`id`, `Tag`.`name`, `Tag`.`keyname`, COUNT(pastes_tags.paste_id) as count 
	 					FROM `pastes_tags` JOIN `tags` as `Tag` ON `pastes_tags`.`tag_id` = `Tag`.`id` 
						JOIN `pastes` as `Paste` ON `pastes_tags`.`paste_id` = `Paste`.`id` WHERE `Paste`.`save` = '1' GROUP BY (tag_id) ORDER BY Tag.name ASC");
	}
}
