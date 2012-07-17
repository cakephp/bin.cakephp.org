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

}
