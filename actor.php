<?php
require_once 'core/start.php';

if (empty($_GET['id'])) {
	require_once HEAD;
	echo error('Актёр не найден');
	require_once FOOT;
}

$actor_id = (int) $_GET['id'];
$stmt = $db->prepare('SELECT * FROM `actors` WHERE `id` = ?');
$stmt->execute([ $actor_id ]);
if (!$stmt->rowCount()) {
	require_once HEAD;
	echo error('Актёр не найден');
	require_once FOOT;
}
$actor = $stmt->fetch();

$page_title = htmlentities($actor->name);
require_once HEAD;
?>
<h1><?php echo $page_title; ?></h1>
<?php
$stmt = $db->prepare('SELECT `films`.* FROM `films_actors` RIGHT JOIN `films` ON `films_actors`.`id_film` = `films`.`id` WHERE `films_actors`.`id_actor` = ?');
$stmt->execute([ $actor->id ]);
if ($stmt->rowCount())
	while ($film = $stmt->fetch()) {
		require 'items/film.php';
	}
else
	echo empty_message('Список фильмо пуст');
require_once FOOT;