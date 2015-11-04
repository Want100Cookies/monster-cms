<script src="/js/jquery.comments.js" type="text/javascript"></script>

<script type="text/javascript">
	$(function(){ //DOM Ready
		$(".current-blocks").on("click", ".editable", function () {
			console.log($(this).data("id"));
			return false;
		});

		$(".available-blocks").on("click", ".block", function () {
            var blockType = $(this).data("type");
            var editor = $(this).comments().html();
            showCreateModal(blockType, editor);
            return false;
        });

        $('body').on('hidden.bs.modal', '#createBlock', function() {
            $(this).remove();
        });

        $('body').on('submit', '#createBlock form', function() {
            var data = {
                content: $(this).MytoJson(),
                _token: "{{ csrf_token() }}",
                type: $("#createBlock").data("type"),
                slug: $('#createBlock input[name="slug"]').val(),
                enabled: $('#createBlock input[name="enabled"]').val(),
                page_id: $('.edit input[name="id"]').val()
            };

            data.slug = data.content["slug"];
            data.enabled = data.content["enabled"];
            data.class = data.content["class"];

            delete data.content["slug"];
            delete data.content["enabled"];
            delete data.content["class"];


            $.ajax({
                url: '{{ action("PanelController@storeBlock") }}',
                type: 'POST',
                data: data,
                success: function (data) {
                    console.log("AJAX::Success");
                    console.log(data);
                },
                error: function (e) {
                    console.log("AJAX::error");
                    console.log(e);
                    $("html").html(e.responseText);
                }
            });

            $("#createBlock").modal("hide");
            return false;
        });
	});

    function showCreateModal(blockType, editor) {
        // Html for the modal
        var html = '<div class="modal fade" id="createBlock" tabindex="-1" role="dialog" aria-labelledby="modalLabel" data-type="' + blockType + '">'
                        + '<div class="modal-dialog" role="document">'
                            + '<div class="modal-content">'
                                + '<form>'
                                    + '<div class="modal-header">'
                                        + '<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>'
                                        + '<h4 class="modal-title" id="modalLabel">Create a ' + blockType + ' block</h4>'
                                    + '</div>'
                                    + '<div class="modal-body">'
                                        + '<div class="form-horizontal">'
                                            + '<div class="form-group">'
                                                + '<label for="slug" class="col-sm-2 control-label">Slug</label>'
                                                + '<div class="col-sm-10">'
                                                    + '<input type="text" class="form-control" id="slug" name="slug">'
                                                + '</div>'
                                            + '</div>'
                                            + '<div class="form-group">'
                                                + '<label for="class" class="col-sm-2 control-label">Class</label>'
                                                + '<div class="col-sm-10">'
                                                    + '<input type="text" class="form-control" id="class" name="class">'
                                                + '</div>'
                                            + '</div>'
                                            + '<div class="form-group">'
                                                + '<label for="enabled" class="col-sm-2 control-label">Enabled</label>'
                                                + '<div class="col-sm-10">'
                                                    + '<div class="radio">'
                                                        + '<label>'
                                                            + '<input type="radio" name="enabled" id="enabled" value="1" checked="">'
                                                            + 'Yes'
                                                        + '</label>'
                                                        + '&nbsp;&nbsp;'
                                                        + '<label>'
                                                            + '<input type="radio" name="enabled" id="enabled" value="0">'
                                                            + 'No'
                                                        + '</label>'
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
        $('#createBlock').modal();
    }

    jQuery.fn.MytoJson = function(options) {

        options = jQuery.extend({}, options);

        var self = this,
                json = {},
                push_counters = {},
                patterns = {
                    "validate": /^[a-zA-Z][a-zA-Z0-9_]*(?:\[(?:\d*|[a-zA-Z0-9_]+)\])*$/,
                    "key":      /[a-zA-Z0-9_]+|(?=\[\])/g,
                    "push":     /^$/,
                    "fixed":    /^\d+$/,
                    "named":    /^[a-zA-Z0-9_]+$/
                };


        this.build = function(base, key, value){
            base[key] = value;
            return base;
        };

        this.push_counter = function(key){
            if(push_counters[key] === undefined){
                push_counters[key] = 0;
            }
            return push_counters[key]++;
        };

        jQuery.each(jQuery(this).serializeArray(), function(){

            // skip invalid keys
            if(!patterns.validate.test(this.name)){
                return;
            }

            var k,
                    keys = this.name.match(patterns.key),
                    merge = this.value,
                    reverse_key = this.name;

            while((k = keys.pop()) !== undefined){

                // adjust reverse_key
                reverse_key = reverse_key.replace(new RegExp("\\[" + k + "\\]$"), '');

                // push
                if(k.match(patterns.push)){
                    merge = self.build([], self.push_counter(reverse_key), merge);
                }

                // fixed
                else if(k.match(patterns.fixed)){
                    merge = self.build([], k, merge);
                }

                // named
                else if(k.match(patterns.named)){
                    merge = self.build({}, k, merge);
                }
            }

            json = jQuery.extend(true, json, merge);
        });


        return json;
    }
</script>