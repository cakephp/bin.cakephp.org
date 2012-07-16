<?php
/* SVN FILE: $Id: app_controller.php 296 2007-07-21 14:08:12Z gwoo $ */
/**
 * Short description for file.
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP versions 4 and 5
 *
 * CakePHP :  Rapid Development Framework <http://www.cakephp.org/>
 * Copyright (c)	2006, Cake Software Foundation, Inc.
 *								1785 E. Sahara Avenue, Suite 490-204
 *								Las Vegas, Nevada 89104
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @filesource
 * @copyright		Copyright (c) 2006, Cake Software Foundation, Inc.
 * @link				http://www.cakefoundation.org/projects/info/cakephp CakePHP Project
 * @package			cake
 * @subpackage		cake.app
 * @since			CakePHP v 0.2.9
 * @version			$Revision: 296 $
 * @modifiedby		$LastChangedBy: gwoo $
 * @lastmodified	$Date: 2007-07-21 09:08:12 -0500 (Sat, 21 Jul 2007) $
 * @license			http://www.opensource.org/licenses/mit-license.php The MIT License
 */
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
	
	var $helpers = array('Html', 'Form', 'Ajax', 'Cakebin', 'Text', 'Time');
	
	var $layout = 'v3';
	
	function redirect($url, $status = null)
	{	
		if(is_array($url)) {
			$url = Router::url($url);
		}
		$ajax = ($this->RequestHandler->isAjax())
		? ($url{0} != '/') ? '/ajax/' : '/ajax' : null;
		parent::redirect($ajax.$url, $status);
	}
	
}
?>