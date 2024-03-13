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
    public $belongsTo = array(
        'MessageThread' => array(
            'className' => 'Message',
            'foreignKey' => 'message_id'
        )
    );
}
