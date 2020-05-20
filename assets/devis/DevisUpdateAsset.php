<?php

namespace app\assets\devis;

use yii\web\AssetBundle;

/**
 * Asset bundle pour la vue de la création d'un devis.
 * 
 * @since 2.0
 */
class DevisUpdateAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $css = [
        // Formjs.
        'css/step-form.css',
        'css/devis/create.css',
    ];

    public $js = ['js/devis/update.js'];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
