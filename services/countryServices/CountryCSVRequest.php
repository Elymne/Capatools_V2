<?php

namespace app\services\countryServices;

use Yii;

/**
 * Classe ne servant qu'à faire retourner une liste de tous les pays.
 * Je l'utilise pour vérifier la validité des données inscrites par les utilisateurs de capatools lorsqu'ils souhaitent rentrer une nouvelle société.
 * @since v2.0.8
 */
class CountryCSVRequest
{

    /**
     * Fonction que j'utilise pour retourner la liste de tous les noms des pays du monde.
     * Je m'en sers pour vérifier la validité des données inscrites par les utilisateurs de capatools lorsqu'ils ajoutent de nouvelles sociétés.
     * 
     * @return array - la liste de tous les pays du monde.
     */
    public static function getCountries(): array
    {
        return array_map(function ($elem) {
            return $elem[4];
        }, array_map('str_getcsv', file(Yii::getAlias('@app') . '/services/countryServices/countries.csv')));
    }
}
