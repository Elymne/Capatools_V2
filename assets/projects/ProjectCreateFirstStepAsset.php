<?php

namespace app\assets\projects;

use yii\web\AssetBundle;

/**
 * Asset bundle pour la vue de la création d'un projet.
 * 
 * @since 2.0
 */
class ProjectCreateFirstStepAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $css = ['css/projects/createFirstStep.css'];

    public $js =  ['js/projects/createFirstStep.js'];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
