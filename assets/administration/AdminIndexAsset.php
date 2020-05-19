<?php

namespace app\assets\administration;

use yii\web\AssetBundle;

/**
 * Asset bundle de la vue index Administration.
 *
 * @since 2.0
 */
class AdminIndexAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $css = ['css/admin/index.css'];

    public $js = ['js/admin/index.js'];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
