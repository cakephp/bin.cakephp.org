<div class="versions">
<?php
if(!empty($original['id'])):
?>
	<h4>
		<a href="#" onclick="Element.toggle('original');">
			Original
		</a>
	</h4>
	<div id="original" style="display:none">
		<a href="<?php echo $this->Html->url('/saved/'.$original['id'])?>">
			<span class="date">
				<?php echo $this->Time->format('m.d', $original['created']);?>
			</span>

			<span class="nick">
				<?php echo h($original['nick']); ?>
			</span>

			<span class="note">
				<?php echo h($this->Text->truncate($original['note']));?>
			</span>
		</a>
	</div>
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
<h4>
	<a href="#" onclick="Element.toggle('versions');">
		Versions
	</a>
</h4>
<div id="versions" style="display:none">
<?php 
	foreach ($versions as $paste):
		if ($paste['id'] !== $this->passedArgs[0]):
?>
		<a href="<?php echo $this->Html->url('/saved/'.$paste['id'])?>">
			<span class="date">
				<?php echo $this->Time->format('m.d', $paste['created']);?>
			</span>
	
			<span class="nick">
				<?php echo $paste['nick'];?>
			</span>
	
			<span class="note">
				<?php echo h($this->Text->truncate($paste['note'])); ?>
			</span>
		</a>
<?php
		endif;
	endforeach;
?>
</div>
<?php endif;?>
</div>
