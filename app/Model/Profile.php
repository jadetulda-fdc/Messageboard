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
            )
        ),
        'gender' => array(
            'required' => array(
                'rule' => 'isGenderSelected',
                'message' => 'Please select gender.'
            )
        ),
        'birthdate' => array(
            'required' => array(
                'rule' => 'notBlank',
                'message' => 'Birthdate is required.'
            ),
            'date' => array(
                'rule' => 'date',
                'message' => 'Birthdate should be a valid date format'
            )
        ),
        'file_picture' => array(
            'required' => array(
                'rule' => 'profilePictureRequired',
                'message' => 'Please upload something for your profile picture'
            ),
            'acceptedFileType' => array(
                'rule' => array(
                    'extension', array(
                        'gif',
                        'jpeg',
                        'jpg',
                        'png'
                    )
                ),
                'message' => 'Invalid image type, only accepts .jpg/.jpeg, .gif or .png'
            )
        ),
        'hubby' => array(
            'required' => array(
                'rule' => 'notBlank',
                'message' => 'Please enter something as your hubby.'
            )
        )
    );

    // Relationship
    public $belongsTo = 'User';

    public function profilePictureRequired($data) {

        if (strlen($data['file_picture']['name']) <= 0)
            return false;

        return true;
    }

    public function isGenderSelected($data) {
        if (in_array($data['Profile']['gender'], array('Male', 'Female'))) {
            return true;
        }

        return false;
    }
}
