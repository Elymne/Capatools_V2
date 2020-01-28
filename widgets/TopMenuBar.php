<?php
namespace app\widgets;

use Yii;
/**
 * Cette classe permet de générer le menu utilisateur
 */
class TopMenuBar extends \yii\bootstrap\Widget
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
        $string = 
        '	  <!-- barre de navigation en haut de l\'écran -->
        <div class="navbar-fixed">
          <nav class="navbar gradient">
              <div class="nav-wrapper">
     <!-- searchbox -->
                  <div class="header-search-wrapper hide-on-med-and-down">
                        <i class="material-icons white-text">search</i>
                        <input class="header-search-input z-depth-2 type="text" name="Search" placeholder="Rechercher" data-search="template-list">
                  </div>
                  <!-- /searchbox -->
                  
                  <ul id="nav-mobile" class="right">
                      <li class="hide-on-med-and-down">
                      <li><a href="#!" data-target="dropdownAvatar" class="dropdown-trigger waves-effect">
                      <span class="avatar-status avatar-online">
                      <img src="'. Yii::$app->homeUrl . 'images/avatar.png" alt="avatar" />
                      <i></i>
                      </span>
                      </a></li>
                  </ul><a href="#!" data-target="sidenav-left" class="sidenav-trigger left"><i class="material-icons black-text">menu</i></a>
              </div>
          </nav>
          </div>      
  
        
        <ul id=\'dropdownAvatar\' class=\'dropdown-content dropcontainer\'>
          <!--<li><a class="grey-text text-darken-1" href="#!"><i class="material-icons">person_outline</i>Profile</a></li>-->
          <li class="divider" tabindex="-1"></li>
      <li><a class="grey-text text-darken-1" href="'.Yii::$app->homeUrl.'dashboard/logout"><i class="material-icons">keyboard_tab</i>D&eacute;connexion</a></li>
      </ul>';
      
  
        return $string;
    }

}