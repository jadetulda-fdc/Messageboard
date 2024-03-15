<?php

class RecipientsController extends AppController {
	public $components = array('RequestHandler');

	public function index() {
		$this->loadModel('User');

		$q = isset($this->request->query['q']) ? $this->request->query['q'] : '';

		$options['fields'] = array(
			'User.id', 'Profile.name', 'Profile.profile_picture'
		);

		$options['conditions'] = array(
			'User.id != ' => $this->Auth->user('id'),
			'Profile.name LIKE' => "%$q%"
		);

		$recipients = $this->User->find('all', $options);

		if (count($recipients)) {
			foreach ($recipients as $recipient) {
				$results['data'][] = [
					'id' => $recipient['User']['id'],
					'text' => $recipient['Profile']['name'],
					'img' => $recipient['Profile']['profile_picture']
				];
			}
		} else {
			$results['data'] = [];
		}

		$results['total_count'] = count($recipients);

		$this->set(array(
			'results' => $results,
			'_serialize' => array('results')
		));
	}
}
