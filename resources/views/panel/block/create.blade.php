@extends('app')

@section('content')

    <div class="row">
        <br>
        <div class="col-sm-10">
            <h1>Create new {{ $type }} block</h1>
        </div>

        <div class="col-sm-2">
            <a class="pull-right btn btn-default" href="/panel">Back</a>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            {{ dump($errors) }}
            <form class="form" method="POST" action="{{ action("PanelController@storeBlock") }}">
                <input type="hidden" name="page_id" value="{{ $pageId }}">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="type" value="{{ $type }}">
                <div class="form-group">
                    <label for="slug" class="control-label">Block slug</label>
                    <input type="text" class="form-control" name="slug" placeholder="some-slug">
                </div>
                @include('blocks.' . $type . '-editor')
                <div class="form-group">
                    <label for="enabled" class="control-label">Enabled</label>
                    <div class="radio">
                        <label>
                            <input type="radio" name="enabled" id="enabled" value="1" checked>
                            Yes
                        </label>
                        &nbsp;&nbsp;
                        <label>
                            <input type="radio" name="enabled" id="enabled" value="0">
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