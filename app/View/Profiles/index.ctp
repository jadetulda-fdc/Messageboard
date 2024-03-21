<?php
$this->assign('page_header', 'User Profile');
$this->assign('title', 'Profile | MessageBoard');
$profileData = $profile['Profile'];
$userData = $profile['User'];
$flashMessage = $this->Flash->render('positive');
?>

<?php if (isset ($flashMessage)) { ?>
	<div class="alert alert-success text-left" role="alert">
		<?php echo $flashMessage; ?>
	</div>
<?php } ?>
<?php echo $this->element('Profiles/view', compact('profileData', 'userData')); ?>
<div class="mt-4">
	<?php
	echo $this->Html->link(
		'Update Profile',
		array(
			'controller' => 'profiles',
			'action' => 'update'
		),
		array(
			'class' => 'btn btn-primary'
		)
	);
	?>
</div>