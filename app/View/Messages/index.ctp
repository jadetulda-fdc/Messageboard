<?php
$this->assign('page_header', 'Message List');
$this->assign('title', 'Messages | MessageBoard');
?>
<div class="d-flex mb-3">
    <?php
    echo $this->Html->link(
        'New Message',
        array(
            'controller' => 'messages',
            'action' => 'compose'
        ),
        array(
            'class' => 'btn btn-info'
        )
    );
    ?>
</div>
<div class="d-flex flex-column gap-3 mb-3" id="message-list">
    <!-- Note: Each list is generated via component -->
    <div class="d-flex p-2 gap message-list-container">
        <div class="col-sm-1 p-0">
            <?php
            echo $this->Html->image(
                'profile/test-image.png',
                array(
                    'class' => 'img-thumbnail'
                )
            );
            ?>
        </div>
        <div class="d-flex flex-column justify-content-between col-sm-11 p-0 px-2">
            <div class="last-message-info p-1">
                <div class="msg-context">
                    Last Message hereLast Message
                    hereLast Message hereLast Message
                    hereLast Message hereLast Message
                    hereLast Message hereLast Message
                    hereLast Message hereLast Message
                    hereLast Message hereLast Message
                    hereLast Message hereLast Message
                    hereLast Message hereLast Message
                    hereLast Message hereLast Message
                    hereLast Message hereLast Message
                    hereLast Message hereLast Message
                    hereLast Message hereLast Message
                    hereLast Message hereLast Message
                    hereLast Message hereLast Message
                    hereLast Message hereLast Message
                    hereLast Message hereLast Message
                    hereLast Message hereLast Message
                    hereLast Message hereLast Message
                    hereLast Message hereLast Message
                    hereLast Message here
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center p-1 message-list-footer">
                <div class="text-uppercase font-weight-bold">
                    Jade Marthy Tulda
                </div>
                <div class="d-flex gap-2">
                    <div class="border-right pr-2">
                        Tuesday, March 8, 2024 3:40pm
                    </div>
                    <div class="d-flex justify-content-end gap-2 message-list-action">
                        <?php
                        echo $this->Html->link(
                            '<i class="fa-solid fa-reply"></i>',
                            array(
                                'controller' => 'messages',
                                'action' => 'detail'
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
    <div class="d-flex p-2 gap message-list-container">
        <div class="col-sm-1 p-0">
            <?php
            echo $this->Html->image(
                'profile/test-image.png',
                array(
                    'class' => 'img-thumbnail'
                )
            );
            ?>
        </div>
        <div class="d-flex flex-column justify-content-between col-sm-11 p-0 px-2">
            <div class="last-message-info p-1">
                <div class="msg-context">
                    Last Message hereLast Message
                    hereLast Message hereLast Message
                    hereLast Message hereLast Messa
                </div>
            </div>
            <div class="d-flex justify-content-between p-1 message-list-footer">
                <span class="text-uppercase font-weight-bold">Jade Marthy Tulda</span>
                <span>Tuesday, March 8, 2024 3:40pm</span>
            </div>
        </div>
    </div>
</div>
<hr />
<div class="text-center font-italic toAdd">
    Load more messages
</div>
<script>
    $(function() {

        const MESSAGE_LENGTH_LIMIT = 100;

        $("body #message-list .last-message-info").on(
            "click",
            ".see-more",
            function() {
                toggleMessage($(this));
            }
        );

        $messageListContainer = getParentElement(
            $("#message-list .last-message-info")[0],
            "message-list"
        );

        $firstElement = "";

        function toggleMessage(targetEl) {
            const messageContext = targetEl
                .parent()
                .children("div.msg-context");

            if (messageContext.hasClass("text-truncate")) {
                messageContext.removeClass("text-truncate");
                targetEl.text("[Show less]");
            } else {
                messageContext.addClass("text-truncate");
                targetEl.text("[Show more]");
            }
        }

        $("#message-list .last-message-info").each(function(
            index,
            el
        ) {
            if (index == 0) {
                $firstElement = $(this).parent().parent();
            }
            $messageEl = $(this);
            $messageContextEl = $messageEl.children("div.msg-context");

            // create element
            $seeMoreEl = document.createElement("span");
            $seeMoreEl.className = "see-more";
            $seeMoreEl.innerText = "[Show more]";

            const isLong =
                $messageContextEl.text().replace(/\n\s+/g, "").trim()
                .length > MESSAGE_LENGTH_LIMIT;

            if (isLong) {
                $messageContextEl.addClass("text-truncate");
                $messageEl.append($seeMoreEl);
            }
        });

        function getParentElement(element, parentID) {
            if (element && element.id == parentID) {
                return element;
            } else {
                return getParentElement(element.parentNode, parentID);
            }
        }

        $(".toAdd").on("click", function() {
            $firstElement.clone(true).appendTo($messageListContainer);
            $("html, body").animate({
                    scrollTop: $(document).height() - 200
                },
                500
            );
        });
    });
</script>