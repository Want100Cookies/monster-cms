<div class="col-sm-10 current-blocks">
	@foreach($currentBlocks as $block)
		@include('panel.page.blockEdit', ['block' => $block])
	@endforeach
</div>
<div class="col-sm-2 available-blocks">
	<h3>Available blocks</h3>
	@foreach($availableBlocks as $block)
		<div class="panel panel-default block" data-type="{{ $block }}">
			<div class="panel-body">
				<a href="{{ action("PanelController@createBlock", ['pageId' => $page->id, 'blockType' => $block]) }}">{{ $block }}</a>
			</div>
		</div>
	@endforeach
</div>