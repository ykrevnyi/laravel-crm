<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="">
		<meta name="author" content="">

		<title>{{ $title }}</title>

		<!-- Bootstrap core CSS -->
		<link href="/public/css/bootstrap.css" rel="stylesheet">
		<link href="/public/css/style.css" rel="stylesheet">
		<link href="/public/css/select2.css" rel="stylesheet">
		<link href="/public/css/datepicker.css" rel="stylesheet">
		<link href="/public/css/jquery.fancybox.css" rel="stylesheet">

		<script type="text/javascript" src="//code.jquery.com/jquery.js"></script>
		<script type="text/javascript" src="/public/js/jquery.fancybox.pack.js"></script>
		<script type="text/javascript" src="/public/js/noty.js"></script>
		<script type="text/javascript" src="/public/js/bootstrap.js"></script>
		<script type="text/javascript" src="/public/js/select2.min.js"></script>
		<script type="text/javascript" src="/public/js/bootstrap-datepicker.js"></script>
		<script type="text/javascript" src="/public/js/common.js"></script>
	</head>

	<body>
	
	<div class="navbar navbar-inverse">
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="#">Admin</a>
			</div>
			<div class="navbar-collapse collapse">
				<ul class="nav navbar-nav">
					@if (preg_match("/^home.*/i", Route::currentRouteName()))
						<li class="active">
					@else
						<li>
					@endif
						<a href="/">home</a></li>

					@if (preg_match("/^users\..+/i", Route::currentRouteName()))
						<li class="active">
					@else
						<li>
					@endif
						<a href="/users">users</a></li>

					@if (preg_match("/^transactions\..+/i", Route::currentRouteName()))
						<li class="active">
					@else
						<li>
					@endif
						<a href="/transactions">transactions</a></li>

					@if (preg_match("/^projects\..+/i", Route::currentRouteName()))
						<li class="active">
					@else
						<li>
					@endif
						<a href="/projects">projects</a></li>
				</ul>
			</div><!--/.navbar-collapse -->
		</div>
	</div>