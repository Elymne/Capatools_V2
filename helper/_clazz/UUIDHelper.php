<?php

namespace app\helper\_clazz;

/**
 * Classe utilisé pour générer des UUID car php et sql ne le font pas nativement.
 * 
 * @version Capatools v2.0
 * @since Classe existante depuis la Release v2.0
 */
class UUID
{

    public static function BIN_TO_UUID($binary)
    {
        $string = unpack("h*", $binary);
        return preg_replace("/([0-9a-f]{8})([0-9a-f]{4})([0-9a-f]{4})([0-9a-f]{4})([0-9a-f]{12})/", "$1-$2-$3-$4-$5", $string);
    }

    public static function UUID_TO_BIN($uuid)
    {
        return pack("h*", str_replace('-', '', $uuid));
    }
}
