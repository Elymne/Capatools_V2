<?php

namespace app\services\laboxyServices;

/**
 * Petite classe qui servira à tout ce qui est génération d'id laboxy.
 */
class IdLaboxyManager
{


    static function generateDraftId(string $internalName)
    {
        $internalName = str_replace(' ', '_', $internalName);
        $internalName = strtoupper($internalName);
        return "AVT-" . $internalName;
    }
}
