<?php
$this->assign('page_header', 'Compose Message');
$this->assign('title', 'Compose | MessageBoard');
?>
<!-- <form id="form-compose-message"> -->
<?php echo $this->Form->create('Message'); ?>
<div class="form-group row">
    <label for="message-recipient" class="col-sm-2 col-form-label">
        Recipient
    </label>
    <div class="col-sm-10">
        <select name="data[Message][recipient]" id="MessageRecipient" class="w-50">
            <option></option>
        </select>
    </div>
</div>
<div class="form-group row">
    <label for="MessageMessage" class="col-sm-2 col-form-label">
        Message
    </label>
    <div class="col-sm-10">
        <?php
        echo $this->Form->textarea(
            'message',
            array(
                'class' => 'w-50 form-control textarea-autosize ',
                'placeholder' => 'Write a message ...',
                // 'value' => html_entity_decode(),
                'style' => array('height: 62px;')
            )
        );
        ?>
    </div>
</div>
<div class="form-group row">
    <div class="col-sm-10 offset-sm-2">
        <input type="submit" class="btn btn-primary" value="Send" />
    </div>
</div>
<!-- </form> -->
<?php echo $this->Form->end(); ?>

<script>
    $(function() {
        $(".textarea-autosize").textareaAutoSize();

        function formatState(state) {
            if (!state.id) {
                return state.text;
            }
            var baseUrl = "/Messageboard/img/";

            var $state = $(
                '<span><img src="' +
                baseUrl + state.img +
                '" class="img-fluid img-thumbnail" width="50" /> ' +
                state.text +
                "</span>"
            );
            return $state;
        }

        $("#MessageRecipient").select2({
            placeholder: "Search for a recipient",
            minimumInputLength: 3,
            templateResult: formatState,
            ajax: {
                url: "../recipients/index.json",
                dataType: "json",
                delay: 250,
                data: function(params) {
                    return {
                        q: params.term,
                        page: params.page,
                    };
                },
                processResults: function(data, params) {
                    params.page = params.page || 1;

                    return {
                        results: data.results.data,
                        pagination: {
                            more: params.page * 30 < data.results.total_count,
                        },
                    };
                },
                cache: true,
            },
        });
    });
</script>