<?php

namespace app\controllers;

interface ServiceInterface
{
    /**
     * GetRight Application récupère les droits de l'application
     */
    public static  function GetRight();
    /**
     * GetIndicateur Application récupère les indicateurs du service en fonction de l'utilisateur
     */
    public static  function GetIndicateur($user);

    /**
     * GetActionUser Application récupère les actions possibles du service de l'utilisateur
     */
    public static  function GetActionUser($user);
}
