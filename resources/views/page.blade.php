@extends('app')

@section('title')
{{ $page->name }}
@stop

@section('head')
    <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">

    <style>
        .container {
            text-align: center;
            vertical-align: middle;
        }

        .content {
            /*text-align: center;*/
            /*display: inline-block;*/
            /*font-weight: 100;*/
            /*font-family: 'Lato';*/
            margin-top: 20px;
        }

        /*.title {*/
            /*font-size: 96px;*/
        /*}*/
    </style>
@stop

@section('content')
    <div class="content">
        {{--<div class="title">{{ $page->name }}</div>--}}
        @foreach ($page->enabledBlocks as $block)
            @include('blocks.' . $block->type, ['block' => $block])
        @endforeach
    </div>
@stop
