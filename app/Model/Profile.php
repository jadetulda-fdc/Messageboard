<?php

class Profile extends AppModel {

	public $validate = array(
		'name' => array(
			'required' => array(
				'rule' => 'notBlank',
				'message' => 'Name field is required',
			),
			'Name Length' => array(
				'rule' => array('lengthBetween', 5, 20),
				'message' => 'Name field length must be between 5 and 20 charaters only.'
			),
			'valid name format' => array(
				'rule' => '/^[\.a-zA-Z, ]*$/',
				'message' => 'Invalid name format, only accepts a-z, A-Z, `.`, `,`, and spaces.'
			)
		),
		'gender' => array(
			'required' => array(
				'rule' => 'isGenderSelected',
				'message' => 'Selected gender is unidentified.',
				'on' => 'update'
			)
		),
		'birthdate' => array(
			'required' => array(
				'rule' => 'notBlank',
				'message' => 'Birthdate is required.',
				'on' => 'update'
			),
			'date' => array(
				'rule' => 'date',
				'message' => 'Birthdate should be a valid date format',
				'on' => 'update'
			)
		),
		'hubby' => array(
			'required' => array(
				'rule' => 'notBlank',
				'message' => 'Please enter something as your hubby.',
				'on' => 'update'
			)
		),
	);

	// Relationship
	public $belongsTo = 'User';

	public function isGenderSelected($data) {
		if (in_array($data['gender'], array('Male', 'Female'))) {
			return true;
		}

		return false;
	}

	public function profilePictureRequired($data) {
		if (strlen($data['file_picture']['name']) <= 0)
			return false;

		return true;
	}
}
