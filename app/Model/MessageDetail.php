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
			'fields' => array('id', 'name', 'profile_picture', 'user_id')
		),
		'Sender' => array(
			'className' => 'Profile',
			'foreignKey' => false,
			'conditions' => array('`MessageDetail`.`sender_id` = `Sender`.`user_id`'),
			'fields' => array('id', 'name', 'profile_picture', 'user_id')
		)
	);

	public function deleteMessage($id) {
		$this->id = $id;
		$this->set(array('deleted_at' => date_format(new DateTime(), 'Y-m-d H:i:s')));
		if ($this->save()) {
			$this->touch($id);
			return true;
		}
	}

	public function touch($id) {
		$this->id = $id;
		$this->set(array('modified_at' => date_format(new DateTime(), 'Y-m-d H:i:s')));
		$this->save();
	}

	public function deleteAllRelated($id) {
		$this->unbindModel(array(
			'hasOne' => array('Recipient', 'Sender')
		));
		$timestamp = date_format(new DateTime(), 'Y-m-d H:i:s');
		return $this->updateAll(
			array('deleted_at' => "'$timestamp'"),
			array(
				'message_id = ' => $id,
				'`deleted_at` IS NULL'
			)
		);
	}
}
