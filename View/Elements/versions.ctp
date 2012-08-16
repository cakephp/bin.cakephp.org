<dl class="versions paste-metadata">
<?php if (!empty($original['id'])): ?>
	<dt>Original</dt>
	<dd id="original">
		<a href="<?php echo $this->Html->url(array('controller' => 'pastes', 'action' => 'saved', $original['id'])); ?>">
			<span class="date">
				<?php echo $this->Time->timeAgoInWords($original['created']); ?>
			</span>

			<span class="nick">
				<?php echo h($original['nick']); ?>
			</span>

			<span class="note">
				<?php echo h($this->Text->truncate($original['note'])); ?>
			</span>
		</a>
	</dd>
<?php
endif;

if (!empty($original['Version'])):
	$versions = $original['Version'];
endif;

if (!empty($paste['Version'])):
	$versions = $paste['Version'];
endif;
?>

<?php if(!empty($versions)): ?>
	<dt>Versions</dt>

	<dd id="versions">
		<ul>
		<?php foreach ($versions as $paste): ?>
			<li>
				<?php $isCurrent = ($paste['id'] === $this->request->pass[0]); ?>

				<?php if (!$isCurrent): ?>
				<a href="<?php echo $this->Html->url(array('controller' => 'pastes', 'action' => 'saved', $paste['id'])); ?>">
				<?php endif; ?>
					<span class="nick">
						<?php echo h($paste['nick']); ?>
					</span>
			
					<span class="date">
						<?php echo $this->Time->timeAgoInWords($paste['created']); ?>
					</span>
			
					<span class="note">
						<?php echo h($this->Text->truncate($paste['note'])); ?>
					</span>
				<?php if (!$isCurrent): ?>
				</a>
				<?php endif; ?>
			</li>
		<?php endforeach; ?>
		</ul>
	</dd>
<?php endif;?>
</dl>
