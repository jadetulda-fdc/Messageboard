<?php
foreach ($thread['MessageDetail'] as $message) {
	$msgDetail = $message['MessageDetail'];
	$is_from_sender = $msgDetail['sender_id'] == AuthComponent::user('id');

	$sender = $message['Sender'];
	$recipient = $message['Recipient'];

	echo $this->element('Messages/message-box', compact(['is_from_sender', 'msgDetail', 'sender', 'recipient']));
}
