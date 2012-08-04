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

	public $components = array('RequestHandler');

	public $helpers = array('Html', 'Form', 'Cakebin', 'Geshi.Geshi', 'Text', 'Time');

	public $layout = 'v3';

}
