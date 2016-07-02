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
class WatchesAsset extends AssetBundle
{
    public $basePath = '@webroot/themes/watches';
    public $baseUrl = '@web/themes/watches';
    public $css = [
        'css/frontend/reset.css',
        'css/frontend/layout.css',
        'css/frontend/desktop.css',
        'css/frontend/mobile.css',
    ];
    public $js = [
			'js/frontend/iscroll.js',
			'js/frontend/velocity.js',
			'js/frontend/index_animation.js',
			'js/frontend/script.js',
			'js/frontend/scroller.js',
            'js/frontend/textmin.js',
			'js/frontend/main_front.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        // 'yii\bootstrap\BootstrapAsset',
    ];
}
