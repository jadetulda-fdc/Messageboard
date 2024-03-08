<?php

App::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');

class User extends AppModel {

    public $validate = array(
        'name' => array(
            'required' => array(
                'rule' => 'notBlank',
                'message' => 'Name field is required.'
            ),
            'Name Length' => array(
                'rule' => array('lengthBetween', 5, 20),
                'message' => 'Name field length must be between 5 and 20 charaters only.'
            )
        ),
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
                'message' => "Password doesn't match."
            )
        ),
        'password_confirm' => array(
            'required' => array(
                'rule' => 'notBlank',
                'message' => 'Password confirm field is required.'
            )
        )
    );

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
