<?php

class User extends AppModel {

    public $validate = array(
        'email' => array(
            'Please enter your email' => array(
                'rule' => 'notBlank',
                'message' => 'Please enter your email'
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
        'password'
    );
}
