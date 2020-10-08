<?php

namespace app\assets\companies;

use yii\web\AssetBundle;

/**
 * Asset bundle de la vue create Company.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class CompanyIndexAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $css = ['css/companies/index.css'];

    public $js = ['js/companies/index.js'];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
