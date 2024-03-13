<?php

use function PHPSTORM_META\map;

class MessagesController extends AppController {

    public function index() {
        $this->Message->bindModel(
            array('hasMany' => array(
                'ThreadDetail' => array(
                    'className' => 'MessageDetail',
                    'foreignKey' => 'message_id',
                    'order' => 'ThreadDetail.created_at DESC',
                    'limit' => 1
                ),
            ))
        );

        $this->Message->unbindModel(
            array('hasMany' => array('MessageDetail'))
        );

        $options['fields'] = array(
            'Message.*',
            'Profile1.user_id, Profile1.name, Profile1.profile_picture',
            'Profile2.user_id, Profile2.name, Profile2.profile_picture',
        );

        $options['joins'] = array(
            array(
                'table' => 'profiles',
                'alias' => 'Profile1',
                'type' => 'LEFT',
                'conditions' => array(
                    'ThreadOwner1.id = Profile1.user_id'
                )
            ),
            array(
                'table' => 'profiles',
                'alias' => 'Profile2',
                'type' => 'LEFT',
                'conditions' => array(
                    'ThreadOwner2.id = Profile2.user_id'
                )
            )
        );

        $options['conditions'] = array(
            'OR' => array(
                'first_user_id_in_thread' => $this->Auth->user('id'),
                'second_user_id_in_thread' => $this->Auth->user('id'),
            )
        );

        $options['order'] = array(
            'Message.modified_at' => 'DESC',
        );

        $messageThreads = $this->Message->find('all', $options);

        $this->set('messageThreads', $messageThreads);
    }

    public function compose() {

        if ($this->request->is('post')) {

            $recipient_id = $this->request->data['Message']['recipient'];
            $sender_id = $this->Auth->user('id');

            // Check if sender/recipient combo exists
            $messageId = $this->isThreadExists([$sender_id, $recipient_id]);

            if (!$messageId) {
                // if none -> new thread
                $this->Message->create();

                $this->request->data['Message']['second_user_id_in_thread'] = $recipient_id;
                $this->request->data['Message']['first_user_id_in_thread'] = $sender_id;

                if ($this->Message->save($this->request->data)) {
                    $this->saveMessage([$this->Message->id, $this->request->data['Message']['message'], $recipient_id]);
                    $this->Flash->success('Message Sent!', array('key' => 'message_sent'));
                    return $this->redirect(array('action' => 'index'));
                }
            } else {
                // else -> append to the existing thread (get thread ID)
                $this->saveMessage([$messageId, $this->request->data['Message']['message'], $recipient_id]);

                // update timestamp of existing message
                // $this->Message->id = $messageId;
                // $this->Message->set('modified_at', (new DateTime())->format('Y-m-d H:i:s'));
                // $this->Message->save();

                $this->Flash->success('Message Sent!', array('key' => 'message_sent'));
                return $this->redirect(array('action' => 'index'));
            }

            $this->Flash->error('Some error occured.', array('key' => 'compose_error'));
        }
    }

    public function detail($id = null) {
        if (!$id) {
            throw new InvalidArgumentException('Invalid Request');
        }
        $error = $this->validationErrors;

        $message = $this->Message->findById($id);
        if (!$message) {
            throw new NotFoundException('Data not found');
        }

        $options['fields'] = array(
            'Profile1.user_id, Profile1.name, Profile1.profile_picture',
            'Profile2.user_id, Profile2.name, Profile2.profile_picture',
        );

        $options['conditions'] = array(
            'Message.id' => $id
        );

        $options['joins'] = array(
            array(
                'table' => 'profiles',
                'alias' => 'Profile1',
                'type' => 'LEFT',
                'conditions' => array(
                    'ThreadOwner1.id = Profile1.user_id'
                )
            ),
            array(
                'table' => 'profiles',
                'alias' => 'Profile2',
                'type' => 'LEFT',
                'conditions' => array(
                    'ThreadOwner2.id = Profile2.user_id'
                )
            )
        );


        $thread = $this->Message->find('first', $options);

        $this->set('thread', $thread);
    }

    /**
     * @param array $data: [0] -> sender_id, [1] -> recipient_id
     * @return Message.id|null
     */
    private function isThreadExists($data) {
        [$sender_id, $recipient_id] = $data;

        $options['fields'] = array(
            'Message.id'
        );

        // query options
        $options['conditions'] = array(
            'OR' => array(
                array(
                    'first_user_id_in_thread' => $sender_id,
                    'second_user_id_in_thread' => $recipient_id
                ),
                array(
                    'first_user_id_in_thread' => $recipient_id,
                    'second_user_id_in_thread' => $sender_id
                )
            )
        );

        $messageThread = $this->Message->find('first', $options);

        return count($messageThread) ? $messageThread['Message']['id'] : 0;
    }

    /**
     * @param array $data: [0] -> message_id, [1] -> message, [2] -> recipient_id
     * @return Message.id|null
     */
    private function saveMessage($data) {
        [$message_id, $message, $recipient_id] = $data;
        $this->loadModel('MessageDetail');

        // insert message to message detail
        $this->MessageDetail->create();
        $this->MessageDetail->set(array(
            'message_id' => $message_id,
            'sender_id' => $this->Auth->user('id'),
            'recipient_id' => $recipient_id,
            'message' => h($message)
        ));
        $this->MessageDetail->save();
    }
}
