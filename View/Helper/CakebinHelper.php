<?php
App::uses('AppHelper', 'View/Helper');
App::uses('Hash', 'Utility');

class CakebinHelper extends AppHelper {
	
	public $helpers = array('Text');

	function aList($array) {
		if (!empty($array)) {
			$array = Hash::extract($array, '{n}.name');
			if(!empty($array)) {
				asort($array);
				return h($this->Text->toList(array_values($array)));
			}
		}
		return false;
	}
}
