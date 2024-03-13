<?php

class MessageDetailsController extends AppController {

    public $components = array('RequestHandler');

    public function send_message() {

        if ($this->request->is('ajax')) {
            $this->request->data['MessageDetail']['message'] = h($this->request->data['MessageDetail']['message']);
            if ($this->MessageDetail->save($this->request->data)) {
                $this->MessageDetail->unbindModel(array(
                    'belongsTo' => array('MessageThread')
                ));
                $options['joins'] = array(
                    array(
                        'table' => 'profiles',
                        'alias' => 'Profile',
                        'type' => 'LEFT',
                        'conditions' => array(
                            'MessageDetail.sender_id = Profile.user_id'
                        )
                    ),
                );
                $options['conditions'] = array(
                    'MessageDetail.id' => $this->MessageDetail->id
                );
                $options['fields'] = array(
                    'MessageDetail.*',
                    'Profile.name, Profile.profile_picture'
                );
                $this->set('newMessage', $this->MessageDetail->find('all', $options)[0]);
            }
        }
    }

    public function delete() {

        if ($this->request->is('ajax')) {
            $id = $this->request->data['message_id'];

            $message_detail = $this->MessageDetail->findById($id);

            if (!$message_detail) {
                echo json_encode(['error' => 'Model not found.']);
                die();
            }

            if (!($message_detail['MessageDetail']['sender_id'] == AuthComponent::user('id'))) {
                echo json_encode(['error' => 'Unable to delete messages not owned by you.']);
                die();
            }

            if ($this->MessageDetail->delete($id)) {
                echo json_encode(['success' => 'Deleted']);
                die();
            }
        }
    }
}
