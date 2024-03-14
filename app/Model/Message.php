<?php

class Message extends AppModel {

    // Relationship
    public $hasMany = array(
        'MessageDetail' => array(
            'className' => 'MessageDetail',
            'foreignKey' => 'message_id',
            'order' => 'MessageDetail.created_at DESC',
        )
    );

    public $belongsTo = array(
        'ThreadOwner1' => array(
            'className' => 'User',
            'foreignKey' => 'first_user_id_in_thread',

        ),
        'ThreadOwner2' => array(
            'className' => 'User',
            'foreignKey' => 'second_user_id_in_thread'
        )
    );
}
