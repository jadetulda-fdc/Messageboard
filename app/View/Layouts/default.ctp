<!DOCTYPE html>
<html>

<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $this->fetch('title'); ?>
	</title>
	<?php
	echo $this->Html->meta('icon');

	// echo $this->Html->css('cake.generic');
	echo $this->Html->css('bootstrap.min.css');
	echo $this->Html->css('style.css');
	echo $this->Html->script('jquery-3.7.1.js');
	echo $this->Html->script('bootstrap.min.js');

	echo $this->fetch('meta');
	echo $this->fetch('css');
	echo $this->fetch('script');

	?>
</head>

<body>
	<div id="container">
		<div id="header">
			<h1><?php echo $this->fetch('page_header'); ?></h1>
		</div>
		<div id="content">

			<?php echo $this->Flash->render(); ?>

			<?php echo $this->fetch('content'); ?>
		</div>
	</div>
</body>

</html>