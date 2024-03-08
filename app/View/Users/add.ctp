<?php
$this->assign('title', 'Register | MessageBoard');
$inputOptions = array(
    'div' => array('class' => 'form-group d-flex'),
    'label' => array('class' => 'col-sm-4 col-form-label text-right'),
    'class' => 'col-sm-8 form-control',
    'error' => false
);
?>
<div class="text-center">
    <div class="form-sign-in">
        <h1>MESSAGE BOARD</h1>
        <h4>Register</h4>
        <div class="form-sign-in-error">
            <?php if ($this->validationErrors) { ?>
                <div class="alert text-left" role="alert">

                    <ul class="list-group">
                        <?php
                        foreach ($this->validationErrors['User'] as $error => $msg) {
                        ?>
                            <li class="list-group-item list-group-item-danger"><?php echo $msg[0]; ?></li>
                        <?php
                        }
                        ?>
                    </ul>
                </div>
            <?php } ?>
        </div>
    </div>
    <div class="form-sign-in-body">
        <?php
        echo $this->Form->create('User');
        echo $this->Form->input('name', $inputOptions);
        echo $this->Form->input('email', $inputOptions);
        echo $this->Form->input('password', $inputOptions);
        echo $this->Form->input('password_confirm', array(
            'div' => $inputOptions['div'],
            'label' => $inputOptions['label'],
            'class' => $inputOptions['class'],
            'type' => 'password'
        ));
        echo $this->Form->button('Register', array(
            'type' => 'submit',
            'class' => 'btn btn-primary',
            'style' => "float: right;"
        ));
        echo $this->Form->end();
        ?>

    </div>
</div>
</div>