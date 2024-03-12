<?php

class UsersController extends AppController {

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
                $this->Flash->error('Your username/password entered was incorrect.');
            }
        }
    }

    public function index() {
        $this->set('users', $this->User->find('all'));
    }

    public function register() {
        if ($this->request->is('post')) {
            $this->User->create();

            $this->User->validator()
                ->add('password', array(
                    'required' => array(
                        'rule' => 'notBlank',
                        'message' => 'Password field is required.'
                    ),
                    'confirm' => array(
                        'rule' => 'matchPassword',
                        'message' => "Password doesn't match.",
                    ),
                ))
                ->add('password_confirm', array(
                    'required' => array(
                        'rule' => 'notBlank',
                        'message' => 'Password confirm field is required.',
                    )
                ));

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
            $this->Flash->success('Thank you for registering!');
            $this->Auth->login($this->request->data['User']);
            $this->render('register_success');
        }
    }

    public function logout() {
        return $this->redirect($this->Auth->logout());
    }
}
