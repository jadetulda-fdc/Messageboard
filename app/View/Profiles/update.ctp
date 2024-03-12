<?php
$this->assign('page_header', 'Update | User Profile');
$this->assign('title', 'Update | MessageBoard');
$profileData = $profile['Profile'];
$userData = $profile['User'];
$checkedMale = false;
$checkedFemale = false;
$gender = null;

if (isset($old_inputs['gender'])) {
	if ($old_inputs['gender'] == 'Male') {
		$checkedMale = true;
	} elseif ($old_inputs['gender'] == 'Female') {
		$checkedFemale = true;
	}
} else {
	if ($profileData['gender'] == 'Male') {
		$checkedMale = true;
	} elseif ($profileData['gender'] == 'Female') {
		$checkedFemale = true;
	}
}

if ($checkedMale) {
	$gender = 'Male';
} elseif ($checkedFemale) {
	$gender = 'Female';
}
?>

<?php
echo $this->Form->create('Profile', array('type' => 'file'));
?>

<?php if ($this->validationErrors && (count($this->validationErrors['Profile']) > 0 || count($this->validationErrors['User']) > 0)) { ?>
	<div class="alert alert-danger text-left" role="alert">
		<ul class="list-group pl-4">
			<?php
			foreach ($this->validationErrors as $modelError => $model) {
				foreach ($model as $error => $msg) {
			?>
					<li><?php echo $msg[0]; ?></li>
			<?php
				}
			}
			?>
		</ul>
	</div>
<?php } ?>
<div id="profile" class="d-flex mb-4 align-items-start">
	<div class="w-25 d-flex flex-column">
		<div class="w-100 d-flex pt-3 justify-content-center mb-4">
			<?php
			echo $this->Html->image(
				isset($profileData['profile_picture']) ? $profileData['profile_picture'] : 'profile/profile-pic.png',
				array(
					'width' => 220,
					'height' => 220,
					'id' => 'profile-img-placeholder'
				)
			);
			?>
		</div>
		<div>
			<input type="file" id="ProfileProfilePicture" name="data[Profile][file_picture]" />
		</div>
	</div>
	<div class="w-75 p-3 align-self-stretch" style="border: 1px solid #d5d2d2; border-radius: 5px;">
		<div class="p-1">
			<div class="d-flex justify-content-between">
				<label for="ProfileName" class="col-form-label">Name</label>
				<?php
				echo $this->Form->input(
					'name',
					array(
						'value' => isset($old_inputs['name']) ? $old_inputs['name'] : $profileData['name'],
						'class' => 'form-control col-sm-8 ' . (isset($this->validationErrors['Profile']['name']) ? 'is-invalid' : ''),
						'label' => false,
						'div' => false,
						'error' => false
					)
				);
				?>
			</div>
		</div>
		<div class="p-1">
			<div class="d-flex justify-content-between align-items-center">
				<legend class="col-form-label">
					Gender
				</legend>
				<div class="col-sm-8 form-control <?php echo (isset($this->validationErrors['Profile']['gender']) ? 'is-invalid' : ''); ?>">
					<div class="form-check form-check-inline">
						<input type="hidden" name="data[Profile][gender]" value="<?php echo $gender ? $gender : ''; ?>">
						<input class="form-check-input" type="radio" name="data[Profile][gender]" id="ProfileGenderMale" value="Male" <?php echo ($gender && $gender == 'Male') ? 'checked' : ''; ?> />
						<label class="form-check-label mr-3" for="ProfileGenderMale">
							Male
						</label>
						<input class="form-check-input" type="radio" name="data[Profile][gender]" id="ProfileGenderFemale" value="Female" <?php echo ($gender && $gender == 'Female') ? 'checked' : ''; ?> />
						<label class="form-check-label" for="ProfileGenderFemale">
							Female
						</label>
					</div>
				</div>
			</div>
		</div>
		<div class="p-1">
			<div class="d-flex justify-content-between">
				<label for="ProfileBirthdate" class="col-form-label">Birthdate</label>
				<input type="text" class="form-control col-sm-8 <?php echo (isset($this->validationErrors['Profile']['birthdate']) ? 'is-invalid' : ''); ?>" name="data[Profile][birthdate]" id="ProfileBirthdate" />
			</div>
		</div>
		<div class="p-1">
			<div class="d-flex justify-content-between">
				<label for="UserCurrentPassword" class="col-form-label">Current Password</label>
				<?php
				echo $this->Form->input(
					'User.current_password',
					array(
						'class' => 'form-control col-sm-8 ' . (isset($this->validationErrors['User']['current_password']) ? 'is-invalid' : ''),
						'placeholder' => 'Enter current password',
						'label' => false,
						'div' => false,
						'error' => false,
						'type' => 'password'
					)
				);
				?>
			</div>
		</div>
		<div class="p-1">
			<div class="d-flex justify-content-between">
				<label for="UserNewPassword" class="col-form-label">New Password</label>
				<?php
				echo $this->Form->input(
					'User.new_password',
					array(
						'class' => 'form-control col-sm-8',
						'placeholder' => 'Enter new password',
						'label' => false,
						'div' => false,
						'error' => false,
						'type' => 'password'
					)
				);
				?>
			</div>
		</div>
		<div class="p-1">
			<div class="d-flex justify-content-between">
				<label for="UserConfirmNewPassword" class="col-form-label">Confirm new password</label>
				<?php
				echo $this->Form->input(
					'User.confirm_new_password',
					array(
						'class' => 'form-control col-sm-8',
						'placeholder' => 'Re-enter new password',
						'label' => false,
						'div' => false,
						'error' => false,
						'type' => 'password'
					)
				);
				?>
			</div>
		</div>
	</div>
