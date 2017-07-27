<div class="col-xs-12 col-md-3">
	<div class="panel panel-success film-item">
		<div class="panel-heading">
			<a href="/film.php?id=<?php echo $film->id; ?>"><?php echo htmlentities($film->name); ?></a>
		</div>
		<div class="panel-body">
			Год выпуска: <?php echo htmlentities($film->year); ?><br>
			Формат: <?php echo htmlentities($config['formats'][$film->format]); ?><br>
			Актеры: <?php echo filmActorsLinks($film->id); ?><br>
		</div>
	</div>
</div>