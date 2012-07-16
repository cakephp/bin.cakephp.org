<?php
class Paste extends AppModel
{
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

}
