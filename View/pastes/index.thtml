<div class="pastes">

<?php foreach ($pastes as $paste):?>
	
	<div class="body">
		<a href="<?php echo $this->Html->url('/saved/'.$paste['Paste']['id'])?>">
			<div class="left">
				<span class="date">
					<?php echo $this->Time->format('m.d', $paste['Paste']['created']);?>
				</span>
				<span class="lang">
					<?php echo $paste['Paste']['lang'];?>
				</span>
			</div>
	
			<span class="nick">
				<?php echo $paste['Paste']['nick'];?>
			</span>
	
		
			<span class="note">
				<?php echo $this->Text->truncate(strip_tags($this->Cakebin->htmldecode($paste['Paste']['note'])));?>
			</span>
			
			<span class="note">
				<?php echo $this->Text->truncate(strip_tags($this->Cakebin->htmldecode($paste['Paste']['body'])));?>
			</span>
		</a>
	</div>
	
<?php endforeach;?>
</div>

<div class="paging">
	<?php $this->Paginator->options(array('url'=> array('nick'=> $nick)));?>
	<?php echo $this->Paginator->prev('<< '.__('previous'), array(), null, array('class'=>'disabled'));?>
 | 	<?php echo $this->Paginator->numbers();?>
	<?php echo $this->Paginator->next(__('next').' >>', array(), null, array('class'=>'disabled'));?>
</div>

<?php
echo $this->element('tag_cloud');
?>