</div>
<div class="d-flex flex-column">
	<p class="h5">Hubby:</p>
	<div class="text-justify">
		<?php
		echo $this->Form->textarea(
			'hubby',
			array(
				'class' => 'form-control textarea-autosize ' . (isset($this->validationErrors['Profile']['hubby']) ? 'is-invalid' : ''),
				'placeholder' => 'Write something as your hubby.',
				'value' => html_entity_decode(isset($old_inputs['hubby']) ? $old_inputs['hubby'] : $profileData['hubby']),
				'style' => array('height: 62px;')
			)
		);
		?>
	</div>
</div>
<div class="mt-4">
	<input type="submit" class="btn btn-primary" value="Save">
	<?php
	echo $this->Html->link(
		'Cancel',
		array(
			'controller' => 'profiles',
			'action' => 'index'
		),
		array(
			'class' => 'btn btn-danger'
		)
	);
	?>
</div>
<?php
echo $this->Form->end();
?>

<script>
	$(function() {

		$(".textarea-autosize").textareaAutoSize();

		$birhtdate = '<?php echo $this->Time->format($profileData['birthdate'], '%m/%e/%Y'); ?>';

		$("#ProfileBirthdate").datepicker({
			changeMonth: true,
			changeYear: true,
			maxDate: new Date(),
			showButtonPanel: true,
			// dateFormat: 'yy-mm-dd'
		});

		$("#ProfileBirthdate").datepicker(
			"setDate",
			new Date($birhtdate)
		);

		$("#ProfileProfilePicture").on("change", function(e) {
			const [file] = $(this)[0].files;
			const allowedTypes = [
				'image/png',
				'image/jpeg',
				'image/jpg',
				'image/gif',
			];

			if (file) {
				console.log(URL.createObjectURL(file));
				if (allowedTypes.includes(file.type)) {
					$("#profile-img-placeholder").prop({
						src: URL.createObjectURL(file),
					});
				} else {
					$("#profile-img-placeholder").prop({
						src: '../img/file-error.png'
					});
				}
			}
		});
	});
</script>
<script>
</script>