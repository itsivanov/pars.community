<?php

// comment out the following two lines when deployed to production
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'false');
// defined('YII_ENV_DEV') or define('YII_ENV_DEV', true);

require(__DIR__ . '/../vendor/autoload.php');
require(__DIR__ . '/../vendor/yiisoft/yii2/Yii.php');

$config = require(__DIR__ . '/../config/web.php');

function dump($value) {
  \yii\helpers\VarDumper::dump($value,10,true);
}

function dd($value) {
  dump($value);
  die();
}

(new yii\web\Application($config))->run();
