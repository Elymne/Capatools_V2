<?php

namespace app\services\companyServices;

class CompanyHttpPojo
{
    public $id, $name, $adresse, $code_postal, $siret, $tva;
    private const FR = "FR";

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
