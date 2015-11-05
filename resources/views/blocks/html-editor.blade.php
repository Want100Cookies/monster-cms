<textarea class="form-control" name="html" placeholder="<b>Add your html here</b>" rows="10"></textarea>
<script>
    if (block.content != null) {
        $("textarea[name='html']").val(block.content.html);
    }
</script>