<script type="text/javascript" src="/js/jquery-ui.min.js"></script>

<script type="text/javascript">
	$(function(){ //DOM Ready
		var width = $('.draggable').width() / 12;
		$('.block').draggable({
			grid: [width, 1],
		});
		
	});
</script>
{{-- var widgets = [
	    	@foreach($currentBlocks as $block)
				['@include('blocks.' . $block->type . '-edit', ['block' => $block])', {{ classToWith($block->class, 'md')}}, 1],
			@endforeach
	    ] --}}