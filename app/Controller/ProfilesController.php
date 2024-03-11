<?php

class ProfilesController extends AppController {

    public function index() {
        $this->set('profile', $this->Profile->findByUserId($this->Auth->user()['id']));
    }

    public function update() {
        $profile = $this->Profile->findByUserId($this->Auth->user()['id']);

        if ($this->request->is(array('post', 'put'))) {

            $id = $profile['Profile']['id'];

            $this->Profile->id = $id;
            print_r($this->request->data);
            $file = $this->request->data['Profile']['file_picture'];
            $this->request->data['Profile']['profile_picture'] = 'profile/' . $file['name'];

            if ($this->Profile->save($this->request->data)) {
                // TODO: change filename to unique to user
                move_uploaded_file($file['tmp_name'], WWW_ROOT . 'img/profile/' . $file['name']);
                $this->Flash->success('Your profile has been updated successfully!');
                return $this->redirect(array('action' => 'index'));
            }

            $this->Flash->error('Something went wrong.');
        }

        $this->set('profile', $profile);
    }
}
