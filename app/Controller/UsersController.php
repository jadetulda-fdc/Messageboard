<?php

class UsersController extends AppController {

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('add');
    }

    public function login() {
        if ($this->request->is('post')) {
            if ($this->Auth->login()) {
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
            $this->User->save($this->request->data);
            // if ($this->User->save($this->request->data)) {
            // $this->Flash->success('You have successfully registered!');
            // return $this->redirect(array('action' => 'index'));
            // }

            $this->Flash->error('Naay error');
        }
    }
}
