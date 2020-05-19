<?php

namespace app\controllers;

interface ServiceInterface
{

    public static function getIndicator($user);

    /**
     * Fonction abstraite php permettant de gérer l'affichage des menus à partir des contrôleurs.
     * 
     * @return Array All data about sub menu links. Used in LeftMenuBar widget.
     */
    public static  function getActionUser();
}
