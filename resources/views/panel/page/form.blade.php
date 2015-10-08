<div class="form-group">
	<label for="name" class="col-sm-2 control-label">Page title</label>
	<div class="col-sm-10">
		<input type="text" class="form-control" id="name" name="name" value="{{ $page->name or '' }}">
	</div>
</div>
<div class="form-group">
	<label for="slug" class="col-sm-2 control-label">Slug</label>
	<div class="col-sm-10">
		<input type="text" class="form-control" id="slug" name="slug" value="{{ $page->slug or '' }}">
	</div>
</div>
<div class="form-group">
	<label for="enabled" class="col-sm-2 control-label">Enabled</label>
	<div class="col-sm-10">
		<div class="radio">
			<label>
				<input type="radio" name="enabled" id="enabled" value="true" {{ isset($page) ? ($page->enabled ? 'checked' : '') : 'checked' }}>
				Yes
			</label>
			&nbsp;&nbsp;
			<label>
				<input type="radio" name="enabled" id="enabled" value="false" {{ isset($page) ? (!$page->enabled ? 'checked' : '') : '' }}>
				No
			</label>
		</div>
	</div>
</div>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
		<button type="submit" class="btn btn-primary btn-lg">Save</button>
	</div>
</div>