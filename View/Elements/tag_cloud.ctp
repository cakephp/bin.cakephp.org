<?php
$tags = $this->requestAction('/tags/popular');
if(!empty($tags)):?>
<div id="tagcloud">
<h4>Tags</h4>
<?php
	foreach($tags as $tag) {
		$size = ($tag[0]['count'] < '30') ? $tag[0]['count']+10 : '40';
		echo ' '.$this->Html->link($tag['Tag']['name'], '/tags/'.$tag['Tag']['keyname'], array('style'=>'font-size:'.$size.'px'));
	}
?>
</div>
<?php endif;?>
