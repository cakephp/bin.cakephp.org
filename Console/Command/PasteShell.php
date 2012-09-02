<?php

class PasteShell extends AppShell {

/**
 * Models to load
 *
 * @var array
 */
	public $models = array('Paste');

/**
 * Expire old temporary pastes.
 *
 * @return void
 */
	public function expire() {
		$age = '-1 day';
		if (isset($this->args[0])) {
			$age = $this->args[0];
		}
		$this->Paste->purgeTemporary($age);
	}

	public function getOptionParser() {
		$parser = parent::getOptionParser();
		$parser->addSubcommand('expire', array(
			'help' => 'Remove old temporary pastes from the database.'
		));
		return $parser;
	}
}
