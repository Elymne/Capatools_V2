<?php

namespace app\assets\devis;

use yii\web\AssetBundle;

/**
 * Asset bundle pour la vue de la création d'un devis.
 * 
 * @since 2.0
 */
class RefactoringAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $css = [
        // Formjs.
        'css/devis/create.css',
    ];

    public $js = ['js/devis/refactoring.js'];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
