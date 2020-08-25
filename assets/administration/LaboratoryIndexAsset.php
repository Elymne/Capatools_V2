<?php

namespace app\assets\administration;

use yii\web\AssetBundle;

class LaboratoryIndexAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $css = [];

    public $js = ['js/admin/indexLaboratory.js'];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
