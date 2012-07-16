<?php echo $this->Form->create('Paste', array('action'=>'add'));?>
	<div class="left">
		<div class="required"> 
			<?php echo $this->Form->error('Paste.body', 'Please enter the body.');?>
		 	<?php echo $this->Form->textarea('NewPaste.body', array('value'=> $this->Cakebin->htmldecode($this->Html->value('NewPaste.body')),'cols' => '70', 'rows' => '26'));?>
		</div>
	</div>
	<div class="right">
		<em>required*</em>
		<div class="required"> 
			<?php echo $this->Form->label('NewPaste.nick', 'Nick*');?>
		 	<?php echo $this->Form->text('NewPaste.nick', array('size' => '30'));?>
			<?php echo $this->Form->error('Paste.nick', 'Please enter the Nick.');?>
		</div>
		<div class="required"> 
			<?php echo $this->Form->label('NewPaste.lang', 'Language*');?>
			<?php echo $this->Form->select('NewPaste.lang', $languages, $this->Html->value('NewPaste.lang')) ?>  
			<?php echo $this->Form->error('Paste.lang', 'Please enter the Language.');?>
		</div>
		<div class="optional"> 
			<?php echo $this->Form->label('NewPaste.note', 'Note');?>
		 	<?php echo $this->Form->textarea('NewPaste.note', array('value'=>$this->Cakebin->htmldecode($this->Html->value('NewPaste.note')), 'cols' => '34', 'rows' => '4'));?>
		</div>
		<div class="optional"> 
			<?php echo $this->Form->checkbox('NewPaste.save', array('onclick'=>"Element.toggle('tags');"));?>
			<?php echo $this->Form->label('NewPaste.save', 'Save');?>
			<br class="clear"/>
			<em>^saved pastes turn on <?php echo $this->Html->link('versioning', '/pages/about');?></em><br/>
			<em>^temp pastes last for one day</em>
		</div>
		<div id="tags" style="display:none" class="optional">
			<label for="tag">Tags <em>comma seperated</em></label> <br/>
		 	<?php echo $this->Form->text('NewPaste.tags', array('size' => '36')) ?>
		</div>
	</div>
	<div class="clear">
		<?php echo $this->Form->input('Other.comment');?>
		<?php echo $this->Form->input('Other.title');?>
		<?php echo $this->Form->input('Other.date');?>
	</div>
	<div class="left">
		<?php echo $this->Form->submit('Submit');?>
	</div>
<?php echo $this->Form->end();?>
