<?php
class Paste extends AppModel
{
	var $name = 'Paste';

	var $validate = array(
		'nick' => VALID_NOT_EMPTY,
		'lang' => VALID_NOT_EMPTY,
		'body' => VALID_NOT_EMPTY,
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
			'Original' =>
			 array('className' => 'Paste', 'foreignKey' => 'paste_id')
	);

	var $hasMany = array(
			'Version' =>
			 array('className' => 'Paste'),

	);

	var $hasAndBelongsToMany = array(
			'Tag' =>
			 array('className' => 'Tag'),

	);

}
?>