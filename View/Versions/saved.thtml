<?php
if(empty($version)):
	echo '<h2 class="error_message">Error try another one</h2>';
else:
$this->Cakebin->init($version['Version']['lang']);
?>
<h2>
	a Version of <?php echo $version['Paste']['nick']?>'s paste
</h2>
<style>
	.li1 {background:#f4f4f4;}
	.li2 {background:#ffffff;}
	<?php echo $this->Cakebin->get_stylesheet();?>
</style>
<div class="paste" id="saved">

<dl>
	<dt>Nick</dt>
	<dd>
		<span class="saved">
			saved
		</span>
		&nbsp;<?php echo $this->Html->link($version['Version']['nick'], '/list/'.$version['Version']['nick']);?>
	</dd>
	<dt>Lang</dt>
	<dd>&nbsp;<?php echo $version['Version']['lang'];?></dd>
	<dt>Created</dt>
	<dd>&nbsp;<?php echo $this->Time->nice($version['Version']['created']);?></dd>
	<dt>
		Tags
		<?php echo $ajax->link('add more', '/pastes/tag/'.$version['Version']['paste_id'],
								array('update'=>'tags'));
		?>
	</dt>
	<dd id="tags">
		<?php echo $this->Cakebin->aList($version['Paste']['Tag']);?>	
		&nbsp;	
	</dd>
	
</dl>

<div class="note">
	<strong>Note</strong>
	<?php 
		if(empty($version['Version']['note'])):
			echo $version['Version']['nick'] . ' did not leave a note';
		else:
			echo nl2br($this->Cakebin->htmldecode($version['Version']['note']));
		endif;
	?>
</div>
<div class="body">
	<?php echo $this->Cakebin->format($version['Version']['body']);?>
</div>

</div>
<?php endif;?>
