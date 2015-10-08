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

<div class="row">
	<div class="col-md-8 col-md-offset-2">
		<form class="form-horizontal">
			<div class="form-group">
				<label for="name" class="col-sm-2 control-label">Page title</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" id="name" name="name">
				</div>
			</div>
			<div class="form-group">
				<label for="slug" class="col-sm-2 control-label">Slug</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" id="slug" name="slug">
				</div>
			</div>
			<div class="form-group">
				<label for="enabled" class="col-sm-2 control-label">Enabled</label>
				<div class="col-sm-10">
					<div class="radio">
						<label>
							<input type="radio" name="enabled" id="enabled" value="true" checked>
							Yes
						</label>
						&nbsp;&nbsp;
						<label>
							<input type="radio" name="enabled" id="enabled" value="false">
							No
						</label>
					</div>
					{{-- <div class="radio">
						
					</div> --}}
				</div>
			</div>
		</form>
	</div>
</div>

@stop