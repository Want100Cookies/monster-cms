<div class="col-sm-10 current-blocks">
	@foreach($currentBlocks as $block)
		<div class="editable block" data-id="{{ $block->id }}" data-type="{{ $block->type }}">
			@include('blocks.' . $block->type . '-edit', ['block' => $block])
			<!--
			@include('blocks.' . $block->type . '-editor')
			-->
		</div>
	@endforeach
</div>
<div class="col-sm-2 available-blocks">
	<h3>Available blocks</h3>
	@foreach($availableBlocks as $block)
		<div class="panel panel-default block" data-type="{{ $block }}">
			<div class="panel-body">
				<a href="#">{{ $block }}</a>
			</div>
			<!--
			@include('blocks.' . $block . '-editor')
			-->
		</div>
	@endforeach
</div>