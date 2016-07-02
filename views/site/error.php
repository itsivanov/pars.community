<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

$this->title = $name;
?>
<div class="site-error">

<?php
header("HTTP/1.1 301 Moved Permanently");
header("Location: http://".$_SERVER['HTTP_HOST']);
exit();
?>

</div>
