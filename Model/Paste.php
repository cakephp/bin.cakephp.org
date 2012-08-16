<?php
App::uses('Folder', 'Utility');

class Paste extends AppModel
{
	protected $_languages;

	public $findMethods = array(
		'saved' => true,
		'recent' => true,
		'recentVersions' => true,
	);

	public $validate = array(
		'nick' => array(
			'empty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Nick is a required field',
				'required' => true,
			)
		),
		'body' => array(
			'empty' => array(
				'rule' => array('notEmpty'),
				'message' => 'A paste is required',
				'required' => true,
			)
		),
		'lang' => array(
			'empty' => array(
				'rule' => array('notEmpty'),
				'message' => 'A language is a required',
				'required' => true,
			)
		),
		'paste_id' => array(
			'valid' => array(
				'rule' => 'validParent',
				'message' => 'You cannot make a version of a version.'
			)
		)
	);

	public $belongsTo = array(
		'Original' => array(
			'className' => 'Paste',
			'foreignKey' => 'paste_id'
		)
	);

	public $hasMany = array(
		'Version' => array('className' => 'Paste'),
	);

	public $hasAndBelongsToMany = array(
		'Tag' => array('className' => 'Tag'),
	);

/**
 * Before save callback, sets some default data.
 */
	public function beforeValidate($options = array()) {
		if (empty($this->data['Paste']['temp'])) {
			$this->data['Paste']['temp'] = abs(mt_rand());
		}
		return true;
	}

/**
 * Before saving the paste, save the tags so they can be associated
 */
	public function beforeSave($options = array()) {
		if (!empty($this->data['Paste']['save']) && !empty($this->data['Paste']['tags'])) {
			$this->data['Tag']['Tag'] = $this->Tag->saveTags($this->data['Paste']['tags']);
			unset($this->data['Paste']['tags']);
		}

		$parentId = null;
		if (
			!empty($this->data['Paste']['save']) &&
			!empty($this->data['Paste']['id'])
		) {
			$parentId = $this->data['Paste']['id'];
		}

		// Don't make pastes trees.
		if (
			$parentId &&
			empty($this->data['Paste']['paste_id'])
		) {
			$this->data['Paste']['paste_id'] = $parentId;
		}

		// If this paste has a parent always create a new one.
		if (!empty($this->data['Paste']['paste_id'])) {
			$this->id = false;
			unset($this->data['Paste']['id']);
		}
		return true;
	}

/**
 * Validation method used to ensure the selected parent paste
 * doesn't also have a parent paste.
 *
 * @param int $check The parent paste.id to check
 * @return bool
 */
	public function validParent($check) {
		$check = $check['paste_id'];
		if (empty($check)) {
			return true;
		}
		$parent = $this->find('first', array(
			'conditions' => array('Paste.id' => $check),
			'recursive' => -1,
			'fields' => array('id', 'paste_id')
		));
		if (!$parent) {
			return false;
		}
		return $parent['Paste']['paste_id'] === null;
	}

/**
 * Custom finder for saved pastes. Pastes need to have paste_id = null as well
 * as paste_id != null means its a saved version of a paste.
 *
 */
	protected function _findSaved($state, $query, $results = array()) {
		if ($state === 'before') {
			$conditions = array(
				'Paste.paste_id' => null,
				'Paste.save' => 1,
			);
			$query['conditions'] = array_merge(
				(array)$query['conditions'],
				$conditions
			);
			return $query;
		}
		return $results;
	}

/**
 * Find recent pastes.
 *
 */
	protected function _findRecent($state, $query, $results = array()) {
		if ($state === 'before') {
			$conditions = array(
				'Paste.paste_id' => null,
				'Paste.save' => 1,
			);
			$query['conditions'] = array_merge(
				(array)$query['conditions'],
				$conditions
			);
			if (empty($query['limit'])) {
				$query['limit'] = 10;
			}
			if (empty($query['order'])) {
				$query['order'] = 'Paste.created DESC';
			}
			return $query;
		}
		return $results;
	}

	protected function _findRecentVersions($state, $query, $results = array()) {
		if ($state === 'before') {
			$conditions = array(
				'Paste.paste_id !=' => null,
				'Paste.save' => 1,
			);
			$query['conditions'] = array_merge(
				(array)$query['conditions'],
				$conditions
			);
			if (empty($query['limit'])) {
				$query['limit'] = 10;
			}
			if (empty($query['order'])) {
				$query['order'] = 'Paste.created DESC';
			}
			return $query;
		}
		return $results;
	}

/**
 * Deletes temporary pastes.
 *
 * @return boolean
 */
	public function purgeTemporary() {
		$conditions = array(
			'Paste.save' => 0,
			'Paste.created <=' => date('Y-m-d', strtotime('-1 day'))
		);
		return $this->deleteAll($conditions);
	}

	public function languages() {
		if (!empty($this->_languages)) {
			return $this->_languages;
		}
		$geshiDir = App::pluginPath('Geshi') . 'Vendor/geshi/';

		$names = array();
		$Folder = new Folder($geshiDir);
		$languages = $Folder->read(true, true);
		if (!empty($languages[1])) {
			foreach ($languages[1] as $lang) {
				$names[substr($lang, 0, strlen($lang) - 4)] = substr($lang, 0, strlen($lang) - 4);
			}
		}
		$this->_languages = $names;
		return $this->_languages;
	}

}
