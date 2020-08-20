<?php

namespace app\widgets;

use Yii;

/**
 * Generate navbar.
 */
class TopMenuBar extends \yii\bootstrap\Widget
{
    /**
     * Native Users and app data.   
     */
    public $Menus;
    public $title;
    public $logo;

    /**
     * attributes
     */
    public $notif_nb;

    public function init()
    {
        parent::init();
    }


    public function run()
    {

        // data test.
        $this->notif_nb = 1;

        $notif_nb_front = $this->notif_nb;


        // Path url to logout.
        $logout = '' . Yii::$app->homeUrl . 'dashboard/logout';
        $logo =  '' . Yii::$app->homeUrl . 'images/avatar.png';

        return <<<HTML
        <header class="page-topbar" id="header">
                <div class="navbar navbar-fixed">
                <nav class="navbar-main navbar-color nav-collapsible sideNav-lock navbar-dark">
                    <div class="nav-wrapper">
                           <!--  <div class="header-search-wrapper hide-on-med-and-down"><i class="material-icons">search</i>
                       <input class="header-search-input z-depth-2" type="text" name="Search" placeholder="Rechercher" data-search="template-list" maxlength="40">
                        </div>-->
                        <!-- Main rights buttons -->
                        <ul class="navbar-list right">
                            <li class="hide-on-med-and-down"><a class="waves-effect waves-block waves-light toggle-fullscreen" href="javascript:void(0);"><i class="material-icons">settings_overscan</i></a></li>
                            <li class="hide-on-large-only search-input-wrapper"><a class="waves-effect waves-block waves-light search-button" href="javascript:void(0);"><i class="material-icons">search</i></a></li>
                          <!--  <li><a class="waves-effect waves-block waves-light notification-button" href="javascript:void(0);" data-target="notifications-dropdown"><i class="material-icons">notifications_none<small class="notification-badge">${notif_nb_front}</small></i></a></li>-->
                            <li><a class="waves-effect waves-block waves-light notification-button" href="javascript:void(0);" data-target="profile-dropdown"><i class="material-icons">account_circle  </i></a></li>
                        </ul>
                        <!-- notifications-dropdown-->
                       <!-- <ul class="dropdown-content" id="notifications-dropdown">
                            <li>
                                <h6>NOTIFICATIONS<span class="new badge">${notif_nb_front}</span></h6>
                            </li>
                            <li class="divider"></li>
                            <li><a class="black-text" href="#!"><span class="material-icons icon-bg-circle cyan small">add_shopping_cart</span> A new order has been placed!</a>
                                <time class="media-meta grey-text darken-2" datetime="2015-06-12T20:50:48+08:00">2 hours ago</time>
                            </li>
                        </ul>-->
                        <!-- profile-dropdown-->
                        <ul class="dropdown-content" id="profile-dropdown">
                            <li><a class="grey-text text-darken-1" href="#"><i class="material-icons">person_outline</i>Profile</a></li>
                            <li><a class="grey-text text-darken-1" href="page-faq.html"><i class="material-icons">help_outline</i>Help</a></li>
                            <li class="divider"></li>
                            <li><a class="grey-text text-darken-1" href="${logout}"><i class="material-icons">keyboard_tab</i>Logout</a></li>
                        </ul>
                    </div>
                </nav>
            </div>
        </header>
        HTML;
    }
}
