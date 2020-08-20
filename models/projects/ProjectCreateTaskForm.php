<?php

namespace app\models\projects;

use app\models\Model;
use app\models\projects\Project;

/**
 * Classe relative au modèle métier des devis.
 * Celle-ci permet de créer un formulaire de création de devis et de vérifier la validité des données inscrites dans les champs.
 * Elle permet aussi lorsque l'on veut créer un formulaire pour créer un devis, d'ajouter des champs qui n'existe pas dans la bdd.
 * ex : upfilename, pathfile, datept.
 * 
 * Cette classe est a utiliser lorsque vous voulez créer une vue avec un formulaire depuis le contrôleur (contrôleur Devis ici).
 * 
 * @version Capatools v2.0
 * @since Classe existante depuis la Release v2.0
 */
class ProjectCreateTaskForm extends Model
{

    public $project_id;
    public $number;
    public $valid;


    public function GetCurrentLot()
    {
        $project = Project::getOneById($this->project_id);
        $lot = $project->getLotByNumber($this->number);

        return $lot;
    }
}
