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
	echo $this->Html->css('fontawesome/css/all.min.css');
	echo $this->Html->css('/js/plugins/select2/select2.min.css');
	echo $this->Html->css('/js/plugins/jquery/ui/jquery-ui.min.css');
	echo $this->Html->css('style.css');
	echo $this->Html->script('plugins/jquery/jquery-3.7.1.js');
	echo $this->Html->script('bootstrap.min.js');
	echo $this->Html->script('plugins/jquery/ui/jquery-ui.min.js');
	echo $this->Html->script('plugins/select2/select2.min.js');
	echo $this->Html->script('plugins/autosize/textAreaAutoSize.js');

	echo $this->fetch('meta');
	echo $this->fetch('css');
	echo $this->fetch('script');

	?>
</head>

<body>
	<div id="container">
		<?php
		if ($logged_user) {
			echo $this->element('header');
		}
		?>
		<div class="container-fluid">
			<div class="row" style="height: 100vh;">
				<?php
				if ($logged_user) {
					echo $this->element('sidebar');
				}
				?>

				<?php
				if (!$logged_user) {
				?>
					<div id="content" class="m-auto">
						<?php echo $this->fetch('content'); ?>
					</div>
				<?php
				} else {
				?>
					<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
						<div class="d-flex flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom gap-3">
							<div class="align-self-center">
								<!-- <a href="#" class="text-dark"><i class="fa-solid fa-circle-left fa-2x"></i></a> -->
								<?php echo $this->fetch('back_link'); ?>
							</div>
							<div class="h2"><?php echo $this->fetch('page_header'); ?></div>
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