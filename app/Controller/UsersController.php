<?php

class UsersController extends AppController {

    public $components = array('RequestHandler');

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('register', 'logout');

        // block access to login and register if logged in
        if (in_array($this->action, array('login', 'register')) && $this->Auth->user())
            return $this->redirect($this->Auth->redirectUrl());
    }

    public function isAuthorized() {

        return true;
    }

    public function login() {
        if ($this->request->is('post')) {
            if ($this->Auth->login()) {
                $this->User->id = $this->Auth->user()['id'];
                $this->User->set(array('last_login_time' => date('Y-m-d H:i:s')));
                $this->User->save();

                return $this->redirect($this->Auth->redirectUrl());
            } else {
                $this->Flash->error('Your username/password entered was incorrect.', array(
                    'key' => 'loginError'
                ));
            }
        }
    }

    public function index() {
        $this->set('users', $this->User->find('all'));
    }

    public function register() {
        if ($this->request->is('post')) {
            $this->User->create();

            // Create profile
            $this->loadModel('Profile');
            $this->Profile->create();
            $this->Profile->set(array(
                'name' => $this->request->data['User']['name'],
                'profile_picture' => 'profile/profile-pic.png'
            ));

            $isValidAll = true;

            if (!$this->Profile->validates()) {
                $this->Flash->error($this->Profile->validationErrors);
                $isValidAll = false;
            }

            $this->User->set($this->request->data);
            if (!$this->User->validates()) {
                $this->Flash->error($this->validationErrors);
                $isValidAll = false;
            }

            if (!$isValidAll) {
                return false;
            }

            $this->User->save($this->request->data, array('validate' => false));

            $this->request->data['User'] = array_merge(
                $this->request->data['User'],
                array('id' => $this->User->id)
            );

            $this->Profile->set('user_id', $this->User->id);
            $this->Profile->save();

            // Auto login
            $this->Flash->success('Thank you for registering!', array(
                'key' => 'register'
            ));
            $this->Auth->login($this->request->data['User']);
            $this->render('register_success');
        }
    }

    public function logout() {
        return $this->redirect($this->Auth->logout());
    }

    // API methods
    public function recipient_list() {
        // $this->layout = false;
        // $response = array(
        //     'status' => 'failed',
        //     'message' => 'Failed to process request.'
        // );

        // $result = $this->User->find('list', array(
        //     'conditions' => array('User.id != ' => $this->Auth->user('id'))
        // ));

        // if (!empty($result)) {
        //     $response = array('status' => 'sucess', 'data' => $result);
        // } else {
        //     $response['message'] = 'Found no matching data.';
        // }

        // $this->response->type('application/json');
        // $this->response->body(json_encode($response));
        // return $this->response->send();
    }
}
