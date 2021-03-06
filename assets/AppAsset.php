<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Main application asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
        'css/bootstrap-datetimepicker.css',
        'css/font-awesome.css'
    ];
    public $js = [
        'js/sweetAlerts.js',
        'js/moment.js',
        'js/bootstrap-datetimepicker.js',
        'js/font-awesome.js',
        ['js/entry.js', 'type' => 'module'],
        ['js/contact.js', 'type' => 'module'],
        ['js/descriptive.js', 'type' => 'module']
    ];
    public $jsOptions = array(
        'position' => \yii\web\View::POS_HEAD
    );
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap4\BootstrapAsset',
        'yii\web\JqueryAsset'
    ];
}
