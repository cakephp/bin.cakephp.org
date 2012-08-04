<?php
if (!empty($paste)):
	echo $this->Cakebin->aList($paste['Tag']);
endif;
?>

<?php if(!$tags_added):?>
<?php echo $this->Form->create('Paste', array('id'=>'tagform', 'action'=>'tag'));?>
	<div>
		<label for="tag"><em>comma seperated</em><br/>
		<?php echo $this->Form->text('Paste.tags', array('size' => '36')) ?>
	</div>
	<span>
		<?php
	    	echo $ajax->submit('Add', array('update'=>'tags', 'div'=> false));
		?>
		<span id="cancel">
			or <a href="#tag" onclick="Effect.BlindUp('tagform');">Cancel</a>
		</span>
	</span>
</form>
<?php endif;?>
