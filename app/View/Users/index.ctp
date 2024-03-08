<?php

use function PHPSTORM_META\map;

$this->assign('title', 'MessageBoard');
?>

<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Email</th>
                <th>Password</th>
                <th>Last Logged In</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($users as $user) {
                $row = $user['User'];
            ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['email']; ?></td>
                    <td><?php echo $row['password']; ?></td>
                    <td><?php echo $row['last_login_time']; ?></td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
    <div class="d-flex">
        <?php
        echo $this->Html->link(
            'Register',
            array(
                'controller' => 'users',
                'action' => 'add'
            ),
            array('class' => 'btn btn-primary mr-2')
        );
        ?>
        <?php
        if (!$current_user) {
            echo $this->Html->link(
                'Login',
                array(
                    'controller' => 'users',
                    'action' => 'login'
                ),
                array('class' => 'btn btn-primary')
            );
        } else {
            echo $this->Html->link(
                'Logout',
                array(
                    'controller' => 'users',
                    'action' => 'logout'
                ),
                array('class' => 'btn btn-danger')
            );
        }
        ?>
    </div>

    <div>
        Logged user: <?php print_r($current_user); ?>
    </div>
</div>