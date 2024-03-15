<?php
$this->assign('page_header', 'User Profile');
$this->assign('title', 'Profile | MessageBoard');
$profileData = $profile['Profile'];
$userData = $profile['User'];
?>

<?php echo $this->element('Profiles/view', compact('profileData', 'userData')); ?>