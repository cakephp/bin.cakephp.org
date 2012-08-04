<?php if(!empty($recent)):?>
<div id="recent">
<h4>Recently Saved</h4>
<?php foreach ($recent as $paste):?>
	
	<a href="<?php echo $this->Html->url(array('controller' => 'pastes', 'action' => 'saved', $paste['Paste']['id'])); ?>">
		<span class="date">
			<?php echo $this->Time->format('m.d', $paste['Paste']['created']);?>
		</span>
	
		<span class="nick">
			<?php echo $paste['Paste']['nick'];?>
		</span>
	
		<span class="note">
			<?php echo h($this->Text->truncate($paste['Paste']['note']));?>
		</span>
	</a>
	
<?php endforeach;?>
</div>
<?php endif;?>
