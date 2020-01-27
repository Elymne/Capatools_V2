<?php
namespace app\widgets;

use Yii;
/**
 * Cette classe permet de générer le menu utilisateur
 */
class LeftMenuBar extends \yii\bootstrap\Widget
{
    /**
     * Paramètre contenant l'ensemble des menus donnée par l'utilisateur    
     */
    public $Menus;

    public $title;

    public $logo;

    public function init()
    {
        parent::init();

    }

    public function run()
    {
        
        return Html::encode($this->Menus);
    }

}