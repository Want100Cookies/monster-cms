@extends('app')

@section('content')

<div class="row">
	<br>
	<div class="col-sm-10">
		<h1>Dashboard</h1>
	</div>
	<div class="col-sm-2">
		<a class="btn btn-primary" href="/panel/page/create">Create new page</a>
	</div>
</div>
<div class="row">
	@forelse ($pages as $page)
	    <div class="col-md-3 panel panel-default">
		    <div class="panel-body">
		    	<a href="#">{{ $page->name }}</a>
		    </div>
	    </div>
	@empty
	    <p>No pages</p>
	@endforelse
</div>

@stop