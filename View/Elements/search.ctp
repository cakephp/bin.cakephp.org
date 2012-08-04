<?php
$q = isset($q) ? $q : null;
echo $this->Form->create('Paste', array(
	'type' => 'get',
	'id' => 'search',
	'url' => array('controller' => 'pastes', 'action' => 'search')
));
echo $this->Form->input('q', array(
	'div' => false,
	'label' => false,
	'size' => 20,
	'value' => $q,
	'class' => 'search-input',
));
echo $this->Form->submit('Search', array(
	'class' => 'submit',
	'div' => false,
	'class' => 'red button submit'
));
echo $this->Form->end();
