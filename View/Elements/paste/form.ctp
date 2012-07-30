<?php
/**
 * Add / Edit / Update form
 */
?>
<?php echo $this->Form->create('Paste', array('action' => 'save')); ?>
	<?php echo $this->Form->hidden('Paste.id'); ?>
	<?php echo $this->Form->hidden('Paste.temp'); ?>
	<div class="left">
		<?php
		echo $this->Form->input('Paste.body', array(
			'label' => false,
			'type' => 'textarea',
			'cols' => 70,
			'rows' => 26
		));
		?>
	</div>
	<div class="right">
		<?php
		echo $this->Form->input('Paste.nick', array(
			'size' => 30
		));
		echo $this->Form->input('Paste.lang', array(
			'label' => 'Language',
			'options' => $languages
		));
		?>
		<div class="optional">
			<?php
			echo $this->Form->input('Paste.note', array(
				'label' => 'Note',
				'type' => 'textarea',
				'cols' => 34,
				'rows' => 4
			));
			?>
		</div>
		<div class="optional"> 
			<?php
			echo $this->Form->input('Paste.save', array(
				'type' => 'checkbox',
				'label' => 'Save',
				'onclick' => 'Element.toggle("tags");'
			));
			?>
			<br class="clear"/>
			<em>^saved pastes turn on <?php echo $this->Html->link('versioning', '/pages/about');?></em><br/>
			<em>^temp pastes last for one day</em>
		</div>
		<div id="tags" style="display:none" class="optional">
			<?php
			echo $this->Form->tags('Paste.tags', array(
				'label' => array(
					'text' => 'Tags <em>comma separated</em>',
					'escape' => false
				),
				'size' => 36
			));
			?>
		</div>
	</div>
	<div class="left">
		<?php echo $this->Form->submit('Submit');?>
	</div>
<?php echo $this->Form->end();?>
