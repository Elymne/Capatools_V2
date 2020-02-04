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
        $Ctrls =  Yii::$app->DiscoverService->getServices();
        $ActionsCtrl = array();

        //Pour chaque controller service on récupére la listes des actions filtrer par droit d'utilisateur (nom du service, priorité d'affichage, liste des actions)
        foreach($Ctrls as &$ctrl)
        {
            $Action = $ctrl::GetActionUser(Yii::$app->user);
           
            array_unshift( $ActionsCtrl, $Action);

        }
        asort($ActionsCtrl);   
        $stringSubmenu="";
        //Création des menus et sous menus
        foreach ($ActionsCtrl as &$Action)
        {
          
          $stringSubmenu = $stringSubmenu. SubMenuBar::widget(['titleSub'=> $Action['Name'], 'Submenulist'=> $Action['items']]);
      
        }
        
        $string = 
        '<ul id="sidenav-left" class="sidenav sidenav-fixed">
        <li><a href="'.Yii::$app->homeUrl.'" class="logo-container">'.Yii::$app->name.'<i class="material-icons left"><img src="'.Yii::$app->homeUrl.'images/logo.png"/></i></a></li>
        <li class="no-padding">
      '.$stringSubmenu.'</li>
        </ul>';


       
      return $string;
    }

}