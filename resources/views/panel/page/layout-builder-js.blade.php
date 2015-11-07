<script src="/js/jquery.comments.js" type="text/javascript"></script>
<script src="/js/MyToJson.js" type="text/javascript"></script>

<script type="text/javascript">
    //Todo: auto-generate slug
    //Todo: build re-order functionality

    // Define global variable block for loading content in editor forms
    // Define global variable emptyBlock, for when no content has to be loaded, but no nullReferenceExceptions should be thrown (I know, java reference)
    var emptyBlock = {
        id: "",
        class: "",
        content: null,
        enabled: true,
        slug: ""
    };

    var block = emptyBlock;

    $(function(){ //DOM Ready

        $(".current-blocks").on("click", ".delete", function () {
            if (!window.confirm("Are you sure you want to delete this block? \r\n(this delete is permanent!!!)")) return false;

            var block = $(this).parent().parent();
            var blockId = block.data("id");

            $.ajax({
                url: "{{ action("PanelController@destroyBlock") }}",
                type: "POST",
                data: {id: blockId, _token: "{{ csrf_token() }}"},
                success: function (data) {
                    console.log("AJAX::success");
                    console.log(data);
                    block.parent().remove();
                },
                error: function (e) {
                    console.log("AJAX::error");
                    console.log(e);
                    $("html").html(e.responseText);
                }
            });

            return false;

        }).on("click", ".editable", function () {        // Open modal to edit a block
            var blockId = $(this).data("id");
            var blockType = $(this).data("type");
            var editor = $(this).comments().html();

            $.ajax({
                url: "{{ action("PanelController@getBlock") }}",
                type: "POST",
                data: {blockId: blockId, _token: "{{ csrf_token() }}"},
                success: function(data) {
                    block = data;
                    showModal("editBlock", blockType, editor);
                },
                error: function(e) {
                    console.log("AJAX::error");
                    console.log(e);
                    $("html").html(e.responseText);
                }
            });


			return false;
		});

        // Open modal to create a new block
		$(".available-blocks").on("click", ".block", function () {
            var blockType = $(this).data("type");
            var editor = $(this).comments().html();
            showModal("createBlock", blockType, editor);
            return false;
        });

        // When any modal is hidden, delete the html so there are no duplicate modals in dom.
        // Also set block to null cause on new block, we don't want block.
        $('body').on('hidden.bs.modal', function() {
            $('.modal').remove();
            block = emptyBlock;
        });

        // Submit the create block form
        $('body').on('submit', '#createBlock form', function() {
            // Gather data
            var data = {
                content: $(this).MytoJson(),
                _token: "{{ csrf_token() }}",
                type: $("#createBlock").data("type"),
                page_id: $('.edit input[name="id"]').val()
            };

            // Move data one level up
            data.slug = data.content["slug"];
            data.enabled = data.content["enabled"];
            data.class = data.content["class"];

            // And delete duplicate childs
            delete data.content["slug"];
            delete data.content["enabled"];
            delete data.content["class"];

            // Send data to server, and reload if successful
            $.ajax({
                url: '{{ action("PanelController@storeBlock") }}',
                type: 'POST',
                data: data,
                success: function (data) {
                    console.log("AJAX::Success");
                    console.log(data);
                    $(".current-blocks").append(data);
                    //location.reload();
                },
                error: function (e) {
                    console.log("AJAX::error");
                    console.log(e);
                    $("html").html(e.responseText);
                }
            });

            $("#createBlock").modal("hide");
            return false;

        }).on('submit', '#editBlock form', function() {         // Submit the edit block form
            // Gather data
            var data = {
                id: $("#editBlock").data("id"),
                content: $(this).MytoJson(),
                _token: "{{ csrf_token() }}",
                page_id: $('.edit input[name="id"]').val()
            };

            // Move data one level up
            data.slug = data.content["slug"];
            data.enabled = data.content["enabled"];
            data.class = data.content["class"];

            // And delete duplicate childs
            delete data.content["slug"];
            delete data.content["enabled"];
            delete data.content["class"];

            // Send data to server, and reload if successful
            $.ajax({
                url: '{{ action("PanelController@updateBlock") }}',
                type: 'POST',
                data: data,
                success: function (response) {
                    console.log("AJAX::Success");
                    console.log(response);
                    $(".editable[data-id='" + data.id + "']").parent().replaceWith(response);
                },
                error: function (e) {
                    console.log("AJAX::error");
                    console.log(e);
                    $("html").html(e.responseText);
                }
            });

            $("#editBlock").modal("hide");
            return false;
        });
	});

    function showModal(id, blockType, editor) {
        console.log(block);

        var enabledHtml;
        if(block.enabled == 1) {
            enabledHtml = '<label>'
                            + '<input type="radio" name="enabled" id="enabled" value="1" checked="0">'
                            + 'Yes'
                        + '</label>'
                        + '&nbsp;&nbsp;'
                        + '<label>'
                            + '<input type="radio" name="enabled" id="enabled" value="0">'
                            + 'No'
                        + '</label>';
        }
        else
        {
            enabledHtml = '<label>'
                            + '<input type="radio" name="enabled" id="enabled" value="1">'
                            + 'Yes'
                        + '</label>'
                        + '&nbsp;&nbsp;'
                        + '<label>'
                            + '<input type="radio" name="enabled" id="enabled" value="0" checked="0">'
                            + 'No'
                        + '</label>';
        }

        // Html for the modal
        var html = '<div class="modal fade" id="' + id + '" tabindex="-1" role="dialog" aria-labelledby="modalLabel" data-type="' + blockType + '" data-id="' + block.id + '">'
                        + '<div class="modal-dialog" role="document">'
                            + '<div class="modal-content">'
                                + '<form>'
                                    + '<div class="modal-header">'
                                        + '<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>'
                                        + '<h4 class="modal-title" id="modalLabel">Create/edit a ' + blockType + ' block</h4>' //Todo: set title according to action
                                    + '</div>'
                                    + '<div class="modal-body">'
                                        + '<div class="form-horizontal">'
                                            + '<div class="form-group">'
                                                + '<label for="slug" class="col-sm-2 control-label">Slug</label>'
                                                + '<div class="col-sm-10">'
                                                    + '<input type="text" class="form-control" id="slug" name="slug" value="' + block.slug + '">'
                                                + '</div>'
                                            + '</div>'
                                            + '<div class="form-group">'
                                                + '<label for="class" class="col-sm-2 control-label">Class</label>'
                                                + '<div class="col-sm-10">'
                                                    + '<input type="text" class="form-control" id="class" name="class" value="' + block.class + '">'
                                                + '</div>'
                                            + '</div>'
                                            + '<div class="form-group">'
                                                + '<label for="enabled" class="col-sm-2 control-label">Enabled</label>'
                                                + '<div class="col-sm-10">'
                                                    + '<div class="radio">'
                                                        + enabledHtml
                                                    + '</div>'
                                                + '</div>'
                                            + '</div>'
                                        + '</div><hr><br>'
                                        + editor
                                    + '</div>'
                                    + '<div class="modal-footer">'
                                        + '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>'
                                        + '<button type="submit" class="btn btn-primary">Save changes</button>'
                                    + '</div>'
                                + '</form>'
                            + '</div>'
                        + '</div>'
                    + '</div>';

        // Add it to the body and show it
        $('body').append(html);
        $('#' + id).modal();
    }

</script>