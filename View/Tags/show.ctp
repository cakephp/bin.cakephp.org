<div class="pastes">
<h2>
	<?php echo h($tag['Tag']['name']); ?>
</h2>
<?php if(empty($pastes)):?>
<h2 class="error">No pastes match</h2>
<?php else:?>
	<div class="paste-list">
	<?php foreach ($pastes as $paste): ?>
		<?php echo $this->element('paste/list-item', compact('paste')); ?>
	<?php endforeach; ?>
	</div>
<?php endif; ?>
</div>
