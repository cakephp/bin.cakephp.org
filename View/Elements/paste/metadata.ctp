<?php
/**
 * Displays a block of metadata for a paste in a list context
 */
?>
<dl class="paste-metadata">
	<dt>Pasted on</dt>
	<dd>
		<?php echo $this->Time->timeAgoInWords($paste['Paste']['created']); ?>
	</dd>

	<dt>Language</dt>
	<dd class="lang">
		<?php echo h($paste['Paste']['lang']); ?>
	</dd>

	<dt>By</dt>
	<dd>
	<?php echo $this->Html->link($paste['Paste']['nick'], array('action' => 'nick', $paste['Paste']['nick'])); ?>
	</dd>
</dl>
