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
	</head>

	<body>

	<div class="navbar navbar-default navbar-static-top">
			<div class="container">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="#">Project name</a>
				</div>
				<div class="navbar-collapse collapse">
					<ul class="nav navbar-nav">
						<li class="active"><a href="#">Home</a></li>
						<li><a href="#about">About</a></li>
						<li><a href="#contact">Contact</a></li>
					</ul>
					<ul class="nav navbar-nav navbar-right">
						<li>{{ HTML::linkRoute('login', 'Login') }}</li>
						<li class="active"><a href="./">Static top</a></li>
						<li><a href="../navbar-fixed-top/">Fixed top</a></li>
					</ul>
				</div><!--/.nav-collapse -->
			</div>
		</div>