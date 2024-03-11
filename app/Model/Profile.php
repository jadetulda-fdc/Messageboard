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
                'message' => 'Selected gender is unidentified.'
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
        'hubby' => array(
            'required' => array(
                'rule' => 'notBlank',
                'message' => 'Please enter something as your hubby.'
            )
        )
    );

    // Relationship
    public $belongsTo = 'User';

    public function isGenderSelected($data) {
        if (in_array($data['gender'], array('Male', 'Female'))) {
            return true;
        }

        return false;
    }
}
