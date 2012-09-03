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

/**
 * testSaveTags method
 *
 * @return void
 */
	public function testSaveTags() {
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
