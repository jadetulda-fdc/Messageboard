<?php

class Message extends AppModel {

    public $validate = array(
        'recipient' => array(
            'required' => array(
                'rule' => 'notBlank',
                'message' => 'Please select a recipient.'
            )
        )
    );

    // Relationship
    public $hasMany = array(
        'MessageDetail' => array(
            'className' => 'MessageDetail',
            'foreignKey' => 'message_id',
            'order' => 'MessageDetail.created_at DESC',
        )
    );

    public $hasOne = array(
        'Profile1' => array(
            'className' => 'Profile',
            'foreignKey' => false,
            'conditions' => array('`Message`.`first_user_id_in_thread` = `Profile1`.`user_id`')
        ),
        'Profile2' => array(
            'className' => 'Profile',
            'foreignKey' => false,
            'conditions' => array('`Message`.`second_user_id_in_thread` = `Profile2`.`user_id`')
        )
    );

    public function touch($id) {
        $this->id = $id;
        $this->set(array('modified_at' => date_format(new DateTime(), 'Y-m-d H:i:s')));
        $this->save();
    }
}
