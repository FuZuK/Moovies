<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?php echo !empty($page_title) ? $page_title : 'Фильмы'; ?></title>
	<link rel="stylesheet" href="/css/bootstrap.min.css">
	<link rel="stylesheet" href="/css/bootstrap-theme.min.css">
	<link rel="stylesheet" href="/css/bootstrap-grid.min.css">
	<link rel="stylesheet" href="/css/custom.css">
	<link rel="stylesheet" href="/css/bootstrap-datetimepicker.css">
	<script src="/js/jquery-2.2.1.min.js"></script>
	<script src="/js/bootstrap.min.js"></script>
	<script src="/js/moment-with-locales.js"></script>
	<script src="/js/bootstrap-datetimepicker.js"></script>
</head>
<body>
<nav class="navbar navbar-default">
	<div class="container-fluid">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="/">Фильмы</a>
		</div>

		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			<form class="navbar-form navbar-left" action="/search.php" method="post">
				<div class="form-group">
					<input type="text" class="form-control" name="query" placeholder="Название фильма...">
				</div>
				<button type="submit" class="btn btn-default">Найти</button>
			</form>
			<ul class="nav navbar-nav navbar-right">
				<li><a href="/add.php">Добавить фильм</a></li>
				<li><a href="/import.php">Импортировать</a></li>
			</ul>
		</div>
	</div>
</nav>
<div class="container">
<?php
if (isset($_SESSION['message'])): ?>
	<div class="alert alert-success"><?php echo $_SESSION['message']; unset($_SESSION['message']); ?></div>
<?php endif; ?>