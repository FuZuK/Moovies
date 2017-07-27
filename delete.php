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

if (isset($_POST['delete'])) {
	$db->query('DELETE FROM `films` WHERE `id` = ' . $film->id);
	message('Фильм успешно удалён');
	header('Location: /');
	exit;
}

$page_title = 'Удалить фильм';
require_once HEAD;
?>

<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-default">
            <div class="panel-heading"><?php echo $page_title; ?></div>
            <div class="panel-body">
                <form class="form-horizontal" role="form" method="POST" action="">
                    <div class="form-group">
                        <label for="actors" class="col-md-4 control-label">Удалить фильм "<b class="text-primary"><?php echo htmlentities($film->name); ?></b>"?</label>
                        <div class="col-md-6">
                            <button type="submit" name="delete" class="btn btn-primary">
                                Удалить
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php require_once FOOT; ?>