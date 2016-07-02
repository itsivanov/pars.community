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
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/frontend/reset.css',
        'css/frontend/layout.css',
        'css/frontend/desktop.css',
        'css/frontend/mobile.css',
        //'css/frontend/site.css',

        // Additional
        'css/frontend/main_front.css',
    ];
    public $js = [
        // 'js/frontend/jquery-1.12.0_min.js',
        //'js/frontend/jquery.label_better.min.js',
        'js/frontend/iscroll.js',
        'js/frontend/index_animation.js',
        'js/frontend/velocity.js',
        'js/frontend/content_grid.js',
        //'js/frontend/scroller.js',
        'js/frontend/menus.js',
        'js/frontend/script.js',
        'js/frontend/textmin.js',
        'js/frontend/formSender.js',

        // Additional
        'js/frontend/main_front.js',
        'js/frontend/contact_us.js',

    ];
    public $depends = [
        'yii\web\YiiAsset',
        // 'yii\bootstrap\BootstrapAsset',
    ];
}
