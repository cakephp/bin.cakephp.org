<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>CakeBin : <?php echo $title_for_layout;?></title>
<?php echo $html->charset();?>
<link rel="icon" href="<?php echo $this->webroot . 'favicon.ico';?>" type="image/x-icon" />
<link rel="shortcut icon" href="<?php echo $this->webroot . 'favicon.ico';?>" type="image/x-icon" />

<?php echo $html->css('v3/bin');?>

<?php 
	if(isset($javascript)):
		echo $javascript->link(array('prototype', 'effects'));
	endif;
?>
</head>
<body>
<div id="container">
	<div id="header">
		<h1>
			<?php echo $html->link('Bin', '/', null, false, false);?>
		</h1>
	</div>
	<div id="main_nav">
		<ul class="navigation">
			<li>
				<?php $css_class = ($this->name == 'Pastes' && $this->action == 'add') ? 'on' : null;?>
				<?php echo $html->link('New', '/', array('class'=>$css_class)); ?>
			</li>
			<li>
				<?php $css_class = ($this->name == 'Pastes' && $this->action == 'index') ? 'on' : null;?>
				<?php echo $html->link('Saved', '/saved', array('class'=>$css_class)); ?>
			</li>
		</ul>
	</div>
	<div id="secondary_nav">
		<ul class="navigation">
			<li><?php echo $html->link('About CakeBin', '/pages/about');?></li>
			<li><a href="http://cakephp.org/">About CakePHP</a></li>
			<li><a href="http://cakefoundation.org/pages/donations">Donate</a></li>
		</ul>
	</div>
	<div id="sites_nav">
		<ul class="navigation">
			<li class="current"><a href="http://cakephp.org/">CakePHP</a></li>
			<li><a href="http://api.cakephp.org/">API</a></li>
			<li><a href="http://book.cakephp.org/">Docs</a></li>
			<li><a href="http://bakery.cakephp.org/">Bakery</a></li>
			<li><a href="http://live.cakephp.org/">Live</a></li>
			<li><a href="http://cakeforge.org/">Forge</a></li>
			<li><a href="http://github.com/cakephp">Source</a></li>
			<li><a href="http://cakephp.lighthouseapp.com/">Tickets</a></li>
			<li><a href="http://cakeqs.org/">Questions</a></li>
		</ul>
	</div>
	<?php 
		echo $this->element('search');
	?>
	
	<div id="content">
		<?php 
				if ($session->check('Message.flash'))
				{
					$session->flash();
				}
				echo $content_for_layout;
		?>
		<div class="clear"><!----></div>
	</div>
	
	<div class="clear"><!----></div>
	
	<div id="footer">
		&copy; 2007 Cake Software Foundation
		<a href="http://www.cakephp.org/" target="_new" style="display: block;padding: 4px 0;border: 0">
			<?php echo $html->image('cake.power.gif', array('alt'=>"CakePHP : Rapid Development Framework", 'border'=>"0"));?>
		</a>
		
	</div>
</div>
</body>
</html>
