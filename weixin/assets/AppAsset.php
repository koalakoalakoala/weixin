<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace weixin\assets;

use yii\web\AssetBundle;
use yii\web\View;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $jsOptions = ['position'=>View::POS_HEAD];
    public $css = [
        'css/site.css',
        'css/comm.css',
        'css/wglobal.css',
        'css/css2.css',
        'css/swiper.min.css',
        //'css/custom-theme/jquery-ui-1.9.2.custom.css'
    ];
    public $js = [
        'js/hhSwipe.js',
        'js/jquery-1.9.1.min.js',
        'js/jquery-ui.min.js',
        'js/jquery.form.js',
        'js/jquery.simplesidebar.js',
        'js/swiper.min.js',
        'js/websrcipt.js',
        'js/easyResponsiveTabs.js',
        'js/jquery.similar.msgbox.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
