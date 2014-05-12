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
		<link href="/public/css/bootstrap-switch.min.css" rel="stylesheet">
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
		<script type="text/javascript" src="/public/js/bootstrap-switch.min.js"></script>
		<script type="text/javascript" src="/public/js/common.js"></script>
	</head>

	<body class="cbp-spmenu-push">
	
	<div class="navbar navbar-inverse" id="header">
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				
				<div class="dropdown pull-left">
					@if ($routes['is_config'])
						<a data-toggle="dropdown" class="active header-cog text-center navbar-brand" href="#">
					@else
						<a data-toggle="dropdown" class="header-cog text-center navbar-brand" href="#">
					@endif
						<span class="glyphicon glyphicon-cog"></span>
					</a>

					<ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
						<!-- Accounts -->
						@if ($routes['is_accounts'])
							<li class="active">
						@else
							<li>
						@endif
							<a href="/accounts"><span class="glyphicon glyphicon-credit-card"></span> Счета</a>
						</li>

						<!-- Priorities -->
						@if ($routes['is_priorities'])
							<li class="active">
						@else
							<li>
						@endif
							<a href="/priorities"><span class="glyphicon glyphicon-bookmark"></span> Приоритеты</a>
						</li>

						<!-- Transaction purposes -->
						@if ($routes['is_transaction_purposes'])
							<li class="active">
						@else
							<li>
						@endif
							<a href="/transactions/purposes"><span class="glyphicon glyphicon-transfer"></span> Назначения транзакций</a>
						</li>

						<!-- User roles -->
						@if ($routes['is_user_roles'])
							<li class="active">
						@else
							<li>
						@endif
							<a href="/users/roles"><span class="glyphicon glyphicon-stats"></span> Должности</a>
						</li>

						<!-- User roles -->
						@if ($routes['is_exchange'])
							<li class="active">
						@else
							<li>
						@endif
							<a href="/exchange"><span class="glyphicon glyphicon-euro"></span> Валюты</a>
						</li>
					</ul>
				</div>
			</div>
			<div class="navbar-collapse collapse">
				<ul class="nav navbar-nav">
					@if ($routes['is_home'])
						<li class="active">
					@else
						<li>
					@endif
						<a href="/">Главная</a></li>

					@if ($routes['is_users'])
						<li class="active">
					@else
						<li>
					@endif
						<a href="/users">Пользователи</a></li>

					@if ($routes['is_transactions'])
						<li class="active">
					@else
						<li>
					@endif
						<a href="/transactions">Транзакции</a></li>

					@if ($routes['is_projects'])
						<li class="active">
					@else
						<li>
					@endif
						<a href="/projects">Проекты</a></li>
				</ul>
			</div><!--/.navbar-collapse -->
		</div>
	</div>