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
		<?php
		if ($current_user) {
			echo $this->element('header');
		}
		?>
		<div class="container-fluid">
			<div class="row" style="height: 100vh;">
				<?php
				if ($current_user) {
					echo $this->element('sidebar');
				}
				?>

				<?php
				if (!$current_user) {
				?>
					<div id="content" class="m-auto">
						<?php echo $this->fetch('content'); ?>
					</div>
				<?php
				} else {
				?>
					<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
						<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
							<h1 class="h2"><?php echo $this->fetch('page_header'); ?></h1>
						</div>
						<div id="content" class="m-auto">
							<?php echo $this->fetch('content'); ?>
						</div>
					</main>
				<?php
				}
				?>
			</div>
		</div>
	</div>
</body>

</html>