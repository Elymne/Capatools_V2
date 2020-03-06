<?php

namespace app\widgets;

use yii\base\Widget;
use Yii;

class SubMenuBar extends Widget
{

    public $title;
    public $subMenuList;
    public $serviceMenuActive;

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        return $this->header() . $this->body() . $this->footer();
    }

    private function header()
    {

        $title = $this->title;
        $serviceMenuActive = $this::isServiceMenuActive($this->serviceMenuActive);

        return <<<HTML
            <li ${serviceMenuActive}><a class="collapsible-header waves-effect waves-cyan " href="JavaScript:void(0)"><i class="material-icons">settings_input_svideo</i><span class="menu-title">${title}</span></a>
                <div class="collapsible-body">
                    <ul class="collapsible collapsible-sub" data-collapsible="accordion">
        HTML;
    }

    private function body()
    {

        $body = '';

        foreach ($this->subMenuList as $subMenu) {

            $subServiceMenuActive = $this::isSubServiceMenuActive($subMenu['subServiceMenuActive']);
            $label = $subMenu['label'];
            $url = $subMenu['url'];

            $body = $body . <<<HTML
                <li ${subServiceMenuActive}>
                    <a ${subServiceMenuActive} href="/${url}">
                        <i class="material-icons">radio_button_unchecked</i>
                        <span>${label}</span>
                    </a>
                </li>
            HTML;
        }

        return $body;
    }

    private function footer()
    {
        return <<<HTML
                    </ul>
                </div>
            </li>
        HTML;
    }

    /**
     * @param String Actual param of sub menu element. Check SubMenuEnum.php file.
     * @return String Css class if condition's true.
     */
    private function isSubServiceMenuActive($subServiceMenuActive)
    {
        if (Yii::$app->params['subServiceMenuActive'] == $subServiceMenuActive)
            return 'class="active"';
        else
            return '';
    }

    /**
     * @param String
     */
    private function isServiceMenuActive($serviceMenuActive)
    {
        if (Yii::$app->params['serviceMenuActive'] == $serviceMenuActive)
            return 'class="active"';
        else
            return '';
    }
}
