<?php

namespace app\assets\projects;

use yii\web\AssetBundle;

/**
 * Asset bunfle de la vue index des projet.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class ProjectIndexMilestonesAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $css = [];

    public $js = ['js/projects/indexMilestones.js'];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
