<?php
/**
 * Add / Edit / Update form
 */
?>
<?php echo $this->Form->create('Paste', array('action' => 'save')); ?>
	<?php echo $this->Form->hidden('Paste.id'); ?>
	<?php echo $this->Form->hidden('Paste.temp'); ?>

	<div class="row">
		<?php
		echo $this->Form->input('Paste.body', array(
			'div' => array('class' => 'columns eight'),
			'label' => false,
			'type' => 'textarea',
			'class' => 'expand',
			'rows' => 20,
		));
		?>
		<div class="columns four">
		<?php
		echo $this->Form->input('Paste.nick', array(
			'div' => array('class' => 'row form-field'),
			'class' => 'input-text',
			'size' => 30,
		));
		echo $this->Form->input('Paste.lang', array(
			'div' => array('class' => 'row form-field'),
			'label' => 'Language',
			'options' => $languages,
		));
		echo $this->Form->input('Paste.note', array(
			'div' => array('class' => 'row form-field'),
			'label' => 'Note',
			'type' => 'textarea',
			'class' => 'expand',
			'rows' => 4,
		));
		echo $this->Form->input('Paste.save', array(
			'div' => array('class' => 'row form-field'),
			'type' => 'checkbox',
			'label' => array('text' => 'Save', 'class' => 'inline'),
			'after' => ' <span class="example">Saved pastes turn on versioning.</span>',
			'onclick' => 'Element.toggle("tags");'
		));
		echo $this->Form->submit('Submit', array(
			'div' => array('class' => 'row form-field'),
			'class' => 'button red',
		));
		?>
		</div>
	</div>

	<div class="right">
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
<?php echo $this->Form->end();?>
