<div class="paste gutter-bottom row">
	<div class="columns four">
	<?php
	echo $this->element('paste/metadata', compact('paste'));
	echo $this->Html->link(
		'View Paste',
		array('controller' => 'pastes', 'action' => 'saved', $paste['Paste']['id']),
		array('class' => 'button pale tiny')
	);
	?>
	</div>
	<div class="columns eight">
		<div class="code body" lang="<?php echo h($paste['Paste']['lang']); ?>">
			<?php
			echo $this->Geshi->highlightText(
				$this->Text->truncate($paste['Paste']['body']), 
				$paste['Paste']['lang']
			);
			?>
		</div>
		<div class="note">
			<?php echo h($this->Text->truncate($paste['Paste']['note'])); ?>
		</div>
		
	</div>
</div>
