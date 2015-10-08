<div class="col-sm-10 gridster">
	@foreach($currentBlocks as $block)
		@include('blocks.' . $block->type . '-edit', ['block' => $block])
	@endforeach
</div>
<div class="col-sm-2">
	<h3>Available blocks</h3>
	@foreach($availableBlocks as $block)
		<div class="panel panel-default">
			    <div class="panel-body">
				<a href="#">{{ $block }}</a>
			</div>
		</div>
	@endforeach
</div>