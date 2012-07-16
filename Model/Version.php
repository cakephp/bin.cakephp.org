<?php
class Version extends AppModel
{
	var $name = 'Version';
	var $useTable = 'versions';
	var $validate = array(
		'paste_id' => VALID_NOT_EMPTY,
		'nick' => VALID_NOT_EMPTY,
		'lang' => VALID_NOT_EMPTY,
		'body' => VALID_NOT_EMPTY,
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
			'Paste' =>
			 array('className' => 'Paste'),

	);

}
?>