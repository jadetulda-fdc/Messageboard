<div class="d-flex flex-column gap-3 mb-3" id="message-detail">
	<?php
	if (count($thread['MessageDetail']) > 0) {
		echo $this->element('Messages/threadMessage', array(compact('thread')));
	} else {
	?>
		<span class="align-self-center text-muted font-italic">No results found.</span>
	<?php
	}
	?>
</div>
<?php echo $this->element('paginator'); ?>