<?php

class Tag extends AppModel {

	public $validate = array('name' => 'notEmpty');

	public $hasAndBelongsToMany = array(
		'Paste' => array('className' => 'Paste')
	);

	function saveTags($string = null) {
		$return = array();
		
		if ($string) {
			$array = explode(',', $string);
			foreach ($array as $tag) {
				if (!empty($tag)) {
					$this->data[$this->name]['name'] = trim($tag);
					$this->data[$this->name]['keyname'] = preg_replace('/[^a-z0-9]/', '', strtolower($tag));
					$this->recursive = -1;
					$existing = $this->find('first', array(
						'conditions' => array(
							'keyname' => $this->data[$this->name]['keyname']
						)
					));
					if (!empty($existing)) {
						$return[] = $existing[$this->name][$this->primaryKey];
					} else {
						$this->id = null;
						if ($this->save($this->data)) {
							$return[] = $this->id;
						}
					}
				}
			}
		}
		return $return;
	}
	
	function popular() {
		$this->unbindModel(array(
			'hasAndBelongsToMany' => array('Paste')
		));
		$db = $this->getDataSource();
		$query = array(
			'fields' => array(
				'Tag.id', 'Tag.name', 'Tag.keyname',
				'COUNT(PastesTag.paste_id) AS count'
			),
			'conditions' => array(
				'Paste.save' => 1
			),
			'joins' => array(
				array(
					'table' => 'pastes_tags',
					'alias' => 'PastesTag',
					'type' => 'INNER',
					'conditions' => 'PastesTag.tag_id = Tag.id'
				),
				array(
					'table' => 'pastes',
					'alias' => 'Paste',
					'type' => 'INNER',
					'conditions' => 'PastesTag.paste_id = Paste.id'
				),
			),
			'group' => array(
				'Tag.id', 'Tag.name', 'Tag.keyname'
			),
			'order' => array(
				'Tag.name' => 'ASC'
			)
		);
		return $this->find('all', $query);
	}

}
