<?php

class MessagesController extends AppController {

	public $components = array('RequestHandler');
	public $helpers = array('Js');

	public function index() {
		$this->Message->bindModel(
			array('hasMany' => array(
				'ThreadDetail' => array(
					'className' => 'MessageDetail',
					'foreignKey' => 'message_id',
					'conditions' => array('ThreadDetail.deleted_at IS NULL'),
					'order' => array('ThreadDetail.created_at' => 'DESC'),
					'limit' => 1
				),
			)),
		);

		$this->Message->unbindModel(
			array('hasMany' => array('MessageDetail'))
		);

		$options = array();

		$search_string = isset ($this->request->data['search_string']) ? $this->request->data['search_string'] : null;

		$this->paginate = array(
			'limit' => 2,
			'order' => array('Message.modified_at' => 'DESC'),
			'conditions' => array(
				'Message.deleted_at IS NULL',
				'AND' => array(
					array(
						'OR' => array(
							"first_user_id_in_thread = " . $this->Auth->user('id'),
							"second_user_id_in_thread = " . $this->Auth->user('id')
						)
					),
					'OR' => array(
						'Profile1.name LIKE ' => "%$search_string%",
						'Profile2.name LIKE ' => "%$search_string%"
					)
				)
			),
			'group' => array('Message.id')
		);

		$this->Paginator->settings = $this->paginate;

		$messageThreads = $this->Paginator->paginate('Message', $options);
		$paginate = $this->params['paging']['Message'];
		$paginate['controller'] = 'messages/index';

		$this->set(compact('messageThreads', 'paginate'));

		if ($this->request->is('ajax')) {
			$view = new View($this, false);
			$content = $view->element('Messages/threadDetail');
			echo json_encode(
				array(
					'html' => $content,
					'paginator' => $paginate
				)
			);
			die();
		}
	}

	public function compose() {

		if ($this->request->is('post')) {
			$this->loadModel('MessageDetail');

			$recipient_id = $this->request->data['Message']['recipient'];
			$sender_id = $this->Auth->user('id');
			$isValidAll = true;

			$this->Message->set($this->request->data);
			if (!$this->Message->validates()) {
				$isValidAll = false;
			}

			$this->MessageDetail->set('message', $this->request->data['Message']['message']);
			if (!$this->MessageDetail->validates(array('fieldList' => array('message')))) {
				$isValidAll = false;
			}

			if (!$isValidAll) {
				$this->Flash->error($this->validationErrors);
				return false;
			}

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

				$this->Flash->error($this->validationErrors);
			} else {
				// else -> append to the existing thread (get thread ID)
				$this->saveMessage([$messageId, $this->request->data['Message']['message'], $recipient_id]);

				// Update Message: modified_at column
				$this->Message->id = $messageId;
				$this->Message->set(array('modified_at' => date_format(new DateTime(), 'Y-m-d H-i:s')));
				$this->Message->save();

				$this->Flash->success('Message Sent!', array('key' => 'message_sent'));
				return $this->redirect(array('action' => 'index'));
			}
		}
	}

	public function search() {
		if ($this->request->is('ajax')) {
			$this->Message->bindModel(
				array('hasMany' => array(
					'ThreadDetail' => array(
						'className' => 'MessageDetail',
						'foreignKey' => 'message_id',
						'conditions' => array('ThreadDetail.deleted_at IS NULL'),
						'order' => array('ThreadDetail.created_at' => 'DESC'),
						'limit' => 1
					),
				)),
			);

			$this->Message->unbindModel(
				array('hasMany' => array('MessageDetail'))
			);

			$options = array();
			$search_string = $this->request->data['Message']['search-item'];

			$this->paginate = array(
				'limit' => 2,
				'order' => array('Message.modified_at' => 'DESC'),
				'conditions' => array(
					'Message.deleted_at IS NULL',
					'AND' => array(
						array(
							'OR' => array(
								"first_user_id_in_thread = " . $this->Auth->user('id'),
								"second_user_id_in_thread = " . $this->Auth->user('id')
							)
						),
						'OR' => array(
							'Profile1.name LIKE ' => "%$search_string%",
							'Profile2.name LIKE ' => "%$search_string%"
						)
					)
				),
				'group' => array('Message.id')
			);

			$this->Paginator->settings = $this->paginate;

			$messageThreads = $this->Paginator->paginate('Message', $options);
			$paginate = $this->params['paging']['Message'];
			$paginate['controller'] = 'messages/index';
			$this->set(compact('messageThreads', 'paginate'));
		}
	}

	public function detail($id = null) {
		if (!$id) {
			throw new InvalidArgumentException('Invalid Request');
		}

		$this->Message->recursive = -1;
		$message = $this->Message->find('first', array(
			'conditions' => array(
				'Message.id' => $id,
				'Message.deleted_at IS NULL',
			)
		));

		if (!$message) {
			throw new NotFoundException('Data not found');
		}

		$users_in_thread = array($message['Message']['first_user_id_in_thread'], $message['Message']['second_user_id_in_thread']);

		if (!in_array(AuthComponent::user('id'), $users_in_thread)) {
			throw new UnauthorizedException('Unauthorized Access.');
		}

		$this->loadModel('MessageDetail');

		$options = array();

		$this->paginate = array(
			'limit' => 10,
			'order' => array('MessageDetail.modified_at' => 'DESC'),
			'conditions' => array(
				'MessageDetail.message_id' => $id,
				'MessageDetail.deleted_at IS NULL'
			),
		);

		$this->Paginator->settings = $this->paginate;

		$thread['MessageDetail'] = $this->Paginator->paginate('MessageDetail', $options);
		$thread['Message'] = $message['Message'];
		$paginate = $this->params['paging']['MessageDetail'];
		$paginate['controller'] = 'messages/detail/' . $id;

		$this->set(compact('thread', 'paginate'));

		if ($this->request->is('ajax')) {
			$view = new View($this, false);
			$content = $view->element('Messages/threadMessage');
			echo json_encode(
				array(
					'html' => $content,
					'paginator' => $paginate
				)
			);
			die();
		}
	}

	public function delete() {
		if ($this->request->is('ajax')) {
			$id = $this->request->data['message_id'];

			$message = $this->Message->findById($id)['Message'];

			if (!$message) {
				echo json_encode(['error' => 'Model not found.']);
				die();
			}

			if ($this->Message->deleteThread($id)) {

				$this->loadModel('MessageDetail');

				if ($this->MessageDetail->deleteAllRelated($id)) {
					echo json_encode(['success' => 'Deleted']);
					die();
				}
			}

			echo json_encode(['error' => 'Action failed.']);
		}
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
			'Message.deleted_at IS NULL',
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
