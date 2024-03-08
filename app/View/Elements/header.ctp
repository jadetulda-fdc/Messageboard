<nav class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
    <a class="navbar-brand col-md-3 col-lg-2 mr-0 px-3" href="#">
        <?php
        echo $this->Html->image('messageboard.png', array(
            'width' => 30,
            'height' => 30
        ));
        ?> Message Board
    </a>
    <ul class="navbar-nav px-3">
        <li class="nav-item text-nowrap">
            <span class="nav-link" href="#">
                <?php
                echo $current_user['email'];
                ?> |
                <?php
                echo $this->Html->link(
                    'Logout',
                    array(
                        'controller' => 'users',
                        'action' => 'logout'
                    )
                );
                ?>
            </span>
        </li>
    </ul>
</nav>