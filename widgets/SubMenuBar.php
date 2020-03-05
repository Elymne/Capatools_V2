<?php

namespace app\widgets;

use yii\widgets\Menu;
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
        $subitems = array();
        asort($this->subMenuList);

        foreach ($this->subMenuList as $submenu) {

            $active = $this::isActive($submenu['active']);

            $item = [
                'label' => $submenu['label'],
                'url' => [$submenu['url']],
                'template' => '<li><a ' . $active . ' href="{url}"><i class="material-icons">radio_button_unchecked</i><span>{label}</span></a></li>',
            ];
            array_unshift($subitems, $item);
        }

        $string = Menu::widget([
            'items' => [
                [
                    'label' => $this->titleSub,
                    'options' => ['class' => 'bold waves-effect'],
                    'template' => '<li class="active bold"><a class="collapsible-header waves-effect waves-cyan "href="JavaScript:void(0)"><i class="material-icons">settings_input_svideo</i><span class="menu-title">{label}</span></a>',
                    'items' => $subitems

                ]
            ],
            'submenuTemplate' => '<div class="collapsible-body"><ul class="collapsible collapsible-sub" data-collapsible="accordion">{items}</ul></div>',
            'options' => [
                'class' => 'collapsible collapsible-accordion'
            ]
        ]);

        return $string;
    }


    private function isActive($string)
    {
        if (Yii::$app->params['activeMenu'] == $string)
            return 'class="active"';
        else
            return '';
    }
}
