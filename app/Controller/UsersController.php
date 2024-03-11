<?php

class UsersController extends AppController {

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('register', 'logout');
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
                $this->Flash->error('Your username/password entered was incorrect.');
            }
        }

        if ($this->action === 'login' && $this->Auth->user())
            return $this->redirect($this->Auth->redirectUrl());
    }

    public function index() {
        $this->set('users', $this->User->find('all'));
    }

    public function register() {
        if ($this->request->is('post')) {
            $this->User->create();

            if ($this->User->save($this->request->data)) {
                $id = $this->User->id;
                $this->request->data['User'] = array_merge(
                    $this->request->data['User'],
                    array('id' => $id)
                );
                unset($this->request->data['User']['password']);

                // Create profile
                $this->loadModel('Profile');
                $this->Profile->create();
                $this->Profile->set(array(
                    'user_id' => $id,
                    'name' => $this->request->data['User']['name'],
                    'profile_picture' => 'profile/profile-pic.png'
                ));
                $this->Profile->save();

                // Auto login
                $this->Flash->success('Thank you for registering!');
                $this->Auth->login($this->request->data['User']);
                $this->render('register_success');
            }

            $this->Flash->error($this->validationErrors);
        }

        if ($this->action === 'register' && $this->Auth->user())
            return $this->redirect($this->Auth->redirectUrl());
    }

    public function logout() {
        return $this->redirect($this->Auth->logout());
    }
}
