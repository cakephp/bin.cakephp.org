<?php
class Version extends AppModel
{
	var $name = 'Version';
	var $useTable = 'versions';
	var $validate = array(
		'paste_id' => 'notEmpty',
		'nick' => 'notEmpty',
		'lang' => 'notEmpty',
		'body' => 'notEmpty',
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
			'Paste' => array('className' => 'Paste'),
	);

}
