<?php
/**
 * TagFixture
 *
 */
class TagFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'key' => 'primary'),
		'linked' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 10),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 20, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'keyname' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 20, 'key' => 'unique', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'KEYNAME_UNIQUE_INDEX' => array('column' => 'keyname', 'unique' => 1)
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
			'id' => 1,
			'linked' => 1,
			'name' => 'code',
			'keyname' => 'code'
		),
		array(
			'id' => 2,
			'linked' => 1,
			'name' => 'bug',
			'keyname' => 'bug'
		),
		array(
			'id' => 3,
			'linked' => 3,
			'name' => 'php',
			'keyname' => 'php'
		),
	);

}
