<div class="paste-list">
<?php foreach ($pastes as $paste):?>
	<?php echo $this->element('paste/list-item', compact('paste')); ?>
<?php endforeach;?>
</div>

<div class="paging">
	<?php $this->Paginator->options(array('url'=> array('nick'=> $nick)));?>
	<?php echo $this->Paginator->prev('<< '.__('previous'), array(), null, array('class'=>'disabled'));?>
 |  <?php echo $this->Paginator->numbers();?>
	<?php echo $this->Paginator->next(__('next').' >>', array(), null, array('class'=>'disabled'));?>
</div>

<?php echo $this->element('tag_cloud'); ?>
