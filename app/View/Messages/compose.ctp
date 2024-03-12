<?php
$this->assign('page_header', 'Compose Message');
$this->assign('title', 'Compose | MessageBoard');
?>
<form id="form-compose-message">
    <div class="form-group row">
        <label for="message-recipient" class="col-sm-2 col-form-label">
            Recipient
        </label>
        <div class="col-sm-10">
            <select id="message-recipient" class="js-example-basic-single w-50" name="recipient">
                <option></option>
            </select>
        </div>
    </div>
    <div class="form-group row">
        <label for="message-recipient" class="col-sm-2 col-form-label">
            Message
        </label>
        <div class="col-sm-10">
            <textarea class="w-50 form-control textarea-autosize" placeholder="Write a message ..."></textarea>
        </div>
    </div>
    <div class="form-group row">
        <div class="col-sm-10 offset-sm-2">
            <input type="submit" class="btn btn-primary" value="Send" />
        </div>
    </div>
</form>

<script>
    $(function() {
        $(".textarea-autosize").textareaAutoSize();

        function formatState(state) {
            // if (!state.id) {
            //     return state.text;
            // }
            // var baseUrl = "/img";

            // var $state = $(
            //     '<span><img src="' +
            //     state.owner.avatar_url +
            //     '" class="img-fluid img-thumbnail" width="50" /> ' +
            //     state.full_name +
            //     "</span>"
            // );
            // return $state;
            console.log(state);
        }

        $("#message-recipient").select2({
            placeholder: "Search for a recipient",
            minimumInputLength: 3,
            templateResult: formatState,
            ajax: {
                // url: "https://api.github.com/search/repositories",
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
                    // Transforms the top-level key of the response object from 'items' to 'results'
                    params.page = params.page || 1;

                    return {
                        results: data.items,
                        pagination: {
                            more: params.page * 30 < data.total_count,
                        },
                    };
                },
                cache: true,
                // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
            },
        });
    });
</script>