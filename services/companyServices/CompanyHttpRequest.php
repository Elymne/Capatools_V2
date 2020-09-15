<?php

namespace app\services\companyServices;

/**
 * Classe ne servant qu'à faire des requêtes http vers une api qui renvoi des données sur les entreprises.
 * J'utilise cette classe pour les vérifications de données lors de la création d'une entreprise.
 * @link https://entreprise.data.gouv.fr
 * @since v2.0.8
 * 
 */
class CompanyHttpRequest
{

    // Base url de l'api pour requêter.
    const HTTP_API_COMPANY_FETCH = 'https://entreprise.data.gouv.fr/api/sirene/v1/full_text/';

    /**
     * Fonction que j'utilise pour faire ma requête sur l'api entreprise.data.gouv, et récupérer la liste des entreprise sous format json que je transforme en tableau.
     * J'utilise ensuite une fonction de factory pour construire un objet à partir de la liste.
     * En d'autres terme, pour faire simple, cette fonction permet de récupérer diverses informations sur une entreprise de France dont vous aurez aupréalable renseigné le nom.
     * @param string $companyName - Nom de l'entreprise.
     * 
     * @return CompanyHttpPojo|null - Retourne un objet CompanyHttpPojo ou null.
     */
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

    /**
     * Fonction que j'utilise comme une factory pour créer et retourner mon objet entreprise.
     * Pour aller un peu plus loin : je n'ai pas trouvé le moyen sur l'api de faire une sélection précise d'une entreprise avec son nom, 
     * il récupère toujours des entreprises proches du champ rentrée (chiant) donc je suis obligé de faire une petite manip pour récupérer précisément l'entreprise 
     * (ou rien si elle n'existe pas).
     * @param array $httpResponse - La réponse d'une requête http (GET) sur l'api gouv sous la forme d'un tableau (et non d'un json attention).
     * @param string $companyName - Le nom de l'entreprise que l'on cherche.
     * 
     * @return CompanyHttpPojo|null - Retourne un objet CompanyHttpPojo ou null.
     */
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
