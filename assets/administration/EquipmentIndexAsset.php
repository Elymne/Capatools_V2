<?php

namespace app\assets\administration;

use yii\web\AssetBundle;

class EquipmentIndexAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $css = ['css/admin/index.css'];

    public $js = ['js/admin/indexEquipment.js'];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
