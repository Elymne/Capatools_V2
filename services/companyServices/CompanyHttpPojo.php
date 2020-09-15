<?php

namespace app\services\companyServices;

/**
 * Classe pojo pour transformer les données récupéré depuis l'api https://entreprise.data.gouv.fr sous la forme d'objet manipulable en php.
 * @since v2.0.8
 */
class CompanyHttpPojo
{
    public $id, $name, $adresse, $code_postal, $siret, $tva;
    private const FR = "FR";

    /**
     * Pas grand chose d'intéressant, c'est juste un constructeur.
     * On calcule juste la TVA.
     */
    function __construct(array $responseData)
    {
        $this->id = $responseData['id'];
        $this->name = $responseData['l1_normalisee'];
        $this->address = $responseData['l4_declaree'];
        $this->postalCode = $responseData['code_postal'];
        $this->siret = $responseData['siret'];
        $this->tva = self::FR . (12 + 3 * ($responseData['siren'] % 97) + $responseData['siret']);
    }
}
