<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>CakeBin : <?php echo $title_for_layout;?></title>
	<?php echo $this->Html->charset();?>
	<link rel="icon" href="<?php echo $this->request->webroot . 'favicon.ico';?>" type="image/x-icon" />
	<link rel="shortcut icon" href="<?php echo $this->request->webroot . 'favicon.ico';?>" type="image/x-icon" />

	<?php echo $this->AssetCompress->css('app.css');?>
	<?php echo $this->AssetCompress->script('app.js');?>
</head>
<body>
<div id="container">
	<?php echo $this->element('Csfnavbar.navbar'); ?>

	<div class="masthead">
		<div class="header-backing"></div>
		<div class="row searchbar">
			<div class="columns three phone-one">
				<?php echo $this->Html->image('cake-logo.png', array('url' => '/', 'width' => 70)); ?>
			</div>
			<div class="columns nine phone-three header-search">
				<?php echo $this->element('search'); ?>
			</div>
		</div>
	</div>

	<div class="navigation-header">
		<div class="row">
			<div class="columns three phone-one">
			<?php echo $this->Html->link('Bin', '/'); ?>
			</div>
			<div class="columns nine phone-three">
			<ul class="navigation">
				<li>
					<?php $css_class = ($this->name == 'Pastes' && $this->request->action == 'index') ? 'on' : null;?>
					<?php echo $this->Html->link('Saved', '/saved', array('class'=>$css_class)); ?>
				</li>
			</ul>
			</div>
		</div>
	</div>

	<div id="content" class="row">
		<div class="columns twelve clearfix">
		<div data-alert="" class="alert-box error">Bin will be removed on June 1, 2014 in favor of <a href="http://gist.github.com" style="color: #E6D273;">http://gist.github.com</a>. Please save all your pastes before then. So long, and thanks for all the fish!<a href="#" class="close">×</a>
</div>
		<?php
			echo $this->Session->flash('flash', array(
				'params' => array(
					'class' => 'alert-box error',
				)
			));
			echo $content_for_layout;
		?>
		</div>
		<div class="footer-push"></div>
	</div>
</div>

<div class="footer">
	<div class="row">
	&copy; <?php echo date('Y'); ?> Cake Software Foundation
	</div>
</div>

</body>
</html>
