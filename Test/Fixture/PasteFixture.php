<?php
/**
 * PasteFixture
 *
 */
class PasteFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'temp' => array('type' => 'integer', 'null' => false, 'default' => '0', 'key' => 'index'),
		'paste_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'key' => 'index'),
		'nick' => array('type' => 'string', 'null' => false, 'length' => 250, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'lang' => array('type' => 'string', 'null' => false, 'length' => 50, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'note' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'body' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'save' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'remove' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'temp' => array('column' => 'temp', 'unique' => 0),
			'paste_id' => array('column' => 'paste_id', 'unique' => 0)
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
			'temp' => 0,
			'paste_id' => null,
			'nick' => 'mark',
			'lang' => 'php',
			'note' => 'php is a fun language, saved paste',
			'body' => '<?php echo "fun";',
			'created' => '2012-07-15 21:48:53',
			'modified' => '2012-07-15 21:48:53',
			'save' => 1,
			'remove' => 1
		),
		array(
			'id' => 2,
			'temp' => 0,
			'paste_id' => 1,
			'nick' => 'phil',
			'lang' => 'php',
			'note' => 'I updated your paste',
			'body' => '<?php echo "fun bunnies";',
			'created' => '2012-07-15 21:48:53',
			'modified' => '2012-07-15 21:48:53',
			'save' => 1,
			'remove' => 1
		),
		array(
			'id' => 3,
			'temp' => 1,
			'paste_id' => null,
			'nick' => 'mark',
			'lang' => 'php',
			'note' => 'this is temporary',
			'body' => '<?php echo "banana"',
			'created' => '2012-07-15 21:48:53',
			'modified' => '2012-07-15 21:48:53',
			'save' => 0,
			'remove' => 1
		),
		array(
			'id' => 4,
			'temp' => 0,
			'paste_id' => null,
			'nick' => 'phil',
			'lang' => 'php',
			'note' => 'this is saved',
			'body' => '<?php echo "apple"',
			'created' => '2012-02-10 10:48:53',
			'modified' => '2012-02-10 10:48:53',
			'save' => 1,
			'remove' => 1
		),
	);

}
