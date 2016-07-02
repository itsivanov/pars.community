<?php
//Данные для ведения логов
$result = array();

$result['time'] = date('r');
$result['addr'] = substr_replace(gethostbyaddr($_SERVER['REMOTE_ADDR']), '******', 0, 6);
$result['agent'] = $_SERVER['HTTP_USER_AGENT'];

if (count($_GET)) {
	$result['get'] = $_GET;
}
if (count($_POST)) {
	$result['post'] = $_POST;
}
if (count($_FILES)) {
	$result['files'] = $_FILES;
}


if (file_exists('script.log') && filesize('script.log') > 102400) {
	unlink('script.log');
}
//Запись данных в лог файл
$log = @fopen('script.log', 'a');
if ($log) {
	fputs($log, print_r($result, true) . "\n---\n");
	fclose($log);
}


//Изначально у нас нет ошибок
$error = false;

//Определяем, был ли файл загружен при помощи HTTP POST
if (!isset($_FILES['Filedata']) || !is_uploaded_file($_FILES['Filedata']['tmp_name'])) {
	$error = 'Invalid Upload';
}


//Проверяем размер загружаемых файлов
if (!$error && $_FILES['Filedata']['size'] > 2 * 1024 * 1024){
	$error = 'Размер загружаемого файла не должен превышать 2 Мб';
}

//Если появились ошибки возвращаем их
if ($error) {

	$return = array(
		'status' => '0',
		'error' => $error
	);

} else {//Если ошибок нет

	$return = array(
		'status' => '1',
		'name' => $_FILES['Filedata']['name']
	);

	//Получаем информацию о загруженном файле
	$info = @getimagesize($_FILES['Filedata']['tmp_name']);

	if ($info) {
		$return['width'] = $info[0];//ширина картинки в пикселях
		$return['height'] = $info[1];//высота в пиксилях
	}
	$filename = $_FILES['Filedata']['name'];//Определяем имя файла
	$ext = substr($filename,strpos($filename,'.'),strlen($filename)-1);//Определяем расширение файла
	$new = date("Ymd")."_".rand(1000,9999).$ext;//Генерируем новое имя файла во избежании совпадения названий
	$return['new'] = $new;//Возвращаем имя нового файла

	if(!move_uploaded_file($_FILES['Filedata']['tmp_name'], '../uploads/'.$new)) //Загружаем файл с новым именем.
	//Не забудьте установить на каталог uploads права на запись 755 или 777
	{
		$return = array(
		'status' => '0',
		'error' => 'Загрузка не удалась'
		);
	}
}


if (isset($_REQUEST['response']) && $_REQUEST['response'] == 'xml') {
	// header('Content-type: text/xml');

	// Really dirty, use DOM and CDATA section!
	echo '<response>';
	foreach ($return as $key => $value) {
		echo "<$key><![CDATA[$value]]></$key>";
	}
	echo '</response>';
} else {
	// header('Content-type: application/json');

	echo json_encode($return);

}

?>
