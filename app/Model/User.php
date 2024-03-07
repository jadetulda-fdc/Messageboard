<?php

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
            )
        ),
        'password' => array(
            'required' => array(
                'rule' => 'notBlank',
                'message' => 'Password field is required.'
            )
        ),
        'name' => array(
            'required' => array(
                'rule' => 'notBlank',
                'messaage' => 'Name field is required.'
            )
        )
    );

    public function beforeSave($options = array()) {
        if (isset($this->data['User']['password'])) {
            $this->data['User']['password'] = Security::hash($this->data['User']['password']);
        }

        return true;
    }
}
