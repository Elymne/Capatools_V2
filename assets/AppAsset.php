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

        // Dark forest theme.
        'app-assets/vendors/vendors.min.css',
        'app-assets/css/themes/vertical-dark-menu-template/materialize.min.css',
        'app-assets/css/themes/vertical-dark-menu-template/style.min.css',
        'app-assets/css/pages/dashboard.min.css',

        // Timeline item css.
        'css/timeline.css',

        // Generic custom.
        'css/custom.css',
        // Custom button.
        'css/custom-button.css',
        // Custom colors.
        'css/custom-color.css',
        // Custom table.
        'css/custom-table.css',
        // Custom spacing.
        'css/spacing.css',
        // Table sort.
        'css/table-sort.css',
    ];

    public $js = [
        // JS Admin Template Html.
        'app-assets/js/vendors.min.js',
        'app-assets/js/plugins.min.js',
        'app-assets/js/search.min.js',
        'app-assets/js/custom/custom-script.js',

        // Form js.
        'js/jquery.steps.js',
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
