<?php
App::uses('Paste', 'Model');
App::uses('Hash', 'Utility');

/**
 * Paste Test Case
 *
 */
class PasteTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.paste',
		'app.tag',
		'app.pastes_tag'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Paste = ClassRegistry::init('Paste');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Paste);
		parent::tearDown();
	}

	public function testValidation() {
		$data = array(
			'Paste' => array(
				'nick' => '',
				'lang' => '',
				'body' => ''
			)
		);
		$this->assertFalse($this->Paste->save($data));

		$data = array(
			'Paste' => array(
				'nick' => 'mark',
				'lang' => 'php',
				'body' => '<?php var_dump($foo);'
			)
		);
		$result = $this->Paste->save($data);
		$this->assertTrue((bool) $result);
	}

	public function testFindSaved() {
		$results = $this->Paste->find('saved');
		$this->assertCount(2, $results);
	}

	public function testFindRecent() {
		$results = $this->Paste->find('recent');
		$this->assertCount(2, $results);
		$dates = Hash::extract($results, '{n}.Paste.created');
		$expected = array(
			'2012-07-15 21:48:53',
			'2012-02-10 10:48:53',
		);
		$this->assertEquals($expected, $dates);
	}

	public function testFindRecentVersions() {
		$results = $this->Paste->find('recentVersions');
		$this->assertCount(1, $results);
		$this->assertEquals(1, $results[0]['Paste']['paste_id']);
	}

	public function testPurgeTemporary() {
		$result = $this->Paste->purgeTemporary();
		$this->assertTrue($result);

		$count = $this->Paste->find('count', array(
			'conditions' => array('Paste.save' => 0)
		));
		$this->assertEquals(0, $count);
	}

	public function testLanguages() {
		$result = $this->Paste->languages();
		$this->assertEquals('php', $result['php']);
		$this->assertEquals('javascript', $result['javascript']);
	}

}
