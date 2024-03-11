<?php

use function PHPSTORM_META\map;

$this->assign('title', 'Login | MessageBoard');
$inputOptions = array(
    'div' => array('class' => 'form-group d-flex'),
    'label' => array('class' => 'col-sm-3 col-form-label text-right'),
    'class' => array('col-sm-9 form-control')
);
$flashMessage = $this->Flash->render();
?>
<div class="text-center">
    <div class="form-sign-in">
        <h1>MESSAGE BOARD</h1>
        <h4>Sign In</h4>
        <div class="form-sign-in-error">
            <?php if ($flashMessage) { ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $flashMessage; ?>
                </div>
            <?php } ?>
        </div>
        <div class="form-sign-in-body">
            <?php
            echo $this->Form->create('User');
            echo $this->Form->input('email', $inputOptions);
            echo $this->Form->input('password', $inputOptions);
            ?>
            <div class="d-flex justify-content-end align-items-center gap-3">
                <?php
                echo $this->Html->link(
                    'No account yet?',
                    array(
                        'controller' => 'users',
                        'action' => 'register'
                    )
                );
                echo $this->Form->button('Login', array(
                    'type' => 'submit',
                    'class' => 'btn btn-primary'
                ));
                ?>
            </div>
            <?php
            echo $this->Form->end();
            ?>
        </div>
    </div>
</div>