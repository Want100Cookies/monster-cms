@extends('app')

@section('content')

<div class="row">
	<br>
	<div class="col-sm-10">
		<h1>Create new page</h1>
	</div>

	<div class="col-sm-2">
		<a class="pull-right btn btn-default" href="/panel">Back</a>
	</div>
</div>
<br>
<div class="row">
	<div class="col-md-8 col-md-offset-2">
		<form class="form-horizontal">
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