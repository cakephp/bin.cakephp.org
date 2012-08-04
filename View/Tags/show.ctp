<div class="pastes">
<h2>
	<?php echo $tag['Tag']['name'];?>
</h2>
<?php if(empty($tag['Paste'])):?>
<h2 class="error">No pastes match</h2>
<?php else:?>
	<?php foreach ($tag['Paste'] as $paste):?>
		<a href="<?php echo $this->Html->url('/saved/'.$paste['id'])?>">
			<span class="left">
				<span class="date">
					<?php echo $this->Time->format('m.d', $paste['created']);?>
				</span>
		
				<span class="lang">
					<?php echo $paste['lang'];?>
				</span>
			</span>
		
			<span class="nick">
				<?php echo $paste['nick'];?>
			</span>
			
			<span class="note">
				<?php echo h($this->Text->truncate($paste['note']));?>
			</span>
		</a>
	<?php endforeach;?>
<?php endif;?>
</div>
