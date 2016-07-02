<?php

	$environmentDbPath = __DIR__.'/environment_db.php';

if (file_exists($environmentDbPath)) {

	require_once $environmentDbPath;

	return [
	    'class' => 'yii\db\Connection',
	    'dsn' => 'mysql:host='.DB_HOST.';dbname='.DB_NAME,
	    'username' => DB_USERNAME,
	    'password' => DB_PASSWORD,
	    'charset' => 'utf8',
	];

} else {

	return [
	    'class' => 'yii\db\Connection',
	    'dsn' => 'mysql:host=localhost;dbname=dbname',
	    'username' => 'username',
	    'password' => 'password',
	    'charset' => 'utf8',
	];

}
