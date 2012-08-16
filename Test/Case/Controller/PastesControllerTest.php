<?php
App::uses('PastesController', 'Controller');

class PastesControllerTestCase extends ControllerTestCase {

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
	 * @expectedException NotFoundException
	 */
	public function testEditNoId() {
		$result = $this->testAction('/edit');
	}

	public function testEditPrepare() {
		$result = $this->testAction('/edit/1', array('method' => 'get', 'return' => 'vars'));

		$this->assertArrayKeyExists('php', $result['languages']);
		$this->assertNull($result['nick']);
	}

	public function testSaveUpdate() {
		$data = array(
			'Paste' => array(
				'id' => 1,
				'temp' => 123456789,
				'nick' => 'mark',
				'lang' => 'php',
				'body' => 'Updated a bin',
			)
		);
		$controller = $this->generate('Pastes', array(
			'components' => array('Security', 'Session')
		));
		$controller->Session->expects($this->once())
			->method('setFlash')
			->with('The Paste is just temporary.');

		$this->testAction('/save/1', array(
			'method' => 'post',
			'return' => 'vars',
			'data' => $data
		));
		$this->assertContains('/view/' . $data['Paste']['temp'], $this->headers['Location'], 'missing redirect');

		$result = ClassRegistry::init('Paste')->read(null, $data['Paste']['id']);
		$this->assertEquals($data['Paste']['body'], $result['Paste']['body']);
	}

	public function testSaveSaved() {
		$data = array(
			'Paste' => array(
				'id' => 1,
				'temp' => 123456789,
				'nick' => 'mark',
				'lang' => 'php',
				'body' => 'Updated a bin',
				'save' => true
			)
		);
		$controller = $this->generate('Pastes', array(
			'components' => array('Security', 'Session')
		));
		$controller->Session->expects($this->once())
			->method('setFlash')
			->with('The Paste is saved');

		$this->testAction('/save/1', array(
			'method' => 'post',
			'return' => 'vars',
			'data' => $data
		));
		$this->assertContains(
			'/saved/',
			$this->headers['Location'],
			'missing redirect'
		);
	}

	public function testIndex() {
		$result = $this->testAction('/list', array(
			'method' => 'get',
			'return' => 'vars',
		));
		$this->assertArrayKeyExists('pastes', $result);
	}

	public function testSearch() {
		$result = $this->testAction('/search?q=this', array(
			'method' => 'get',
			'return' => 'vars',
		));
		$this->assertEquals('this', $result['q']);
		$this->assertArrayHasKey('pastes', $result);
		$this->assertCount(1, $result['pastes']);
	}

	/**
	 * @expectedException NotFoundException
	 */
	public function testViewError() {
		$this->testAction('/view', array(
			'method' => 'get',
		));
	}

	public function testView() {
		$result = $this->testAction('/view/123456789', array(
			'method' => 'get',
			'return' => 'vars'
		));
		$this->assertArrayHasKey('paste', $result);
		$this->assertArrayHasKey('languages', $result);
	}
}
