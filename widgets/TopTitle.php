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

        $imagePath =  'https://admin.preprod.capatools.fr/web/images/breadcrumb.png';

        return <<<HTML
            <div id="breadcrumbs-wrapper" data-image="${imagePath}">
                <!-- Search for small screen-->
                <div class="container">
                    <div class="row">
                        <div class="col s12">
                            <span><b>${title}</b></span>
                        </div>
                    </div>
                </div>
            </div>
        HTML;
    }
}
