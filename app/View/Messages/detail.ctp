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

<!-- Search -->
<div id="search-thread">
	<?php
	echo $this->Form->create('MessageDetail', array(
		'url' => array(
			'controller' => 'message_details',
			'action' => 'search',
			$thread['Message']['id']
		),
		'class' => 'd-flex mb-3 gap-2'
	));
	echo $this->Form->input('search-item', array(
		'placeholder' => 'Search in conversation',
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
<hr />

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
<div id="thread">
	<?php echo $this->element('Messages/thread') ?>
</div>
<script>
	$(function() {

		$(".textarea-autosize").textareaAutoSize();

		const MESSAGE_LENGTH_LIMIT = 100;

		// on click truncate
		$("body").on(
			"click",
			"#message-detail .last-message-info .see-more",
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
		// end truncate

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
					$('.textarea-autosize').css({
						'height': '62px'
					});
				},
				error: function(error) {
					console.log(error);
				}
			});
		});

		// Delete Message
		$('body').on('click', '#message-detail .delete-msg', function() {
			var btn_delete = $(this);
			var message_id = 0;
			message_id = btn_delete.data('message-id');
			var container = $('body #message-container-' + message_id);

			if (confirm("Are you sure to delete message?")) {
				$.ajax({
					url: '/Messageboard/message_details/delete',
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

		// Load More
		$('body').on('click', '#pagination #load-more a', function(e) {
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
					$('#message-detail').append(htmlEntity);

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
							<div class="text-center font-italic text-muted">
								End of conversation.
							</div>`
						);
					}
				},
				error: function(error) {
					console.log(error);
				}
			})

		});

		// Search Message
		$('#MessageDetailSearchForm').on('submit', function(e) {
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