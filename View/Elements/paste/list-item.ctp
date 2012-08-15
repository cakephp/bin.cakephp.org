<div class="paste paste-item row">
	<div class="columns four">
	<?php
	echo $this->element('paste/metadata', compact('paste'));
	echo $this->Html->link(
		'view paste',
		array('controller' => 'pastes', 'action' => 'saved', $paste['Paste']['id'])
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
