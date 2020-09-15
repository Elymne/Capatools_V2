<?php

namespace app\services\companyServices;

/**
 * Classe ne servant qu'à faire des requêtes http vers une api qui renvoi des données sur les entreprises.
 * @since v2.0.8
 */
class CompanyHttpRequest
{

    // Base url.
    const HTTP_API_COMPANY_FETCH = 'https://entreprise.data.gouv.fr/api/sirene/v1/full_text/';

    public static function getUniqueCompanyFromName(string $companyName): ?CompanyHttpPojo
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => self::HTTP_API_COMPANY_FETCH . $companyName,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache"
            ),
        ));

        $response = json_decode(curl_exec($curl), true);
        curl_close($curl);

        // Si la clé "message" existe dans la réponse, c'est qu'elle ne contient aucune donnée, on retourne donc null.
        if (array_key_exists("message", $response)) {
            return null;
        }

        return self::buildCompanyObject($response, $companyName);
    }

    private static function buildCompanyObject(array $httpResponse, string $companyName): ?CompanyHttpPojo
    {
        foreach ($httpResponse['etablissement'] as $companiesDataArray) {
            if (strtolower($companiesDataArray['l1_normalisee']) == strtolower($companyName)) {
                return new CompanyHttpPojo($companiesDataArray);
            }
        }

        return null;
    }
}
