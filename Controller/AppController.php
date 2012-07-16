<?php
/**
 * Short description for class.
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		cake
 * @subpackage	cake.app
 */
class AppController extends Controller {

	var $components = array('RequestHandler');

	var $helpers = array('Html', 'Form', 'Cakebin', 'Text', 'Time');

	var $layout = 'v3';

	function redirect($url, $status = null, $exit = true) {
		if(is_array($url)) {
			$url = Router::url($url);
		}
		$ajax = ($this->RequestHandler->isAjax())
		? ($url{0} != '/') ? '/ajax/' : '/ajax' : null;
		parent::redirect($ajax.$url, $status, $exit);
	}
	
}
