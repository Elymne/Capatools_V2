<?php

namespace app\services\countryServices;

use Yii;

/**
 * Classe ne servant qu'à faire retourner une liste de tous les pays.
 * @since v2.0.8
 */
class CountryCSVRequest
{

    public static function getCountries(): array
    {
        return array_map(function ($elem) {
            return $elem[4];
        }, array_map('str_getcsv', file(Yii::getAlias('@app') . '/services/countryServices/countries.csv')));
    }
}
