<?php
foreach ($messageThreads as $thread) {
    $personToDisplay = $thread['Profile1']['user_id'] == AuthComponent::user('id') ? $thread['Profile2'] : $thread['Profile1'];
    $threadInfo = $thread['ThreadDetail'][0];
?>
    <div class="d-flex p-2 gap message-list-container">
        <div class="col-sm-1 p-0">
            <?php
            echo $this->Html->image(
                $personToDisplay['profile_picture'],
                array(
                    'class' => 'img-thumbnail'
                )
            );
            ?>
        </div>
        <div class="d-flex flex-column justify-content-between col-sm-11 p-0 px-2">
            <div class="last-message-info p-1">
                <div class="msg-context <?php echo strlen($threadInfo['message']) > 100 ? 'text-truncate' : ''; ?>">
                    <?php
                    echo $threadInfo['message'];
                    ?>
                </div>
                <?php if (strlen($threadInfo['message']) > 100) { ?>
                    <span class="see-more">[Show more]</span>
                <?php } ?>
            </div>
            <div class="d-flex justify-content-between align-items-center p-1 message-list-footer">
                <div class="text-uppercase font-weight-bold">
                    <?php echo $personToDisplay['name']; ?>
                </div>
                <div class="d-flex gap-2">
                    <div class="border-right pr-2 align-self-center text-muted" style="font-size: 11px;">
                        <?php
                        if ($threadInfo['sender_id'] == AuthComponent::user('id')) {
                            echo "You replied on, ";
                        } else {
                            echo "Last message was on, ";
                        }
                        ?>
                        <?php
                        echo (new DateTime($threadInfo['modified_at']))->format('M d, Y h:iA');
                        ?>
                    </div>
                    <div class="d-flex justify-content-end gap-2 message-list-action">
                        <?php
                        echo $this->Html->link(
                            '<i class="fa-solid fa-reply"></i>',
                            array(
                                'controller' => 'messages',
                                'action' => 'detail',
                                $thread['Message']['id']
                            ),
                            array(
                                'class' => 'text-primary',
                                'alt' => 'Reply',
                                'title' => 'Reply',
                                'escape' => false
                            )
                        );
                        ?>
                        <a href="#" class="text-danger" alt="Delete" title="Delete">
                            <i class="fa-solid fa-trash"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
}
?>