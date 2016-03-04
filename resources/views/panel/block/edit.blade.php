@extends('app')

@section('content')

    <div class="row">
        <br>
        <div class="col-sm-10">
            <h1>Edit {{ $block->slug }}</h1>
        </div>

        <div class="col-sm-2">
            <a class="pull-right btn btn-default" href="/panel">Back</a>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            {{ dump($errors) }}
            <form class="form" method="POST" action="{{ action("PanelController@updateBlock") }}">
                <input type="hidden" name="id" value="{{ $block->id }}">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="form-group">
                    <label for="slug" class="control-label">Block slug</label>
                    <input type="text" class="form-control" name="slug" value="{{ $block->slug }}">
                </div>
                @include('blocks.' . $block->type . '-editor', ['block' => $block])
                <div class="form-group">
                    <label for="enabled" class="control-label">Enabled</label>
                    <div class="radio">
                        <label>
                            <input type="radio" name="enabled" id="enabled" value="1" {{ isset($block) ? ($block->enabled ? 'checked' : '') : 'checked' }}>
                            Yes
                        </label>
                        &nbsp;&nbsp;
                        <label>
                            <input type="radio" name="enabled" id="enabled" value="0" {{ isset($block) ? (!$block->enabled ? 'checked' : '') : '' }}>
                            No
                        </label>
                    </div>
                </div>
                <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-lg">Save</button>
                </div>
            </form>
        </div>
    </div>
@stop

@section('footer')
	
@stop