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

        // Fonts
        'fonts/apple-touch-icon-152x152.png',
        'fonts/favicon-32x32.png',
        'https://fonts.googleapis.com/icon?family=Material+Icons',

        // Design Admin Template Html.
        'css/vendors.min.css',
        'css/materialize.css',
        'css/style.css',
        'css/dashboard.css',
        'css/custom.css',

        // Timeline item css.
        'css/timeline.css',

    ];

    public $js = [

        // JS Admin Template Html.
        'js/vendors.min.js',
        'js/plugins.js',
        'js/search.js',
        'js/custom-script.js',

        // Materialize js.
        //'js/materialize.min.custom.js',

        // Js file.
        //'js/capatools.js'
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
