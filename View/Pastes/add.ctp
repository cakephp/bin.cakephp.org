<?php echo $this->Form->create('Paste', array('action' => 'save'));?>
	<div class="left">
		<div class="required">
			<?php echo $this->Form->error('Paste.body', 'Please enter the body.');?>
		 	<?php echo $this->Form->textarea('Paste.body', array('value'=> $this->Cakebin->htmldecode($this->Html->value('Paste.body')),'cols' => '70', 'rows' => '26'));?>
		</div>
	</div>
	<div class="right">
		<em>required*</em>
		<div class="required"> 
			<?php echo $this->Form->label('Paste.nick', 'Nick*');?>
		 	<?php echo $this->Form->text('Paste.nick', array('size' => '30'));?>
			<?php echo $this->Form->error('Paste.nick', 'Please enter the Nick.');?>
		</div>
		<div class="required"> 
			<?php echo $this->Form->label('Paste.lang', 'Language*');?>
			<?php echo $this->Form->select('Paste.lang', $languages); ?>
			<?php echo $this->Form->error('Paste.lang', 'Please enter the Language.');?>
		</div>
		<div class="optional"> 
			<?php echo $this->Form->label('Paste.note', 'Note');?>
		 	<?php echo $this->Form->textarea('Paste.note', array('value'=>$this->Cakebin->htmldecode($this->Html->value('Paste.note')), 'cols' => '34', 'rows' => '4'));?>
		</div>
		<div class="optional"> 
			<?php echo $this->Form->checkbox('Paste.save', array('onclick'=>"Element.toggle('tags');"));?>
			<?php echo $this->Form->label('Paste.save', 'Save');?>
			<br class="clear"/>
			<em>^saved pastes turn on <?php echo $this->Html->link('versioning', '/pages/about');?></em><br/>
			<em>^temp pastes last for one day</em>
		</div>
		<div id="tags" style="display:none" class="optional">
			<label for="tag">Tags <em>comma seperated</em></label> <br/>
		 	<?php echo $this->Form->text('Paste.tags', array('size' => '36')) ?>
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
