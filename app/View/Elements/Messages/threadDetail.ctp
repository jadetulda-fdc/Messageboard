<?php
foreach ($messageThreads as $thread) {
    $personToDisplay = $thread['Profile1']['user_id'] == AuthComponent::user('id') ? $thread['Profile2'] : $thread['Profile1'];
    $threadInfo = count($thread['ThreadDetail']) > 0 ? $thread['ThreadDetail'][0] : false;
?>
    <div class="d-flex p-2 gap message-list-container">
        <div class="col-sm-1 p-0">
            <?php
            echo $this->Html->image(
                $personToDisplay['profile_picture'],
                array(
                    'class' => 'img-thumbnail',
                    'onerror' => "this.onerror=null; this.src='/messageboard/img/profile/profile-pic.png'"
                )
            );
            ?>
        </div>
        <div class="d-flex flex-column justify-content-between col-sm-11 p-0 px-2">
            <div class="last-message-info p-1">
                <?php if ($threadInfo) { ?>
                    <div class="msg-context <?php echo strlen($threadInfo['message']) > 100 ? 'text-truncate' : ''; ?>">
                        <?php
                        echo $threadInfo['message'];
                        ?>
                    </div>
                    <?php if (strlen($threadInfo['message']) > 100) { ?>
                        <span class="see-more">[Show more]</span>
                    <?php } ?>
                <?php } else {
                    echo '<span class="font-italic text-muted">No conversation on this thread.</span>';
                } ?>
            </div>
            <div class="d-flex justify-content-between align-items-center p-1 message-list-footer">
                <div class="text-uppercase font-weight-bold">
                    <?php echo $personToDisplay['name']; ?>
                </div>
                <div class="d-flex gap-2">
                    <div class="border-right pr-2 align-self-center text-muted" style="font-size: 11px;">
                        <?php
                        if ($threadInfo) {
                            if ($threadInfo['sender_id'] == AuthComponent::user('id')) {
                                echo "You replied on, ";
                            } else {
                                echo "Last message was on, ";
                            }
                            echo (new DateTime($thread['Message']['modified_at']))->format('M d, Y h:iA');
                        } else {
                            echo "Last message was deleted on, ";
                            echo (new DateTime($thread['Message']['modified_at']))->format('M d, Y h:iA');
                        }
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