<?php

class MessageDetailsController extends AppController {

    public $components = array('RequestHandler');

    public function send_message() {

        if ($this->request->is('ajax')) {
            $this->request->data['MessageDetail']['message'] = h($this->request->data['MessageDetail']['message']);

            if ($this->MessageDetail->save($this->request->data)) {
                $this->loadModel('Message');
                $this->Message->touch($this->request->data['MessageDetail']['message_id']);

                $options['conditions'] = array(
                    'MessageDetail.id' => $this->MessageDetail->id
                );

                $this->set('newMessage', $this->MessageDetail->find('all', $options)[0]);
            }
        }
    }

    public function delete() {

        if ($this->request->is('ajax')) {
            $id = $this->request->data['message_id'];

            $message_detail = $this->MessageDetail->findById($id)['MessageDetail'];

            if (!$message_detail) {
                echo json_encode(['error' => 'Model not found.']);
                die();
            }

            if (!($message_detail['sender_id'] == AuthComponent::user('id'))) {
                echo json_encode(['error' => 'Unable to delete messages not owned by you.']);
                die();
            }

            if ($this->MessageDetail->deleteMessage($id)) {
                $this->loadModel('Message');

                $this->Message->touch($message_detail['message_id']);

                echo json_encode(['success' => 'Deleted']);
                die();
            }
        }
    }
}
