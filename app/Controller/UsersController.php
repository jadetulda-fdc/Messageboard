<?php

class UsersController extends AppController {

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('add', 'logout');
    }

    public function login() {
        if ($this->request->is('post')) {
            if ($this->Auth->login()) {
                $this->User->id = $this->Auth->user()['id'];
                $this->User->set(array('last_login_time' => date('Y-m-d H:i:s')));
                $this->User->save();

                return $this->redirect($this->Auth->redirectUrl());
            } else {
                $this->Flash->error('Your username/password entered was incorrect.');
            }
        }
    }

    public function index() {
        $this->set('users', $this->User->find('all'));
    }

    public function add() {
        if ($this->request->is('post')) {
            $this->User->create();

            if ($this->User->save($this->request->data)) {
                $this->Flash->success('Thank you for registering!');
                $this->render('register_success');
            }

            $this->Flash->error($this->validationErrors);
        }
    }

    public function logout() {
        return $this->redirect($this->Auth->logout());
    }
}
