<h4>
<a href="#modify" onclick="Element.toggle('modify');">
	Modify this Paste
</a>
</h4>
<?php 
$style = null;
if ($this->request->action !='edit'): 
	$style = 'style="display: none;"';
endif;
?>
<div id="modify" <?php echo $style?>>
	<?php echo $this->element('paste/form'); ?>
</div>
