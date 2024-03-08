<div class="thank-you d-flex flex-column justify-content-center align-items-center">
    <h1>
        <?php
        echo $this->Flash->render();
        ?>
    </h1>
    <?php
    echo $this->Html->link(
        'Back to Homepage',
        array(
            'controller' => 'users',
            'action' => 'index'
        ),
        array('class' => 'btn btn-primary')
    );
    ?>
</div>