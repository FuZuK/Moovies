<?php
require_once 'core/start.php';

if (empty($_GET['id'])) {
	require_once HEAD;
	echo error('Фильм не найден');
	require_once FOOT;
}

$film_id = (int) $_GET['id'];
$stmt = $db->prepare('SELECT * FROM `films` WHERE `id` = ?');
$stmt->execute([ $film_id ]);
if (!$stmt->rowCount()) {
	require_once HEAD;
	echo error('Фильм не найден');
	require_once FOOT;
}
$film = $stmt->fetch();

$page_title = htmlentities($film->name);
require_once HEAD;
?>
<div class="panel panel-success">
	<div class="panel-heading">
		<?php echo $page_title; ?>
	</div>
	<div class="panel-body">
		Год выпуска: <?php echo htmlentities($film->year); ?><br>
		Формат: <?php echo htmlentities($config['formats'][$film->format]); ?><br>
		Актёры: <?php echo filmActorsLinks($film->id); ?><br>
	</div>
	<div class="panel-footer">
		<a href="/delete.php?id=<?php echo $film->id; ?>" class="text-danger"><span class="glyphicon glyphicon-trash"></span> Удалить фильм</a><br>
	</div>
</div>
<?php require_once FOOT; ?>