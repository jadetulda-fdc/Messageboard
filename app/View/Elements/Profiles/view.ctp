<div id="profile" class="d-flex mb-4 align-items-center">
    <div class="w-25 d-flex pt-3 justify-content-center">
        <?php
        echo $this->Html->image(
            isset($profileData['profile_picture']) ? $profileData['profile_picture'] : 'profile/profile-pic.png',
            array(
                'width' => 220,
                'height' => 220,
                'onerror' => "this.onerror=null; this.src='/messageboard/img/profile/profile-pic.png'"
            )
        );
        ?>
    </div>
    <div class="w-75 p-3 align-items-stretch" style="border: 1px solid #d5d2d2; border-radius: 5px;">
        <div class="p-1">
            <span class="h3">
                <?php echo strtoupper($profileData['name']) ?>,
                <?php echo date_diff(
                    new Datetime($profileData['birthdate']),
                    new DateTime()
                )->format('%y y/o');
                ?>
            </span>
        </div>
        <div class="p-1">
            Gender:
            <?php
            if (isset($profileData['gender'])) {
                echo $profileData['gender'];
            } else {
                if ($profileData['user_id'] == AuthComponent::user('id')) {
                    echo 'Please udpate';
                } else {
                    echo 'No record found';
                }
            }
            ?>
        </div>
        <div class="p-1">
            Birthdate:
            <?php
            if (isset($profileData['birthdate'])) {
                echo (new DateTime($profileData['birthdate']))->format('F d, Y');
            } else {
                if ($profileData['user_id'] == AuthComponent::user('id')) {
                    echo 'Please udpate';
                } else {
                    echo 'No record found';
                }
            }
            ?>
        </div>
        <div class="p-1">
            Joined:
            <?php
            echo (new DateTime($userData['created_at']))->format('F d, Y h:i A');
            ?>
        </div>
        <div class="p-1">
            Last Login:
            <?php

            $lastLogin = "";
            if (phpversion() > "8.0.0") {
                $lastLogin = (new DateTime($userData['last_login_time']))->format('F d,Y h:i A');
            } else {
                $lastLogin = $this->Time->format($userData['last_login_time'], "%B %d, %Y %l:%M %p");
            }

            echo isset($userData['last_login_time']) ?
                $lastLogin :
                'First time login';
            ?>
        </div>
    </div>
</div>
<div class="d-flex flex-column">
    <p class="h5">Hubby:</p>
    <div class="text-justify p-2" style="border: 1px solid #d5d2d2; border-radius: 5px;">
        <?php echo strlen($profileData['hubby']) > 0 ? nl2br($profileData['hubby']) : 'No data available.'; ?>
    </div>
</div>