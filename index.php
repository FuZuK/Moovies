<?php
require_once 'core/start.php';
require_once HEAD;

$stmt = $db->query("SELECT * FROM `films` ORDER BY `name` ASC");
$stmt->execute();
if ($stmt->rowCount()) {
	?><div class="row row-eq-height"><?php
	while ($film = $stmt->fetch()) {
		require 'items/film.php';
	}
	?></div><?php
}
else
	echo empty_message('Список фильмов пуст');
require_once FOOT;