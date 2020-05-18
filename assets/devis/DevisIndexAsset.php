<?php

namespace app\assets\devis;

use yii\web\AssetBundle;

/**
 * Asset bunfle de la vue index des devis.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class DevisIndexAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $css = ['css/devis/index.css'];

    public $js = ['js/devis/index.js'];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
