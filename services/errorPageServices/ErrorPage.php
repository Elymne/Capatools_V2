<?php

namespace app\services\errorPageServices;

/**
 * Classe utilisé pur stocker des données à affciher pour une page d'erreur.
 */
class ErrorPage
{

    public $errorName;
    public $errorDescription;

    function __construct(string $errorName, string $errorDescription)
    {
        $this->errorName = $errorName;
        $this->errorDescription = $errorDescription;
    }
}
