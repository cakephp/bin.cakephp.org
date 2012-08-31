<?php
/**
 * Add / Edit / Update form
 */

echo $this->Form->create('Paste', array(
	'action' => 'save',
	'class' => 'nice',
));
echo $this->Form->hidden('Paste.id');
echo $this->Form->hidden('Paste.paste_id');
echo $this->Form->hidden('Paste.temp');
?>
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

		// Don't allow saved to be toggled on versions/edit.
		if (empty($this->data['Paste']['save'])):
			echo $this->Form->input('Paste.save', array(
				'div' => array('class' => 'row form-field'),
				'id' => 'save-paste',
				'type' => 'checkbox',
				'label' => array('text' => 'Save', 'class' => 'inline'),
				'after' => ' <span class="example">Saved pastes turn on versioning.</span>',
			));
		else:
			echo $this->Form->hidden('Paste.save');
		endif;
	
		// Don't display on modify forms.
		if (empty($noTags)):
			echo $this->Form->input('Paste.tags', array(
				'div' => array(
					'id' => 'tags',
					'class' => 'hide row form-field'
				),
				'label' => array(
					'text' => 'Tags',
					'class' => 'inline',
				),
				'after' => '<span class="example">comma separated</span>',
				'type' => 'text',
				'size' => 36
			));
		endif;

		echo $this->Form->submit('Submit', array(
			'div' => array('class' => 'row'),
			'class' => 'button red',
		));
		?>
		</div>
	</div>

<?php echo $this->Form->end();?>
