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
 * Permet d'ajouter du css et du js sur chaque vue.
 * Cette classe est chargé par défaut.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $css = [
        //default Yii css.
        'css/site.css',

        // Fonts
        'fonts/apple-touch-icon-152x152.png',
        'fonts/favicon-32x32.png',
        'https://fonts.googleapis.com/icon?family=Material+Icons',

        // Dark forest theme + materialize.
        'css/dark-forest/vendors.min.css',
        'css/dark-forest/materialize.min.css',
        'css/dark-forest/style.min.css',

        // Timeline item css.
        'css/timeline.css',
        // Generic custom.
        'css/custom.css',
        // Custom button.
        'css/custom-button.css',
        // Custom spacing.
        'css/spacing.css',
        // Table sort.
        'css/table-sort.css',

        // Helvetica Font
        "https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap"
    ];

    public $js = [
        // JS Admin Template Html.
        'js/dark-forest/vendors.min.js',
        'js/dark-forest/plugins.min.js',
        'js/dark-forest/search.min.js',
        'js/dark-forest/custom-script.js',

        // Form js.
        'js/jquery.steps.js',
        'js/capatools.js',
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
