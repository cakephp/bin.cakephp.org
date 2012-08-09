<div class="paste" id="saved">

<?php
if (!empty($original) || !empty($versions)):
	echo $this->element('versions');
endif;
?>

<div class="pastes">
	<div class="left">
		<span class="date">
			<?php echo $this->Time->format('m.d', $paste['Paste']['created']);?>
		</span>
		<span class="lang">
			<?php echo h($paste['Paste']['lang']); ?>
		</span>
		<?php if ($paste['Paste']['save']): ?>
			<span class="saved">
				saved
			</span>
		<?php endif;?>
	</div>

	<span class="nick">
		<?php echo $this->Html->link($paste['Paste']['nick'], array('action' => 'nick', $paste['Paste']['nick'])); ?>
	</span>

	<?php if($paste['Paste']['save']):?>
		<div class="tags">
			Tags
			<?php echo $this->Html->link(
				'add more',
				array('controller' => 'pastes', 'action' => 'tag', $paste['Paste']['id']),
				array('update'=>'tags')
			);
			?>
		</div>
		<div id="tags">
			<?php echo $this->Cakebin->aList($paste['Tag']);?>
			&nbsp;
		</div>
	<?php endif;?>
</div>

<div class="note">
	<strong>Note</strong> <br/>
	<?php
		if (empty($paste['Paste']['note'])):
			echo h($paste['Paste']['nick']) . ' did not leave a note';
		else:
			echo nl2br(h($paste['Paste']['note']));
		endif;
	?>
</div>

<div class="code body" lang="<?php echo h($paste['Paste']['lang']); ?>">
	<?php echo $this->Geshi->highlightText($paste['Paste']['body'], $paste['Paste']['lang']);?>
</div>

</div>
<?php echo $this->element('modify'); ?>
