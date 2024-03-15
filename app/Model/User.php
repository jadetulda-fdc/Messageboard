<?php

App::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');

class User extends AppModel {

	public $validate = array(
		'email' => array(
			'required' => array(
				'rule' => 'notBlank',
				'message' => 'Email field is required.'
			),
			'Valid Email' => array(
				'rule' => array('email'),
				'message' => 'Please enter a valid email address'
			),
			'Unique Email' => array(
				'rule' => 'isUnique',
				'message' => 'Email has already been taken.'
			),
		),
		'password' => array(
			'required' => array(
				'rule' => 'notBlank',
				'message' => 'Password field is required.'
			),
			'confirm' => array(
				'rule' => 'matchPassword',
				'message' => "Password doesn't match.",
			),
		),
		'password_confirm' => array(
			'required' => array(
				'rule' => 'notBlank',
				'message' => 'Password confirm field is required.',
			)
		)
	);

	// Relationship
	public $hasOne = array(
		'Profile' => array(
			'className' => 'Profile',
			'foreignKey' => 'user_id',
			'dependent' => true
		)
	);

	public $hasMany = array(
		'MessageSent' => array(
			'className' => 'Message',
			'foreignKey' => 'first_user_id_in_thread',
		),
		'MessageReceived' => array(
			'className' => 'Message',
			'foreignKey' => 'second_user_id_in_thread'
		)
	);

	public function matchPassword($data) {
		if ($data['password'] === $this->data['User']['password_confirm']) {
			return true;
		}

		return false;
	}

	public function ifCurrentPasswordMatch($data) {
		$passwordHasher = new BlowfishPasswordHasher();
		return $passwordHasher->check($data['current_password'], $this->data['User']['password']);
	}

	public function beforeSave($options = array()) {
		if (isset($this->data['User']['password'])) {
			$passwordHasher = new BlowfishPasswordHasher();
			$this->data['User']['password'] = $passwordHasher->hash($this->data['User']['password']);
		}

		return true;
	}
}
