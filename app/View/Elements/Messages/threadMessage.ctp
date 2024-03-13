<!-- class "flex-row-reverse should be removed if message is from someone" -->
<div class="d-flex p-1 pt-2 px-2 gap message-detail-container <?php echo $is_from_sender ? 'flex-row-reverse align-self-end' : '' ?>" id="message-container-<?php echo $message['id']; ?>">
    <div class="col-sm-1 p-0">
        <?php
        echo $this->Html->image(
            $img,
            array(
                'class' => 'img-thumbnail'
            )
        );
        ?>
    </div>
    <div class="d-flex flex-column justify-content-between col-sm-11 p-0 px-2">
        <div class="last-message-info p-1">
            <div class="msg-context">
                <?php echo nl2br($message['message']); ?>
            </div>
        </div>
        <div class="d-flex justify-content-between align-items-center p-1 message-list-footer <?php echo $is_from_sender ? 'flex-row-reverse' : ''; ?>">
            <div class="font-weight-bold text-muted" style="font-size: 11px;">
                <?php echo $name; ?>
            </div>
            <div class="d-flex gap-2 align-items-center <?php echo $is_from_sender ? 'flex-row-reverse' : ''; ?>">
                <div class=" text-muted" style="font-size: 11px;">
                    <?php echo date_format(new DateTime($message['created_at']), 'M d, Y h:iA'); ?>
                </div>
                <?php if ($is_from_sender) { ?>
                    <div class="d-flex justify-content-end gap-2 message-list-action">
                        <a href="javascript:void(0);" data-message-id="<?php echo $message['id']; ?>" class="text-danger delete-msg" alt="Delete" title="Delete">
                            <i class="fa-solid fa-trash"></i>
                        </a>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>