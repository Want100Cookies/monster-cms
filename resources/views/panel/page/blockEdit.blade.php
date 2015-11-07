<div class="col-md-4">
    <div class="editable panel panel-default" data-id="{{ $block->id }}" data-type="{{ $block->type }}">
        <div class="panel-body">
            @include('blocks.' . $block->type . '-edit', ['block' => $block])
            <a href="#" class="pull-right delete"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
        </div>
        <!--
				@include('blocks.' . $block->type . '-editor')
                -->
    </div>
</div>