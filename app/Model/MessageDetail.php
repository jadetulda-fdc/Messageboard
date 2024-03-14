<?php

class MessageDetail extends AppModel {

    public $validate = array(
        'message' => array(
            'required' => array(
                'rule' => 'notBlank',
                'message' => 'Cannot send empty message.'
            )
        )
    );

    // Relationship
    public $hasOne = array(
        'Recipient' => array(
            'className' => 'Profile',
            'foreignKey' => false,
            'conditions' => array('`MessageDetail`.`recipient_id` = `Recipient`.`user_id`'),
            'fields' => array('id', 'name', 'profile_picture')
        )
    );
    // public $belongsTo = array(
    //     'MessageThread' => array(
    //         'className' => 'Message',
    //         'foreignKey' => 'message_id'
    //     )
    // );
}
