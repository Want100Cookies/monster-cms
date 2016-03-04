<div class="col-sm-10">
    <div class="editable panel panel-default" data-id="{{ $block->id }}" data-type="{{ $block->type }}">
        <div class="panel-body">
            <a href="{{ action("PanelController@editBlock", ["blockId" => $block->id]) }}">Click to edit {{ $block->slug }}</a>
            <a href="{{ action("PanelController@destroyBlock") }}" class="pull-right delete"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
        </div>
    </div>
</div>