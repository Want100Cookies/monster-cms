@extends('app')

@section('content')

<div class="row">
	<br>
	<div class="col-sm-10">
		<h1>Dashboard</h1>
	</div>
	<div class="col-sm-2">
		<a class="btn btn-primary" href="{{ action("PanelController@create") }}">Create new page</a>
	</div>
</div>
<div class="row">
	@forelse ($pages as $page)
		<div class="col-md-3 ">
			<div class="panel panel-default">
				<div class="panel-body">
					<a href="{{ action("PanelController@edit", ["slug" => $page->slug]) }}">{{ $page->name }}</a>
				</div>
			</div>
		</div>
	@empty
	    <p>No pages</p>
	@endforelse
</div>

@stop