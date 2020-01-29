<?php
namespace app\widgets;
use yii\widgets\Menu;
use yii\base\Widget;
use Yii;

class SubMenuBar extends Widget
{
    /**
     * Title of the submenu
     * */
    public $titleSub;
/**
 * Array de sous menu
 */
    public $Submenulist;

    public function SettitleSub($title)
    {
        $this->titleSub = $title;
    }



    public function SetSubmenulist($Submenulist)
    {
        $this->Submenulist = $Submenulist;
    }


    public function init()
    {
        parent::init();

    }

    public function run()
    {
        $subitems = array();
        asort($this->Submenulist);
        //Parcours des sous menu du service afin de créer les liens.
        foreach($this->Submenulist as &$submenu)
        {
            $item =  ['label' => $submenu['label'], 'url' => [ $submenu['url']],
            'template' => '<a href="{url}" class="waves-effect">{label}<i class="material-icons">'.$submenu['icon'].'</i></a>'];
            array_unshift( $subitems, $item);
      
        }

        $string = Menu::widget([
            'items' =>[
                [
               'label' => $this->titleSub,
                'options'=>['class'=>'bold waves-effect'],
                'template' => '<a class="collapsible-header" >{label}<i class="material-icons chevron">chevron_left</i></a>',
                'items' =>$subitems
                  
                ]
            ],
            'submenuTemplate' => '<div class="collapsible-body"><ul>{items}</ul></div>',
           'options' => array( 'class' => 'collapsible collapsible-accordion' )
            ]);

         

  
        return $string;
    }   
}