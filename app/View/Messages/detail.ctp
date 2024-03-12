<?php
$this->assign('page_header', 'Message Thread');
$this->assign('title', 'Thread | Messageboard');
?>
<div class="d-flex mb-3 gap-2">
    <textarea name="reply-message" placeholder="Write a message" class="form-control textarea-autosize" style="height: 62px"></textarea>
    <button class="btn btn-info align-self-start" id="send-reply">
        Send
    </button>
</div>
<hr />
<div class="d-flex flex-column gap-3 mb-3" id="message-list">
    <!-- Note: Each list is generated via component -->
    <!-- class "flex-row-reverse should be removed if message is from someone" -->
    <div class="d-flex flex-row-reverse align-self-end p-2 gap message-detail-container">
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
            <div class="d-flex flex-row-reverse justify-content-between align-items-center p-1 message-list-footer">
                <div class="text-uppercase font-weight-bold">
                    You
                </div>
                <div class="d-flex flex-row-reverse gap-2">
                    <div>
                        Tuesday, March 8, 2024 3:40pm
                    </div>
                    <div class="d-flex justify-content-end gap-2 message-list-action border-right pr-2">
                        <a href="#" class="text-danger" alt="Delete" title="Delete">
                            <i class="fa-solid fa-trash"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="d-flex p-2 gap message-detail-container">
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
            <div class="d-flex justify-content-between align-items-center p-1 message-list-footer">
                <div class="text-uppercase font-weight-bold">
                    You
                </div>
                <div class="d-flex gap-2">
                    <div class="border-right pr-2">
                        Tuesday, March 8, 2024 3:40pm
                    </div>
                    <div class="d-flex justify-content-end gap-2 message-list-action">
                        <a href="#" class="text-danger" alt="Delete" title="Delete">
                            <i class="fa-solid fa-trash"></i>
                        </a>
                    </div>
                </div>
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

        $(".textarea-autosize").textareaAutoSize();

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

            truncateMessage($(this));
        });

        function truncateMessage(element) {
            $messageEl = element;
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
            } else {
                $messageContextEl.removeClass("text-truncate");
                if ($messageEl.children().length > 1)
                    console.log($messageEl.children()[1].remove());
            }
        }

        function getParentElement(element, parentID) {
            if (element && element.id == parentID) {
                return element;
            } else {
                return getParentElement(element.parentNode, parentID);
            }
        }

        function removeFlexReverse(element) {
            element.each(function() {
                const targetEl = $(this);

                if (targetEl.hasClass("flex-row-reverse")) {
                    targetEl.removeClass("flex-row-reverse");
                    targetEl.removeClass("align-self-end");
                }

                if (targetEl.children().length > 0) {
                    targetEl.children().each(function() {
                        const childEl = $(this);

                        childEl.each(function() {
                            const el = $(this);

                            if (el.hasClass("flex-row-reverse")) {
                                el.removeClass("flex-row-reverse");
                            }

                            if (el.hasClass("message-list-action")) {
                                el.removeClass(
                                    "border-right"
                                ).removeClass("pr-2");
                                el.addClass("border-left").addClass(
                                    "pl-2"
                                );
                            }
                        });
                        return removeFlexReverse(childEl);
                    });
                } else {
                    return;
                }
            });

            return element;
        }

        $(".toAdd").on("click", function() {
            $firstElement.clone(true).appendTo($messageListContainer);
            $("html, body").animate({
                    scrollTop: $(document).height() - 200
                },
                500
            );
        });

        $("#send-reply").on("click", function() {
            const isSender = Math.random() < 0.5;
            let clonedEl = $firstElement.clone(true);
            const replyMessage = $(
                'textarea[name="reply-message"]'
            ).val();

            console.log(replyMessage);

            if (isSender) clonedEl = removeFlexReverse(clonedEl);

            clonedEl = clonedEl.each(function() {
                $(this)
                    .find(".last-message-info")
                    .find(".msg-context")
                    .text(replyMessage);
            });

            truncateMessage(clonedEl.find(".last-message-info"));

            clonedEl.prependTo($messageListContainer);
        });
    });
</script>