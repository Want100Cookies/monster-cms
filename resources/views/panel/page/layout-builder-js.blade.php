<script src="/js/MyToJson.js" type="text/javascript"></script>

<script type="text/javascript">

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

        });
	});

</script>