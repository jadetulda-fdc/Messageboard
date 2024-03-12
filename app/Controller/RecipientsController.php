<?php

class RecipientsController extends AppController {
    public $components = array('RequestHandler');

    public function index() {
        $this->loadModel('User');

        $q = $this->request->query['q'];

        $options['fields'] = array(
            'User.id', 'Profile.name', 'Profile.profile_picture'
        );

        $options['conditions'] = array(
            'Profile.name LIKE' => "%$q%"
        );

        $recipients = $this->User->find('all', $options);

        $results = [];
        foreach ($recipients as $recipient) {
            $results[] = [
                'id' => $recipient['User']['id'],
                'text' => $recipient['Profile']['name'],
                'img' => $recipient['Profile']['profile_picture']
            ];
        }

        $this->set(array(
            'results' => $results,
            '_serialize' => array('results')
        ));

        // Sample data
        // {
        //     "results": [
        //       {
        //         "id": 1,
        //         "text": "Option 1"
        //       },
        //       {
        //         "id": 2,
        //         "text": "Option 2"
        //       }
        //     ],
        //     "pagination": {
        //       "more": true
        //     }
        //   }
    }
}
