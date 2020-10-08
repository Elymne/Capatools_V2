<?php

namespace app\assets\companies;

use yii\web\AssetBundle;

class ContactViewAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $css = ['css/companies/index.css'];

    public $js = ['js/companies/contact.js'];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
