<?php

class MessageDetail extends AppModel {

    // Relationship
    public $belongsTo = array(
        'MessageThread' => array(
            'className' => 'Message',
            'foreignKey' => 'message_id'
        )
    );
}
