<?php
$this->assign('page_header', 'Update | User Profile');
$this->assign('title', 'Update | MessageBoard');
$profileData = $profile['Profile'];
$userData = $profile['User'];
?>

<?php
echo $this->Form->create('Profile', array('type' => 'file'));
?>

<?php if ($this->validationErrors && count($this->validationErrors['Profile']) > 0) { ?>
	<div class="alert alert-danger text-left" role="alert">
		<span class="text-uppercase"> <?php echo $this->Flash->render(); ?> </span>
		<ul class="list-group pl-4">
			<?php
			foreach ($this->validationErrors['Profile'] as $error => $msg) {
			?>
				<li><?php echo $msg[0]; ?></li>
			<?php
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
				isset($profileData['profile_picture']) ? $profileData['profile_picture'] : 'profile/test-image.png',
				array(
					'width' => 220,
					'height' => 220,
					'id' => 'profile-img-placeholder'
				)
			);
			?>
		</div>
		<div>
			<input type="file" id="ProfileProfilePicture" name="data[Profile][file_picture]" value="<?php echo $profileData['profile_picture']; ?>" />
		</div>
	</div>
	<div class="w-75 p-3">
		<div class="p-1">
			<div class="d-flex justify-content-between">
				<label for="profile-name" class="col-form-label">Name</label>
				<?php
				echo $this->Form->input(
					'name',
					array(
						'value' => $profileData['name'],
						'class' => 'form-control col-sm-8',
						'label' => false,
						'div' => false
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
				<div class="col-sm-8">
					<div class="form-check form-check-inline">
						<input class="form-check-input" type="radio" name="data[Profile][gender]" id="ProfileGenderMale" value="Male" <?php echo $profileData['gender'] == 'Male' ? 'checked' : ''; ?> />
						<label class="form-check-label mr-3" for="ProfileGenderMale">
							Male
						</label>
						<input class="form-check-input" type="radio" name="data[Profile][gender]" id="ProfileGenderFemale" value="Female" <?php echo $profileData['gender'] == 'Female' ? 'checked' : ''; ?> />
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
				<input type="text" class="form-control col-sm-8" name="data[Profile][birthdate]" id="ProfileBirthdate" />
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
				'class' => 'form-control textarea-autosize',
				'placeholder' => 'Write something as your hubby.',
				'value' => $profileData['hubby'],
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
			dateFormat: 'yy-mm-dd'
		});

		$("#ProfileBirthdate").datepicker(
			"setDate",
			new Date($birhtdate)
		);

		$("#ProfileProfilePicture").on("change", function(e) {
			const [file] = $(this)[0].files;

			if (file) {
				console.log(URL.createObjectURL(file));
				$("#profile-img-placeholder").prop({
					src: URL.createObjectURL(file),
				});
			}
		});
	});
</script>
<script>
</script>