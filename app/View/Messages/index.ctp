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
<div id="search-thread">
    <?php
    echo $this->Form->create('Message', array(
        'url' => array(
            'controller' => 'messages',
            'action' => 'search'
        ),
        'class' => 'd-flex mb-3 gap-2'
    ));
    echo $this->Form->input('search-item', array(
        'placeholder' => 'Search name',
        'class' => 'form-control',
        'label' => false,
        'div' => false,
        'error' => false
    ));
    ?>
    <button type="submit" class="btn btn-primary" style="border-radius: 50%;"><i class="fa-solid fa-search"></i></button>
    <?php
    echo $this->Form->end()
    ?>
</div>
<div id="thread">
    <?php echo $this->element('Messages/main') ?>
</div>
<script>
    $(function() {

        const MESSAGE_LENGTH_LIMIT = 100;

        // Truncate message
        $("body").on("click", "#message-list .last-message-info .see-more", function() {
            toggleMessage($(this));
        });

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
        $('body').on('click', '#pagination #load-more a', function(e) {
            e.preventDefault();
            $('#please-wait').removeClass('d-none');
            $('#load-more').addClass('d-none');

            var linkTag = $(this);
            var urlLink = linkTag.prop('href');

            $.ajax({
                url: urlLink,
                method: 'POST',
                data: {
                    'search_string': $('#MessageSearch-item').val()
                },
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
        $('body').on('click', '#message-list .delete-msg', function() {
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

        // Search Message
        $('#MessageSearchForm').on('submit', function(e) {
            e.preventDefault();
            const form = $(this)

            $.ajax({
                url: form.prop('action'),
                method: form.prop('method'),
                data: form.serialize(),
                success: function(result) {
                    $('#thread').html(result);
                },
                error: function(error) {
                    console.log(error);
                }
            });
        });
    });
</script>