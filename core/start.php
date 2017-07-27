<?php
define('ROOT', $_SERVER['DOCUMENT_ROOT']);
define('HEAD', ROOT . '/core/head.php');
define('FOOT', ROOT . '/core/foot.php');

$config = require_once 'config.php';
try {
	$db = new PDO('mysql:host=' . $config['DB_HOST'] . ';dbname=' . $config['DB_NAME'], $config['DB_USER'], $config['DB_PASSWORD']);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
	$db->query('SET NAMES utf8mb4');
} catch (PDOException $e) {
	die($e->getMessage());
}

session_start();

require_once 'functions.php';