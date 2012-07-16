<?php if(!empty($recent)):?>
<div id="recent">
<h4>Recently Saved</h4>
<?php foreach ($recent as $paste):?>
	
	<a href="<?php echo $this->Html->url('/saved/'.$paste['Paste']['id'])?>">
		<span class="date">
			<?php echo $this->Time->format('m.d', $paste['Paste']['created']);?>
		</span>
	
		<span class="nick">
			<?php echo $paste['Paste']['nick'];?>
		</span>
	
		<span class="note">
			<?php echo $this->Text->truncate(strip_tags($this->Cakebin->htmldecode($paste['Paste']['note'])));?>
		</span>
	</a>
	
<?php endforeach;?>
</div>
<?php endif;?>