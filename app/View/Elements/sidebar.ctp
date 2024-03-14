<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse" style="display: none !important;">
    <div class="sidebar-sticky pt-3">
        <ul class="nav flex-column">
            <li class="nav-item">
                <?php
                echo $this->Html->link(
                    'Home',
                    array(
                        'controller' => 'users',
                        'action' => 'index'
                    ),
                    array('class' => 'nav-link')
                );
                ?>
            </li>
            <li class="nav-item">
                <?php
                echo $this->Html->link(
                    'Profile',
                    array(
                        'controller' => 'profiles',
                        'action' => 'index'
                    ),
                    array('class' => 'nav-link')
                );
                ?>
            </li>
            <li class="nav-item">
                <?php
                echo $this->Html->link(
                    'Messages',
                    array(
                        'controller' => 'messages',
                        'action' => 'index'
                    ),
                    array('class' => 'nav-link')
                );
                ?>
            </li>
            <li class="nav-item">
                <?php
                echo $this->Html->link(
                    'Compose Message',
                    array(
                        'controller' => 'messages',
                        'action' => 'compose'
                    ),
                    array('class' => 'nav-link')
                );
                ?>
            </li>
        </ul>
    </div>

</nav>