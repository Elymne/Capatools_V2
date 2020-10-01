<?php

namespace app\assets\projects;

use yii\web\AssetBundle;

/**
 * Asset bunfle de la vue index des projet.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class ProjectIndexDraftAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $css = ['css/projects/index.css'];

    public $js = ['js/projects/index-draft.js'];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
