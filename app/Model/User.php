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
    );

    // Relationship
    public $hasOne = 'Profile';

    public function matchPassword($data) {
        if ($data['password'] === $this->data['User']['password_confirm']) {
            return true;
        }

        return false;
    }

    public function beforeSave($options = array()) {
        if (isset($this->data['User']['password'])) {
            $passwordHasher = new BlowfishPasswordHasher();
            $this->data['User']['password'] = $passwordHasher->hash($this->data['User']['password']);
        }

        return true;
    }
}
