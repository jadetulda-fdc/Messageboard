<?php

foreach ($thread['MessageDetail'] as $message) {
    $msgDetail = $message['MessageDetail'];
    $profile = $message['Recipient'];

    $is_from_sender = $msgDetail['sender_id'] == AuthComponent::user('id');

    if (!$is_from_sender) {
        $name = $profile['name'];
        $img = $profile['profile_picture'];
    } else {
        $name = 'You';
        $img = AuthComponent::user('Profile.profile_picture');
    }

    echo $this->element('Messages/message-box', compact(['is_from_sender', 'msgDetail', 'img', 'name']));
}
