<?php

namespace app\services\htmlServices;

/**
 * Une petite classe pour créer des constantes qui retourne de petits éléments HTML.
 */
class HtmlHelperConst
{
    /**
     * Créer des espacements entre différents éléments.
     */
    public const SPACING = '&nbsp';
    public const SPACING_10X = '&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp';
    public const SPACING_20X = self::SPACING_10X . self::SPACING_10X;
    public const SPACING_30X = self::SPACING_20X . self::SPACING_10X;
}
