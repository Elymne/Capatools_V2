<?php

namespace app\widgets;

use yii\base\Widget;
use Yii;

class SubMenuBar extends Widget
{

    public $titleSub;
    public $subMenuList;

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

        $titleSub = $this->titleSub;

        return <<<HTML
            <li><a class="collapsible-header waves-effect waves-cyan " href="JavaScript:void(0)"><i class="material-icons">settings_input_svideo</i><span class="menu-title">${titleSub}</span></a>
                <div class="collapsible-body">
                    <ul class="collapsible collapsible-sub" data-collapsible="accordion">
        HTML;
    }

    private function body()
    {

        $body = '';

        foreach ($this->subMenuList as $subMenu) {

            $active = $this::isActive($subMenu['active']);
            $label = $subMenu['label'];
            $url = $subMenu['url'];

            $body = $body . <<<HTML
                <li ${active}>
                    <a ${active} href="/${url}">
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

    private function isActive($string)
    {
        if (Yii::$app->params['activeMenu'] == $string)
            return 'class="active"';
        else
            return '';
    }
}
