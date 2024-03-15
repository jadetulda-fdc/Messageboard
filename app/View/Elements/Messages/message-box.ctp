<?php
$owner = $msgDetail['sender_id'] == $sender['user_id'] ? $sender : $recipient;
?>
<div class="d-flex p-1 pt-2 px-2 gap message-detail-container <?php echo $is_from_sender ? 'flex-row-reverse align-self-end' : '' ?>" id="message-container-<?php echo $msgDetail['id']; ?>">
    <div class="col-sm-1 p-0">
        <?php
        echo $this->Html->image(
            $owner['profile_picture'],
            array(
                'class' => 'img-thumbnail',
                'onerror' => "this.onerror=null; this.src='/messageboard/img/profile/profile-pic.png'",
                'width' => '500'
            )
        );
        ?>
    </div>
    <div class="d-flex flex-column justify-content-between col-sm-11 p-0 px-2">
        <div class="last-message-info p-1">
            <div class="msg-context <?php echo strlen($msgDetail['message']) > 100 ? 'text-truncate' : ''; ?>">
                <?php echo nl2br($msgDetail['message']); ?>
            </div>
            <?php if (strlen($msgDetail['message']) > 100) { ?>
                <span class="see-more">[Show more]</span>
            <?php } ?>
        </div>
        <div class="d-flex justify-content-between align-items-center p-1 message-list-footer <?php echo $is_from_sender ? 'flex-row-reverse' : ''; ?>">
            <div class="font-weight-bold text-muted" style="font-size: 11px;">
                <?php
                echo $this->Html->link(
                    $is_from_sender ? 'You' : $owner['name'],
                    array(
                        'controller' => 'profiles',
                        'action' => $is_from_sender ? '/' : 'view',
                        $is_from_sender ? null : $owner['user_id'],
                    )
                );
                ?>
            </div>
            <div class="d-flex gap-2 align-items-center <?php echo $is_from_sender ? 'flex-row-reverse' : ''; ?>">
                <div class=" text-muted" style="font-size: 11px;">
                    <?php echo date_format(new DateTime($msgDetail['created_at']), 'M d, Y h:iA'); ?>
                </div>
                <?php if ($is_from_sender) { ?>
                    <div class="d-flex justify-content-end gap-2 message-list-action">
                        <a href="javascript:void(0);" data-message-id="<?php echo $msgDetail['id']; ?>" class="text-danger delete-msg" alt="Delete" title="Delete">
                            <i class="fa-solid fa-trash"></i>
                        </a>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>