<div id="pagination">
    <?php if ($paginate['nextPage']) { ?>
        <hr />
        <div class="text-center font-italic">
            <span id="please-wait" class="d-none">Please wait...</span>
            <div id="load-more">
                <span class="next">
                    <a href="/Messageboard/messages/index/page:<?php echo $paginate['page'] + 1; ?>">Load more messages</a>
                </span>
            </div>
        </div>
    <?php } else { ?>
        <hr />
        <div class="text-center font-italic toAdd">
            No more messages to load.
        </div>
    <?php } ?>
</div>