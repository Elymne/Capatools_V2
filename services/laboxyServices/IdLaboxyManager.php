<?php

namespace app\services\laboxyServices;

use app\models\projects\Project;
use app\models\users\Cellule;

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
    static function generateDraftId(string $internal_name)
    {
        $internalName = str_replace(' ', '_', $internal_name);
        $internalName = strtoupper($internalName);
        return "AVT-" . $internalName;
    }

    /**
     * Génération du laboxy-id.
     * @param Project $project
     * 
     * @return string, retourne un capa-id fraichement généré.
     */
    static function generateLaboxyDraftId(string $company_name, string $internal_name): string
    {
        $companyName = $company_name;
        $projectTitle = $internal_name;

        return "AVANT PROJET - " . $companyName . " - " . $projectTitle;
    }

    /**
     * Fonction qui permet de générer l'id laboxy une fois que la création de projet a été finalisé.
     * @param Project $project
     * 
     * @return string, un id laboxy généré.
     */
    static function generateLaboxyId(string $company_name, string $internal_name, int $project_id, Cellule $cellule): string
    {
        $celluleIdentity = $cellule->identity;
        $idNumber = static::generateNumberFromId($project_id);
        $companyName = $company_name;
        $projectTitle = $internal_name;

        return $celluleIdentity . $idNumber . " - " . $companyName . " - " . $projectTitle;
    }

    /**
     * Fonction un peu moche qui permet de générer le nombre "aléatoire" à partir de l'id d'un projet.
     * Le problème étant que ce nombre généré doit être composé de seulement 5 chiffre, il devient donc trop probable de se retrouver avec le même nombre pour deux projet.
     * Pour faire plus simplement, on va juste prendre le n° d'id du projet et le transformer en une chaîne de 5 chiffres avec des zéro pour remplacer les chiffres manquants du devis.
     * @param int $id
     * 
     * @return string, une chaîne de caractère représentant.
     */
    static public function generateNumberFromId(int $id): string
    {
        return $id <= 9 ? $id * 10000 : ($id <= 99 ? $id * 1000 : ($id <= 999 ? $id * 100 : ($id <= 9999 ? $id * 10 : $id)));
    }
}
