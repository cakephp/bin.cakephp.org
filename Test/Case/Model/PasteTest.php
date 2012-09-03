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

	public function testFindTagged() {
		$results = $this->Paste->find('tagged', array(
			'tagId' => 2
		));
		$this->assertCount(2, $results);
		$this->assertEquals(array(1, 2), Hash::extract($results, '{n}.Paste.id'));
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

	public function testBeforeValidateDefaultData() {
		$data = array(
			'nick' => 'mark',
			'body' => 'new paste',
			'lang' => 'php',
		);
		$this->Paste->create($data);
		$result = $this->Paste->save();

		$this->assertEmpty($this->Paste->validationErrors);
		$this->assertTrue((bool)$result);
		$this->assertTrue(is_numeric($result['Paste']['temp']), 'temp should be a number');
	}

	public function testSaveTagsIsCalled() {
		$data = array(
			'nick' => 'mark',
			'body' => 'new paste',
			'lang' => 'php',
			'save' => 1,
			'tags' => 'new, newer, newest'
		);
		$this->Paste->Tag = $this->getMock('Tag', array(), array(), '', false);
		$this->Paste->Tag->expects($this->once())
			->method('saveTags')
			->with($data['tags'])
			->will($this->returnValue(4, 5, 6));

		$this->Paste->create($data);
		$result = $this->Paste->save();
		$this->assertTrue((bool)$result);
	}

	public function testSaveVersion() {
		$data = array(
			'nick' => 'mark',
			'body' => 'new paste',
			'lang' => 'php',
			'save' => 1,
		);
		$this->Paste->create($data);
		$result = $this->Paste->save();
		$this->assertTrue((bool)$result);

		$originalId = $this->Paste->id;
		$data = array(
			'Paste' => array(
				'id' => $originalId,
				'nick' => 'mark',
				'body' => 'newer paste',
				'lang' => 'php',
				'save' => 1,
			)
		);
		$this->Paste->create($data);
		$result = $this->Paste->save();

		$this->assertTrue((bool)$result);
		$this->assertNotEquals($this->Paste->id, $originalId);

		$result = $this->Paste->read();
		$this->assertEquals($originalId, $result['Paste']['paste_id']);
		$this->assertEquals(date('Y-m-d H:i:s'), $result['Paste']['created']);
	}

	public function testValidParent() {
		$this->assertTrue(
			$this->Paste->validParent(array('paste_id' => null)),
			'null is no parent, should be fine'
		);
		$this->assertTrue(
			$this->Paste->validParent(array('paste_id' => 0)),
			'0 is no parent, should be fine'
		);

		$this->assertFalse(
			$this->Paste->validParent(array('paste_id' => 9999999)),
			'parent does not exist, fail'
		);
		$this->assertFalse(
			$this->Paste->validParent(array('paste_id' => 2)),
			'id = 2 is a child, it cannot be a parent.'
		);
		$this->assertTrue(
			$this->Paste->validParent(array('paste_id' => 3)),
			'id = 3 is not a child, it can be a parent.'
		);
	}

	/**
	 * You shouldn't be able to save a version of a version.
	 * This creates a tree which makes sadfaces.
	 */
	public function testNoSaveTreeOfVersions() {
		$data = $this->Paste->read(null, 2);
		$data['Paste']['save'] = true;
		$data['Paste']['body'] = 'new body';
		$data['Paste']['nick'] = 'new user';

		$this->Paste->create();
		$result = $this->Paste->save($data);
		$this->assertNotEquals($result['Paste']['id'], 2, 'id should change');
		$this->assertEquals('new body', $result['Paste']['body']);
		$this->assertEquals('new user', $result['Paste']['nick']);
		$this->assertEquals(1, $result['Paste']['paste_id'], 'Should be a version of 1');
	}

}
