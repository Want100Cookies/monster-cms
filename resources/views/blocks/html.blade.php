<?php $json = json_decode($block->content); ?>

<div class="{{ $block->class }}">
	<b>This is an html block</b>
	{!! $json->content !!}
</div>