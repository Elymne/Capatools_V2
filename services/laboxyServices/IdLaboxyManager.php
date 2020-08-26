<?php

namespace app\services\laboxyServices;

use app\models\projects\Project;

/**
 * Petite classe qui servira à tout ce qui est génération d'id laboxy.
 */
class IdLaboxyManager
{

    /**
     * Génération du capa-id.
     * @param Project $project
     * 
     * @return string, retourne un capa-id fraichement généré.
     */
    static function generateDraftId(Project $project)
    {
        $internalName = str_replace(' ', '_', $project->internal_name);
        $internalName = strtoupper($internalName);
        return "AVT-" . $internalName;
    }

    /**
     * Génération du laboxy-id.
     * @param Project $project
     * 
     * @return string, retourne un capa-id fraichement généré.
     */
    static function generateLaboxyDraftId(Project $project): string
    {
        $companyName = $project->company_name;
        $projectTitle = $project->internal_name;

        return "AVANT PROJET - " . $companyName . " - " . $projectTitle;
    }
}
