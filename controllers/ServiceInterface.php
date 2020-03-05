<?php

namespace app\controllers;

interface ServiceInterface
{

    /**
     * getIndicator Application récupère les indicateurs du service en fonction de l'utilisateur
     */
    public static  function getIndicator($user);

    /**
     * getActionUser Application récupère les actions possibles du service de l'utilisateur
     */
    public static  function getActionUser($user);
}
