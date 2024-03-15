<?php
// debug($messageThreads);
?>
<div class="d-flex flex-column gap-3 mb-3" id="message-list">
	<?php
	echo $this->element('Messages/threadDetail');
	?>
</div>
<?php echo $this->element('paginator'); ?>