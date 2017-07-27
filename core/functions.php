<?php
function errors() {
	global $err;

	if (!empty($err)) {
		$errors_html = '<div class="alert alert-danger">';
		foreach ($err as $error) {
			$errors_html .= $error . "<br>";
		}
		$errors_html .= "</div>";
		return $errors_html;
	}
}

function message($message) {
	$_SESSION['message'] = $message;
}

function empty_message($message) {
	return '<div class="alert alert-warning">'.$message.'</div>';
}

function form_input($str) { return htmlentities($str, ENT_QUOTES, 'UTF-8'); }

function addFilm($name, $year, $format, $actors) {
	global $db;

	$db->prepare('INSERT INTO `films` (`name`, `year`, `format`) VALUES (?, ?, ?)')
		->execute([ $name, $year, $format ]);
	$film_id = $db->lastInsertId();
	handleFilmActors($film_id, $actors);

	return $film_id;
}

function handleFilmActors($film_id, $actors) {
	global $db;

	$actors_array = array_map(function ($value) {
		return trim($value);
	}, explode(',', $actors));
	$actors_ids = [];
	foreach ($actors_array as $actor_name) {
		$stmt = $db->prepare('SELECT `id` FROM `actors` WHERE `name` = ?');
		$result = $stmt->execute([ $actor_name ]);
		if ($stmt->rowCount()) {
			$actor_id = $stmt->fetch()->id;
		}
		else {
			$db->prepare('INSERT INTO `actors` (`name`) VALUES (?)')->execute([ $actor_name ]);
			$actor_id = $db->lastInsertId();
		}
		$actors_ids[$actor_id] = $actor_id;
	}

	if (!empty($actors_ids))
		$db->query("INSERT INTO `films_actors` (`id_actor`, `id_film`) VALUES ('" . implode("', '{$film_id}'), ('", $actors_ids) . "', '{$film_id}')");
}

function filmActorsArray($film_id) {
	global $db;

	$stmt = $db->prepare('SELECT `actors`.* FROM `films_actors` RIGHT JOIN `actors` ON `films_actors`.`id_actor` = `actors`.`id` WHERE `films_actors`.`id_film` = ?');
	$stmt->execute([ $film_id ]);

	$actors = [];
	while ($actor = $stmt->fetch())
		$actors[$actor->id] = $actor->name;

	return $actors;
}

function filmActors($film_id) {
	$actors = filmActorsArray($film_id);

	$actors_html = '';
	foreach ($actors as $actor_id => $actor_name)
		$actors_html .= ($actors_html ? ", " : "") . htmlentities($actor_name);

	return $actors_html;
}

function filmActorsLinks($film_id) {
	$actors = filmActorsArray($film_id);

	$actors_html = '';
	foreach ($actors as $actor_id => $actor_name)
		$actors_html .= ($actors_html ? ", " : "") . "<a href='actor.php?id={$actor_id}'>" . htmlentities($actor_name) . "</a>";

	return $actors_html;
}