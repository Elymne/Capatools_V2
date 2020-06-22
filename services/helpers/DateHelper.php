<?php

namespace app\services\helpers;

/**
 * Classe fournissant des fonctions d'aide à la gestion des dates.
 * 
 * @version Capatools v2.0
 * @since Classe existante depuis la Release v2.0
 */
class DateHelper
{

    /**
     * Utilisé pour formater la date rentré en paramètre sous le format suivant : Année/Mois/Jour.
     * @param string $date (il n'existe pas de type Date à proprement parler).
     * 
     * @return Date : la date transfomée.
     */
    public static function formatDateTo_Ymd(string $date)
    {
        return date("Y/m/d", strtotime($date));
    }

    /**
     * Utilisé pour formater la date rentré en paramètre sous le format suivant : Jour/Mois/Année.
     * @param string $date (il n'existe pas de type Date à proprement parler).
     * 
     * @return Date : la date transfomée.
     */
    public static function formatDateTo_dmY($date)
    {
        return date("d-m-Y", strtotime($date));
    }
}
