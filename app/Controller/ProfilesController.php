<?php

class ProfilesController extends AppController {

	public function index() {
		$this->set('profile', $this->Profile->findByUserId($this->Auth->user()['id']));
	}

	public function update() {
		$profile = $this->Profile->findByUserId($this->Auth->user()['id']);
		$isValidAll = true;

		$this->set('profile', $profile);

		if ($this->request->is(array('post', 'put'))) {

			$this->Profile->id = $profile['Profile']['id'];

			// Load User Model
			$this->loadModel('User');
			$this->User->read(null, $this->Auth->user()['id']);

			// Assign to a variable for easy usage
			$file = $this->request->data['Profile']['file_picture'];

			// escape input and re-assign
			$this->request->data['Profile']['hubby'] = h($this->request->data['Profile']['hubby']);
			$this->request->data['Profile']['birthdate'] = (new DateTime($this->request->data['Profile']['birthdate']))->format('Y-m-d');

			if (strlen($file['name']) > 0) {
				$this->addNewImageValidator($file);

				$ext = strchr($file['name'], ".");
				$newFileName = 'profile-' . $profile['Profile']['id'] . '-' . strtolower(str_replace(" ", '-', $this->request->data['Profile']['name']));
				$this->request->data['Profile']['profile_picture'] = 'profile/' . $newFileName . $ext;
			} else {
				if ($profile['Profile']['profile_picture'] === 'profile/profile-pic.png') {
					$this->addDefaultImageValidator();
				}
			}

			// Validate profile details
			$this->Profile->set($this->request->data);
			if (!$this->Profile->validates()) {
				$this->Flash->error($this->validationErrors);
				$isValidAll = false;
			}

			$this->User->validator()
				->add('current_password', array(
					'required' => array(
						'rule' => 'notBlank',
						'message' => 'Current password is required'
					),
					'currentPasswordMatch' => array(
						'rule' => 'ifCurrentPasswordMatch',
						'message' => 'Current password entered doesn\'t match our records.'
					)
				));

			// Validate current password first
			$this->User->set('current_password', $this->request->data['User']['current_password']);

			if (!$this->User->validates(array('fieldList' => array('current_password')))) {
				$this->Flash->error($this->User->validationErrors);
				$isValidAll = false;
			} else {
				// Sanitize New Password for validation
				$this->request->data['User']['password'] = $this->request->data['User']['new_password'];
				$this->request->data['User']['password_confirm'] = $this->request->data['User']['confirm_new_password'];

				// Validate user details on profile update
				$this->User->set($this->request->data);
				if (!$this->User->validates(array(
					'fieldList' => array('email', 'password', 'password_confirm')
				))) {
					$this->Flash->error($this->User->validationErrors);
					$isValidAll = false;
				}
			}

			// checks if all data has been validated
			if (!$isValidAll) {
				return false;
			}

			// save to DB
			$this->Profile->save($this->request->data, array('validate' => false));
			$this->User->save($this->request->data, array('validate' => false));
			$user = $this->User->read(null, $this->Auth->user()['id']);
			$user['User']['Profile'] = $user['Profile'];
			unset($user['User']['password']);
			$this->Session->write('Auth', $user);

			// upload file if there's an attachment of form submit
			if (isset ($newFileName)) {
				move_uploaded_file(
					$file['tmp_name'],
					WWW_ROOT . 'img/profile/' . $newFileName . strchr($file['name'], ".")
				);
			}

			$this->Flash->success('Your profile has been updated successfully!', array(
				'key' => 'positive'
			));
			return $this->redirect(array('action' => 'index'));
		}
	}

	public function view($user_id = null) {
		if (!$user_id) {
			throw new InvalidArgumentException('Invalid Request.');
		}

		$profile = $this->Profile->findByUserId($user_id);

		if (!$profile) {
			throw new MissingModelException('Data not found.');
		}

		$this->set(compact('profile'));
	}

	private function addDefaultImageValidator() {
		// Profile picture is required if using default profile
		$this->Profile->validator()
			->add('file_picture', array(
				'required' => array(
					'rule' => 'profilePictureRequired',
					'message' => 'Please upload something for your profile picture'
				)
			));
	}

	private function addNewImageValidator($file) {
		// Check if there's a file uploaded
		$this->Profile->validator()
			->add('file_picture', array(
				'acceptedFileType' => array(
					'rule' => array(
						'extension', array('gif', 'jpeg', 'jpg', 'png')
					),
					'message' => 'Invalid image type, only accepts .jpg/.jpeg, .gif or .png'
				)
			));
	}
}
