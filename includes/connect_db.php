<?php error_reporting(-1);
	require_once('config.php');

	mysql_connect(DATABASE_HOST, DATABASE_USER, DATABASE_PASS) or die ("Ошибка подключения к базе данных.");
	mysql_select_db(DATABASE_NAME);
?>