<?php

namespace app\widgets;

use Yii;

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

        $homeNav = '' . Yii::$app->homeUrl . '';
        $logo_capa =  '' . Yii::$app->homeUrl . 'images/materialize-logo.png';
        $logo_capa_color =  '' . Yii::$app->homeUrl . 'images/materialize-logo-color.png';

        $ctrls =  Yii::$app->discoverService->getServices();
        $actionsCtrl = array();

        //Pour chaque controller service on récupére la listes des actions filtrer par droit d'utilisateur (nom du service, priorité d'affichage, liste des actions)
        foreach ($ctrls as &$ctrl) {
            $action = $ctrl::getActionUser();
            if (!empty($action) && $action != null) {
                array_unshift($actionsCtrl, $action);
            }
        }
        asort($actionsCtrl);
        $stringSubmenu = "";
        //Création des menus et sous menus
        foreach ($actionsCtrl as $action) {
            $stringSubmenu =
                $stringSubmenu . SubMenuBar::widget([
                    'title' => $action['name'],
                    'subMenuList' => $action['items'],
                    'serviceMenuActive' => $action['serviceMenuActive']
                ]);
        }

        return <<<HTML
            <aside class="sidenav-main nav-expanded nav-lock nav-collapsible sidenav-dark sidenav-active-rounded">
                <!-- Title, laissez le tag h1 sur une seule ligne. -->
                <div class="brand-sidebar">
                    <h1 class="logo-wrapper"><a class="brand-logo darken-1" href="${homeNav}"><img class="hide-on-med-and-down " src="${logo_capa}" alt="materialize logo" /><img class="show-on-medium-and-down hide-on-med-and-up" src="${logo_capa_color}" alt="materialize logo" /><span class="logo-text hide-on-med-and-down">CapaTools</span><a class="navbar-toggler" href="#"></a></h1>
                </div>
                <ul class="sidenav sidenav-collapsible leftside-navigation collapsible sidenav-fixed menu-shadow" id="slide-out" data-menu="menu-navigation" data-collapsible="accordion">
                    ${stringSubmenu}
                </ul>               
                <div class="navigation-background"></div>
                <a class="sidenav-trigger btn-sidenav-toggle btn-floating btn-medium waves-effect waves-light hide-on-large-only" href="#" data-target="slide-out">
                    <i class="material-icons">menu</i>
                </a>
            </aside>
        HTML;
    }
}
