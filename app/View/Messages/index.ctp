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
    <?php
    echo $this->element('Messages/threadDetail');
    ?>
</div>
<?php echo $this->element('paginator'); ?>
<script>
    $(function() {

        const MESSAGE_LENGTH_LIMIT = 100;

        // Truncate message
        $("body #message-list .last-message-info").on(
            "click",
            ".see-more",
            function() {
                toggleMessage($(this));
            }
        );

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
        // End Truncate message

        // Load More
        $('body #pagination').on('click', '#load-more a', function(e) {
            e.preventDefault();
            $('#please-wait').removeClass('d-none');
            $('#load-more').addClass('d-none');

            var linkTag = $(this);
            var urlLink = linkTag.prop('href');

            $.ajax({
                url: urlLink,
                method: 'GET',
                success: function(result) {

                    $('#please-wait').addClass('d-none');

                    const data = JSON.parse(result);
                    const htmlEntity = data['html'];
                    const paginator = data['paginator']
                    $('#message-list').append(htmlEntity);

                    if (paginator['nextPage']) {
                        let page = parseInt(paginator['page']);
                        const splitLink = urlLink.split('/');
                        let pageLink = splitLink.length - 1;

                        const newLink = $('#load-more a').prop('href').replace(/page:\d/, 'page:' + (++page));

                        $('#load-more a').prop('href', newLink);

                        $('#load-more').removeClass('d-none');

                    } else {
                        $('#pagination').html(
                            `<hr />
                            <div class="text-center font-italic toAdd">
                                No more messages to load.
                            </div>`
                        );
                    }
                },
                error: function(error) {
                    console.log(error);
                }
            })

        });

        // Delete
        $('body #message-list').on('click', '.delete-msg', function() {
            var btn_delete = $(this);
            var message_id = 0;
            message_id = btn_delete.data('message-id');
            var container = $('body #message-container-' + message_id);

            if (confirm("Are you sure to delete this thread?")) {
                $.ajax({
                    url: '/Messageboard/messages/delete',
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
                                container.fadeOut(500, () => container.remove());
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