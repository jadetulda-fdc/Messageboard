<div id="pagination">
    <?php if ($paginate['nextPage']) { ?>
        <hr />
        <div class="text-center font-italic">
            <span id="please-wait" class="d-none">Please wait...</span>
            <div id="load-more"><?php echo $this->Paginator->next('Load more messages', array(), null, array()); ?></div>
        </div>
    <?php } else { ?>
        <hr />
        <div class="text-center font-italic toAdd">
            No more messages to load.
        </div>
    <?php } ?>
</div>