<?php

class ProfilesController extends AppController {

    public function index() {
        $this->set('profile', $this->Profile->findByUserId($this->Auth->user()['id']));
    }

    public function update() {
        $profile = $this->Profile->findByUserId($this->Auth->user()['id']);

        if ($this->request->is(array('post', 'put'))) {

            $this->Profile->id = $profile['Profile']['id'];

            $file = $this->request->data['Profile']['file_picture'];

            // Profile picture is required if using default profile
            if ($profile['Profile']['profile_picture'] === 'profile/profile-pic.png') {
                $this->Profile->validator()
                    ->add('file_picture', array(
                        'required' => array(
                            'rule' => 'profilePictureRequired',
                            'message' => 'Please upload something for your profile picture'
                        )
                    ));
            }

            if (strlen($file['name']) > 0) { //means there's a file upload
                $this->Profile->validator()
                    ->add('file_picture', array(
                        'acceptedFileType' => array(
                            'rule' => array(
                                'extension', array(
                                    'gif',
                                    'jpeg',
                                    'jpg',
                                    'png'
                                )
                            ),
                            'message' => 'Invalid image type, only accepts .jpg/.jpeg, .gif or .png'
                        )
                    ));

                $ext = strchr($file['name'], ".");
                $newFileName = 'profile-' . $profile['Profile']['id'] . '-' . strtolower(str_replace(" ", '-', $this->request->data['Profile']['name']));

                $this->request->data['Profile']['profile_picture'] = 'profile/' . $newFileName . $ext;
            }

            $this->request->data['Profile']['hubby'] = h($this->request->data['Profile']['hubby']);

            if ($this->Profile->save($this->request->data)) {
                if (isset($newFileName)) {
                    move_uploaded_file(
                        $file['tmp_name'],
                        WWW_ROOT . 'img/profile/' . $newFileName . $ext
                    );
                }

                $this->Flash->success('Your profile has been updated successfully!');
                return $this->redirect(array('action' => 'index'));
            }

            $this->Flash->error('Something went wrong.');
        }

        $this->set('profile', $profile);
    }

    public function profilePictureRequired($data) {

        if (strlen($data['file_picture']['name']) <= 0)
            return false;

        return true;
    }
}
