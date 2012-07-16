<?php
/**
 * Here, we are connecting '/' (base path) to controller called 'Pages',
 * its action called 'display', and we pass a param to select the view file
 * to use (in this case, /app/views/pages/home.thtml)...
 */
	Router::connect('/', array('controller' => 'pastes', 'action' => 'add'));
	Router::connect('/add/:nick/*', array('controller' => 'pastes', 'action' => 'add', 'nick'=> null));
	Router::connect('/edit/*', array('controller' => 'pastes', 'action' => 'edit'));
	Router::connect('/view/*', array('controller' => 'pastes', 'action' => 'view'));
	Router::connect('/saved/*', array('controller' => 'pastes', 'action' => 'saved', 'page'=>'1'));
	Router::connect('/list/*', array('controller' => 'pastes', 'action' => 'index', 'page'=>'1'));
	Router::connect('/nick/:nick/*', array('controller' => 'pastes', 'action' => 'nick', 'nick'=> null, 'page'=>'1'));
	Router::connect('/search/*', array('controller' => 'pastes', 'action' => 'search', 'page'=>'1'));
	Router::connect('/versions/*', array('controller' => 'versions', 'action' => 'saved'));
	Router::connect('/tags/popular', array('controller' => 'tags', 'action' => 'popular'));
	Router::connect('/tags/*', array('controller' => 'tags', 'action' => 'show'));

	Router::connect('/pages/*', array('controller' => 'pages', 'action' => 'display'));
	Router::connect('/:controller/:action/:nick/*', array('controller' => 'pastes', 'action' => 'index', 'nick'=> null));
