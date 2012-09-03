<?php
App::uses('Tag', 'Model');

/**
 * Tag Test Case
 *
 */
class TagTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.tag',
		'app.paste',
		'app.pastes_tag'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Tag = ClassRegistry::init('Tag');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Tag);

		parent::tearDown();
	}

	public function testSaveTags() {
		$data = 'new, newer, newest';
		$this->Tag->create();
		$result = $this->Tag->saveTags($data);
		$expected = array(4, 5, 6);
		$this->assertEquals($expected, $result);
	
		$tags = $this->Tag->find('count', array(
			'conditions' => array(
				'Tag.keyname' => array('new', 'newer', 'newest')
			)
		));
		$this->assertEquals(3, $tags, 'Tags were not created.');
	}

/**
 * testPopular method
 *
 * @return void
 */
	public function testPopular() {
		$result = $this->Tag->popular();
		$expected = array(
			array(
				'Tag' => array(
					'id' => 2,
					'name' => 'bug',
					'keyname' => 'bug'
				),
				array(
					'count' => 2
				)
			),
			array(
				'Tag' => array(
					'id' => 1,
					'name' => 'code',
					'keyname' => 'code'
				),
				array(
					'count' => 1
				)
			)
		);
		$this->assertEquals($expected, $result);
	}

}
