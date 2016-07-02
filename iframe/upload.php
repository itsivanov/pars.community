<?php
// Создаем подключение к серверу
$db = mysql_connect ("localhost","root","root");
// Выбираем БД
mysql_select_db ("images",$db);


$name = $_POST['name'];

	mysql_query ("INSERT INTO images (filename) VALUES ('$name')");
	echo $randomName.":загружен успешно";


?>
