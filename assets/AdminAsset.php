<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AdminAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'adminTheme/styles/loader.css',
        'adminTheme/bower_components/font-awesome/css/font-awesome.min.css',
        'adminTheme/bower_components/material-design-iconic-font/dist/css/material-design-iconic-font.min.css',
        'adminTheme/styles/main.css',
        '//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css',
        'css/backend/main.css',
        'js/backend/mt-select/chosen.min.css',
        'css/backend/selectric.css',
    ];
    public $js = [
        //'adminTheme/scripts/vendor.js',
        //'adminTheme/scripts/ui.js',
        //'adminTheme/scripts/app.js',
        '//code.jquery.com/ui/1.11.4/jquery-ui.js',
        'js/backend/main.js',
        'js/backend/modal.js',
        'js/backend/mt-select/chosen.jquery.min.js',
        'js/backend/loader.js',
        'js/backend/jquery.selectric.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
