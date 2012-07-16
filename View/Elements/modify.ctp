<h4>
<a href="#modify" onclick="Element.toggle('modify');">
	Modify this Paste
</a>
</h4>
<?php 
$style = null;
if($this->request->action !='edit'): 
	$style = 'style="display: none;"';
endif;
?>
<div id="modify" <?php echo $style?>>
<?php echo $this->Form->create('Paste', array('action'=>'edit'));?>
	<div class="left">
		<div class="required"> 
			<?php echo $this->Form->error('Paste.body', 'Please enter the body.');?>
		 	<?php echo $this->Form->textarea('NewPaste.body', array('value'=>$this->Cakebin->htmldecode($this->Form->value('NewPaste.body')),'cols' => '70', 'rows' => '26'));?>
		</div>
	</div>
	<div class="right">
		<div > 
			<em>required*</em>
		</div>
		<div class="required"> 
			<?php echo $this->Form->label('NewPaste.nick', 'Nick*');?>
		 	<?php echo $this->Form->text('NewPaste.nick', array('size' => '30'));?>
			<?php echo $this->Form->error('Paste.nick', 'Please enter a Nick.');?>
		</div>
		<div class="required"> 
			<?php echo $this->Form->label('NewPaste.lang', 'Language*'); ?>
			<?php echo $this->Form->select('NewPaste.lang', $languages); ?>  
			<?php echo $this->Form->error('Paste.lang', 'Please enter the Language.');?>
		</div>
		<div class="optional"> 
			<?php echo $this->Form->label( 'NewPaste.note', 'Note' );?>
		 	<?php echo $this->Form->textarea('NewPaste.note', array('value'=>$this->Cakebin->htmldecode($this->Form->value('NewPaste.note')), 'cols' => '34', 'rows' => '4'));?>
		</div>
	</div>
	<?php echo $this->Form->hidden('NewPaste.temp');?>
	<?php echo $this->Form->hidden('NewPaste.save');?>
	<?php echo $this->Form->hidden('NewPaste.paste_id');?>
	<?php echo $this->Form->hidden('NewPaste.id');?>
	
	<div class="clear">
		<?php echo $this->Form->input('Other.comment');?>
		<?php echo $this->Form->input('Other.title');?>
		<?php echo $this->Form->input('Other.date');?>
	</div>
	<div class="left">
		<?php echo $this->Form->submit('Submit');?>
	</div>
<?php echo $this->Form->end();?>
</div>
