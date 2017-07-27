<?php
require_once 'core/start.php';

$page_title = 'Поиск фильмов';
require_once HEAD;

if (!empty($_REQUEST['query'])) {
	$type = !empty($_REQUEST['type']) && in_array($_REQUEST['type'], [ 'by_name', 'by_actor_name' ]) ? $_REQUEST['type'] : 'by_name';
	$query = $_REQUEST['query'];
}

?>
<form action="/search.php" method="post">
	<div class="form-group">
		<input type="text" class="form-control" name="query" value="<?php echo isset($query) ? form_input($query) : ''; ?>" placeholder="Название фильма...">
	</div>
	<div class="form-group">
		<label>
			<input type="radio" name="type" value="by_name"<?php echo ($type == 'by_name' ? ' checked' : ''); ?>>
			Поиск по названию
		</label><br>
		<label>
			<input type="radio" name="type" value="by_actor_name"<?php echo ($type == 'by_actor_name' ? ' checked' : ''); ?>>
			Поиск по имени актёра
		</label>
	</div>
	<button type="submit" class="btn btn-default">Найти</button>
</form>
<hr>
<?php

if (isset($query)) {
	if ($type == 'by_name') {
		$stmt = $db->prepare("SELECT * FROM `films` WHERE `name` LIKE ? ORDER BY `name` ASC");
	} elseif ($type == 'by_actor_name') {
		$stmt = $db->prepare("SELECT `films`.* FROM `films` LEFT JOIN `films_actors` ON `films`.`id` = `films_actors`.`id_film` LEFT JOIN `actors` ON `films_actors`.`id_actor` = `actors`.`id` WHERE `actors`.`name` LIKE ? ORDER BY `films`.`name` ASC");
	}
	$stmt->execute([ '%'.$query.'%' ]);
	if ($stmt->rowCount())
		while ($film = $stmt->fetch())
			require 'items/film.php';
	else
		echo empty_message('По Вашему запросу ничего не найдено');
}
require_once FOOT;