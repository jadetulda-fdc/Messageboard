<?php
$this->assign('page_header', 'Message Thread');
$this->assign('title', 'Thread | Messageboard');
$this->assign('back_link', $this->Html->link(
    '<i class="fa-solid fa-circle-left fa-2x"></i>',
    array(
        'controller' => 'messages',
        'action' => 'index',
    ),
    array(
        'class' => 'text-dark',
        'escape' => false
    )
));
?>

<!-- Form -->
<?php
echo $this->Form->create('MessageDetail', array(
    'url' => array(
        'controller' => 'message_details',
        'action' => 'send_message'
    ),
    'class' => 'd-flex mb-3 gap-2'
));
echo $this->Form->textarea('message', array(
    'placeholder' => 'Write a message',
    'class' => 'form-control textarea-autosize',
    'style' => 'height: 62px;',
));
echo $this->Form->hidden('sender_id', array(
    'value' => AuthComponent::user('id')
));
echo $this->Form->hidden('recipient_id', array(
    'value' => AuthComponent::user('id') != $thread['Message']['first_user_id_in_thread'] ? $thread['Message']['first_user_id_in_thread']  : $thread['Message']['second_user_id_in_thread']
));
echo $this->Form->hidden('message_id', array(
    'value' => $thread['Message']['id']
));
?>
<button class="btn btn-info align-self-center" id="send-reply">
    <i class="fa-solid fa-paper-plane"></i>
</button>
<?php echo $this->Form->end(); ?>
<hr />
<div class="d-flex flex-column gap-3 mb-3" id="message-detail">
    <!-- Note: Each list is generated via component -->
    <?php
    if (count($thread['MessageDetail']) > 0) {
        foreach ($thread['MessageDetail'] as $message) {
            $msgDetail = $message['MessageDetail'];
            $profile = $message['Profile'];

            $is_from_sender = $msgDetail['sender_id'] == AuthComponent::user('id');

            if (!$is_from_sender) {
                $name = $profile['name'];
                $img = $profile['profile_picture'];
            } else {
                $name = 'You';
                $img = AuthComponent::user('Profile.profile_picture');
            }

            echo $this->element('Messages/threadMessage', compact(['is_from_sender', 'msgDetail', 'img', 'name']));
        }
    }
    ?>
    <?php
    ?>
</div>
<?php if (count($thread['MessageDetail'])) { ?>
    <hr />
    <div class="text-center font-italic toAdd">
        Load more messages
    </div>
<?php } ?>
<script>
    $(function() {

        $(".textarea-autosize").textareaAutoSize();

        const MESSAGE_LENGTH_LIMIT = 100;

        $("body #message-detail .last-message-info").on(
            "click",
            ".see-more",
            function() {
                toggleMessage($(this));
            }
        );

        $messageListContainer = getParentElement(
            $("#message-detail .last-message-info")[0],
            "message-detail"
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

        $("#message-detail .last-message-info").each(function(index, el) {
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

        // Form Submit (Send Message)
        $('#MessageDetailSendMessageForm').on('submit', function(e) {
            e.preventDefault();

            const form = $(this);
            var actionUrl = form.prop('action');
            $.ajax({
                url: actionUrl,
                method: 'POST',
                data: $(this).serialize(),
                success: function(result, textStatus, request) {

                    var response_content_type = request.getResponseHeader('content-type');
                    var reponse_thread_message = request.getResponseHeader('response-content');

                    if (response_content_type.includes('application/json')) {
                        const errList = [];
                        const messages = result.errors.MessageDetail.message;

                        messages.forEach(element => {
                            errList.push(`<li>${element}</li>`);
                        });

                        if ($('#err-msg').length == 0) {
                            form.before(`<div class="alert alert-danger" role="danger" id="err-msg"><ul class="m-0 p-0">${ [...errList] }</ul></div>`);
                        }
                    } else {
                        $('#err-msg').remove();

                        if (reponse_thread_message.includes('thread-message')) {
                            $('#message-detail').prepend(result);
                        } else {
                            if ($('#err-msg').length == 0) {
                                form.before(`<div class="alert alert-danger" role="danger" id="err-msg"><ul class="m-0 p-0"><li>Uncaught response error.</li></ul></div>`);
                            }
                        }
                    }

                    form[0].reset();
                },
                error: function(error) {
                    console.log(error);
                }
            });
        });

        // Delete Message
        $('body #message-detail').on('click', '.delete-msg', function() {
            var btn_delete = $(this);
            var message_id = 0;
            message_id = btn_delete.data('message-id');
            var container = $('body #message-container-' + message_id);

            if (confirm("Are you sure to delete message?")) {
                $.ajax({
                    url: '/messageboard/message_details/delete',
                    method: 'POST',
                    data: {
                        'message_id': message_id,
                    },
                    success: function(result) {
                        let data = [];
                        try {
                            data = JSON.parse(result);
                            console.log(data);
                            if (data.error) {
                                alert(data.error);
                            } else {
                                alert(data.success);
                                container.remove();
                            }
                        } catch (error) {
                            alert("Uncaught error!");
                        }
                    },
                    error: function(err) {
                        console.log(['err', err]);
                    }
                });
            } else {
                console.log('cancelled');
            }
        });
    });
</script>