<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Monster CMS - @yield('title')</title>

		<link href="/css/bootstrap.min.css" rel="stylesheet">
		<link href="/css/app.css" rel="stylesheet">
		@yield('head')

		<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
	</head>
	<body>

		@section('navigation')
		<nav class="navbar navbar-inverse navbar-fixed-top">
			<div class="container">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="#">Monster CMS</a>
				</div>
				<div id="navbar" class="collapse navbar-collapse">
					<ul class="nav navbar-nav">
						@foreach(\App\Page::get(['name', 'slug']) as $forPage)
                            @if(isset($currentSlug) && $forPage->slug == $page->slug)
                                <li class="active"><a href="/{{ $forPage->slug }}">{{ $forPage->name }}</a></li>
                            @else
                                <li><a href="/{{ $forPage->slug }}">{{ $forPage->name }}</a></li>
                            @endif
                        @endforeach
					</ul>
					<ul class="nav navbar-nav navbar-right">
					@if(\Auth::check())
						<li><a href="{!! action('PanelController@index') !!}">Panel</a></li>
						<li><a href="{!! action('Auth\AuthController@getLogout') !!}">Logout</a></li>
					@else
						<li><a href="{!! action('Auth\AuthController@getLogin') !!}">Login</a></li>
						<li><a href="{!! action('Auth\AuthController@getRegister') !!}">Register</a></li>
					@endif
					</ul>
				</div>
			</div>
		</nav>
		@show

		<div class="container">
			@include('flash::message')
		
			@yield('content')
		</div>

		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
		<script src="/js/jquery-2.1.4.min.js"></script>
		<!-- Include all compiled plugins (below), or include individual files as needed -->
		<script src="/js/bootstrap.min.js"></script>

		@yield('footer')

	</body>
</html>
