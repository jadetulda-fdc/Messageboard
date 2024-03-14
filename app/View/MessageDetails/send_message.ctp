<?php
$result = [];
if (count($this->validationErrors['MessageDetail'])) {
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode(array('errors' => $this->validationErrors));
    die();
} else {
    header('response-content: thread-message');
    echo $this->element('Messages/threadMessage', array(
        'is_from_sender' => true,
        'msgDetail' => $newMessage['MessageDetail'],
        'img' => $newMessage['Profile']['profile_picture'],
        'name' => "You"
    ));
    die();
}
