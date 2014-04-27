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
		<link href="/public/css/select2.css" rel="stylesheet">
		<link href="/public/css/datepicker.css" rel="stylesheet">
		<link href="/public/css/jquery.fancybox.css" rel="stylesheet">
		<link href="/public/css/daterangepicker-bs3.css" rel="stylesheet">
		<link href="/public/css/bootstrap-colorpicker.css" rel="stylesheet">
		<link href="/public/css/push-menu.css" rel="stylesheet">
		<link href="/public/css/style.css" rel="stylesheet">

		<script type="text/javascript" src="//code.jquery.com/jquery.js"></script>
		<script type="text/javascript" src="/public/js/jquery.fancybox.pack.js"></script>
		<script type="text/javascript" src="/public/js/noty.js"></script>
		<script type="text/javascript" src="/public/js/bootstrap.js"></script>
		<script type="text/javascript" src="/public/js/select2.min.js"></script>
		<script type="text/javascript" src="/public/js/bootstrap-colorpicker.min.js"></script>
		<script type="text/javascript" src="/public/js/bootstrap-datepicker.js"></script>
		<script type="text/javascript" src="/public/js/moment.js"></script>
		<script type="text/javascript" src="/public/js/daterangepicker.js"></script>
		<script type="text/javascript" src="/public/js/common.js"></script>
	</head>

	<body class="cbp-spmenu-push">
	
	<div class="navbar navbar-inverse">
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				
				<div class="dropdown pull-left">
					<a data-toggle="dropdown" class="header-cog text-center navbar-brand" href="#">
						<span class="glyphicon glyphicon-cog"></span>
					</a>

					<ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
						<li><a href="/accounts"><span class="glyphicon glyphicon-credit-card"></span> Счета</a></li>
						<li><a href="/priorities"><span class="glyphicon glyphicon-bookmark"></span> Приоритеты</a></li>
						<li><a href="/transaction/destination"><span class="glyphicon glyphicon-transfer"></span> Назначения транзакций</a></li>
						<li><a href="/user/posts"><span class="glyphicon glyphicon-stats"></span> Должности</a></li>
						<li><a href="/user/prices"><span class="glyphicon glyphicon-usd"></span> Цены</a></li>
					</ul>
				</div>
			</div>
			<div class="navbar-collapse collapse">
				<ul class="nav navbar-nav">
					@if (preg_match("/^home.*/i", Route::currentRouteName()))
						<li class="active">
					@else
						<li>
					@endif
						<a href="/">Главная</a></li>

					@if (preg_match("/^users\..+/i", Route::currentRouteName()))
						<li class="active">
					@else
						<li>
					@endif
						<a href="/users">Пользователи</a></li>

					@if (preg_match("/^transactions\..+/i", Route::currentRouteName()))
						<li class="active">
					@else
						<li>
					@endif
						<a href="/transactions">Транзакции</a></li>

					@if (preg_match("/^projects\..+/i", Route::currentRouteName()))
						<li class="active">
					@else
						<li>
					@endif
						<a href="/projects">Проекты</a></li>
				</ul>
			</div><!--/.navbar-collapse -->
		</div>
	</div>