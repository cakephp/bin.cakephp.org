<?php if(empty($pastes)):?>
	<h2>your search returned no results.</h2>
<?php else:?>
<div class="pastes">
<h2>
	Search Results
</h2>
<?php foreach ($pastes as $paste):?>
	
	<a href="<?php echo $this->Html->url('/saved/'.$paste['Paste']['id'])?>">
		<span class="left">
			<span class="date">
				<?php echo $this->Time->format('m.d', $paste['Paste']['created']);?>
			</span>
		
			<span class="lang">
				<?php echo h($paste['Paste']['lang']); ?>
			</span>
		</span>
		
		<span class="nick">
			<?php echo h($paste['Paste']['nick']); ?>
		</span>
			
		<span class="note">
			<?php echo h($this->Text->truncate($paste['Paste']['note']));?>
		</span>
	</a>
	
<?php endforeach;?>

</div>
<div class="paging">
	<?php $this->Paginator->options(array('url'=> array('nick'=> $nick)));?>
	<?php echo $this->Paginator->prev('<< '.__('previous'), array(), null, array('class'=>'disabled'));?>
 | <?php echo $this->Paginator->numbers(); ?>
	<?php echo $this->Paginator->next(__('next').' >>', array(), null, array('class'=>'disabled'));?>
</div>

<?php echo $this->element('tag_cloud'); ?>
<?php endif;?>
