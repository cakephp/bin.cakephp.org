<?php
App::import('Vendor', 'Geshi');
App::uses('AppHelper', 'View/Helper');
App::uses('Hash', 'Utility');

class CakebinHelper extends AppHelper {
	
	var $helpers = array('Text');

	function aList($array) {
		if(!empty($array)) {
			$array = Hash::extract($array, '{n}.name');
			if(!empty($array)) {
				asort($array);
				return $this->Text->toList(array_values($array));
			}
		}
		return false;
	}
}
