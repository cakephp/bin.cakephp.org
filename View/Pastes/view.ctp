<div class="paste" id="saved">
<?php
if(empty($paste)):
	echo '<h2 class="error_message">Error try another one</h2>';
else:
$this->Cakebin->init($paste['Paste']['lang']);
?>

<style>
	.li1 {background:#f4f4f4;}
	.li2 {background:#ffffff;}
	<?php echo $this->Cakebin->get_stylesheet();?>
</style>

<?php
if(!empty($original) || !empty($versions)):
	echo $this->element('versions');
endif;
?>

<div class="pastes">
	<div class="left">
		<span class="date">
			<?php echo $this->Time->format('m.d', $paste['Paste']['created']);?>
		</span>
		<span class="lang">
			<?php echo $paste['Paste']['lang'];?>
		</span>
		<?php if($paste['Paste']['save']):?>
			<span class="saved">
				saved
			</span>
		<?php endif;?>
	</div>

	<span class="nick">
		<?php echo $this->Html->link($paste['Paste']['nick'], array('action'=>'nick', $paste['Paste']['nick']));?>
	</span>

	<?php if($paste['Paste']['save']):?>
		<div class="tags">
			Tags
			<?php echo $this->Html->link('add more', '/pastes/tag/'.$paste['Paste']['id'],
									array('update'=>'tags'));
			?>
		</div>
		<div id="tags">
			<?php echo $this->Cakebin->aList($paste['Tag']);?>
			&nbsp;
		</div>
	<?php endif;?>
</div>

<div class="note">
	<strong>Note</strong> <br/>
	<?php 
		if(empty($paste['Paste']['note'])):
			echo $paste['Paste']['nick'] . ' did not leave a note';
		else:
			echo nl2br($this->Cakebin->htmldecode($paste['Paste']['note']));
		endif;
	?>
</div>

<div class="body">
	<?php echo $this->Cakebin->format($paste['Paste']['body']);?>
</div>

<?php endif;?>
</div>

<?php
	echo $this->element('modify');
?>
