<?php

namespace app\widgets;

use yii\base\Widget;
use Yii;

class TopTitle extends Widget
{

    public $title;

    public function init()
    {
        parent::init();
    }

    public function run()
    {

        $title = $this->title;

        $imagePath =  '' . Yii::$app->homeUrl . 'images/breadcrumb.png';

        return <<<HTML
            <div id="breadcrumbs-wrapper" data-image="${imagePath}">
                <!-- Search for small screen-->
                <div class="container">
                    <div class="row">
                        <div class="col s12 m6 l6">
                            <h5 class="breadcrumbs-title mt-0 mb-0"><span>${title}</span></h5>
                        </div>
                    </div>
                </div>
            </div>
        HTML;
    }
}
