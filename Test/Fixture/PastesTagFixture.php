<?php
/**
 * PastesTagFixture
 *
 */
class PastesTagFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'paste_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10),
		'tag_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10),
		'indexes' => array(
			'PRIMARY' => array('column' => array('paste_id', 'tag_id'), 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'paste_id' => 1,
			'tag_id' => 1
		),
		array(
			'paste_id' => 1,
			'tag_id' => 2
		),
		array(
			'paste_id' => 2,
			'tag_id' => 2
		),
		array(
			'paste_id' => 3,
			'tag_id' => 3
		),
	);

}
