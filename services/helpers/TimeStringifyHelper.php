<?php

namespace app\services\helpers;

/**
 * Classe fournissant des fonctions d'aide à la gestion des dates.
 * 
 * @version Capatools v2.0
 * @since Classe existante depuis la Release v2.0
 */
class TimeStringifyHelper
{

    public static function transformStringChainToHour(string $chain): int
    {
        preg_match_all('!\d+!', $chain, $matches);
        return $matches[0][0] * 7 + $matches[0][1];
    }
}
