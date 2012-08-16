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
			<?php if ($paste['id'] !== $this->passedArgs[0]): ?>
			<li>
				<a href="<?php echo $this->Html->url(array('controller' => 'pastes', 'action' => 'saved', $paste['id'])); ?>">
					<span class="date">
						<?php echo $this->Time->timeAgoInWords($paste['created']); ?>
					</span>
			
					<span class="nick">
						<?php echo h($paste['nick']); ?>
					</span>
			
					<span class="note">
						<?php echo h($this->Text->truncate($paste['note'])); ?>
					</span>
				</a>
			</li>
			<?php endif; ?>
		<?php endforeach; ?>
		</ul>
	</dd>
<?php endif;?>
</dl>
