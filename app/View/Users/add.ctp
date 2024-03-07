<?php
$this->assign('title', 'Register | MessageBoard');
$inputOptions = array(
    'div' => array('class' => 'form-group d-flex'),
    'label' => array('class' => 'col-sm-3 col-form-label text-right'),
    'class' => 'col-sm-9 form-control'
);
$flashMessage = $this->Flash->render();
?>
<div class="text-center">
    <div class="form-sign-in">
        <h1>MESSAGE BOARD</h1>
        <h4>Register</h4>
        <?php if ($flashMessage) : ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $flashMessage; ?>
                <?php echo $this->Flash->render('auth'); ?>
            </div>
        <?php endif; ?>
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