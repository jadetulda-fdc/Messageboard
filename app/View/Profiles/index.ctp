<?php
$this->assign('page_header', 'User Profile');
$this->assign('title', 'Profile | MessageBoard');
$profileData = $profile['Profile'];
$userData = $profile['User'];
?>

<div id="profile" class="d-flex mb-4 align-items-center">
    <div class="w-25 d-flex pt-3 justify-content-center">
        <?php
        echo $this->Html->image(
            isset($profileData['profile_picture']) ? $profileData['profile_picture'] : 'profile/test-image.png',
            array(
                'width' => 220,
                'height' => 220,
            )
        );
        ?>
    </div>
    <div class="w-75 p-3">
        <div class="p-1">
            <span class="h3">
                <?php echo strtoupper($profileData['name']) ?>
            </span>
        </div>
        <div class="p-1">Gender: <?php echo isset($profileData['gender']) ? $profileData['gender'] : 'Please udpate'; ?></div>
        <div class="p-1">
            Birthdate: <?php echo isset($profileData['gender']) ? $profileData['birthdate'] : 'Please udpate'; ?>
        </div>
        <div class="p-1">
            Joined:
            <?php
            echo $this->Time->format($userData['created_at'], "%B %d, %Y %l:%M %p");
            ?>
        </div>
        <div class="p-1">
            Last Login:
            <?php
            echo isset($userData['last_login_time']) ?
                $this->Time->format($userData['last_login_time'], '%B %d, %Y %l:%M %P') :
                'First time login';
            ?>
        </div>
    </div>
</div>
<div class="d-flex flex-column">
    <p class="h5">Hubby:</p>
    <div class="text-justify"><?php echo strlen($profileData['hubby']) > 0 ? $profileData['hubby'] : 'No data available.'; ?></div>
</div>
<div class="mt-4">
    <?php
    echo $this->Html->link(
        'Update Profile',
        array(
            'controller' => 'profiles',
            'action' => 'update'
        ),
        array(
            'class' => 'btn btn-primary'
        )
    );
    ?>
</div>