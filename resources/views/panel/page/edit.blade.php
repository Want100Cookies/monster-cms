@extends('app')

@section('content')

    <div class="row">
        <br>
        <div class="col-sm-10">
            <h1>Edit</h1>
        </div>

        <div class="col-sm-2">
            <a class="pull-right btn btn-default" href="/panel">Back</a>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <form class="form-horizontal edit">
                <input type="hidden" name="id" value="{{ $page->id }}">
                @include('panel.page.form')
            </form>
        </div>
    </div>

    <hr>

    <div class="row">
        <div class="col-sm-12">
            <h2>Define the layout</h2>
        </div>
        @include('panel.page.layout-builder')
    </div>

@stop

@section('footer')
	@include('panel.page.layout-builder-js')
@stop