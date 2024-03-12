<?php
$this->assign('page_header', 'Message List');
$this->assign('title', 'Messages | MessageBoard');
$flashMessage = $this->Flash->render('message_sent');
?>

<?php if (isset($flashMessage)) { ?>
    <div class="alert alert-success text-left" role="alert">
        <?php echo $flashMessage; ?>
    </div>
<?php } ?>
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
    <!-- Note: Each list is generated via element -->
    <?php
    foreach ($messageThreads as $thread) {
        $personToDisplay = $thread['Profile1']['user_id'] == AuthComponent::user('id') ? $thread['Profile2'] : $thread['Profile1'];
    ?>
        <?php
        echo $this->element('Messages/threadDetail', compact(['personToDisplay', 'thread']));
        ?>
    <?php
    }
    ?>
</div>
<?php if (count($messageThreads)) { ?>
    <hr />
    <div class="text-center font-italic toAdd">
        Load more messages
    </div>
<?php } ?>
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