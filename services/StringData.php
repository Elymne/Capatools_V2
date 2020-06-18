<?php

namespace app\services;

use MyCLabs\Enum\Enum;

/**
 * Enum that is used to manage user roles.
 */
class StringData extends Enum
{

    const DEVIS_PAYMENT_DETAILS = "30% à la commande, 70% à la livraison des résultats";
    const DEVIS_PAYMENT_CONDITIONS = "30% à la signature de ce devis, 70% à la livraison de la prestation";
}
