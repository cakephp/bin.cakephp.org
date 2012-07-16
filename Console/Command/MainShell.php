<?php

/**
 * 2011-11-07 ms
 */
class MainShell extends Shell {

	/**
	 * OK:
	 * cake TestShell main
	 * cake TestShell
	 * cake TestShell main -f
	 * ERROR:
	 * cake TestShell -f
	 * 
	 * the default command "main" does not get the correct subcommand parser attached if invoked inexplicitly
	 */
	public function main() {
		$this->out('EXECUTE MAIN');
		
		$this->out(print_r($this->params, true));
		
		$this->out('EXECUTE MAIN END');
	}

	public function getOptionParser() {
		$subcommandParser = array(
			'options' => array(
				'foo'=> array(
					'short' => 'f',
					'help' => __d('cake_console', 'a param test'),
					'boolean' => true
				)
			)
		);
		
		return parent::getOptionParser()
			->description(__d('cake_console', "a test"))
			->addSubcommand('main', array(
				'help' => __d('cake_console', 'test of correct main execution'),
				'parser' => $subcommandParser
			));
	}

}

