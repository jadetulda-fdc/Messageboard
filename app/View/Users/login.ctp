<?php
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
        <?php if ($flashMessage) : ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $flashMessage; ?>
            </div>
        <?php endif; ?>
        <?php
        echo $this->Form->create('User');
        echo $this->Form->input('email', $inputOptions);
        echo $this->Form->input('password', $inputOptions);
        echo $this->Form->button('Login', array(
            'type' => 'submit',
            'class' => 'btn btn-primary',
            'style' => "float: right;"
        ));
        echo $this->Form->end();
        ?>
    </div>
</div>