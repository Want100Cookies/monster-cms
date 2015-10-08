<script type="text/javascript" src="/js/jquery.gridster.min.js"></script>

<script type="text/javascript">
	$(function(){ //DOM Ready

		$(".gridster").gridster({
	        widget_base_dimensions: [100, 55],
            widget_margins: [5, 5],
	        min_cols: 12,
	        max_cols: 12,
	        widget_selector: 'div.block'
	    });
	});
</script>