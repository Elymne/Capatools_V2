<?php

namespace app\models\projects;

use phpDocumentor\Reflection\Types\Null_;

/**
 * Classe relative au modèle métier des Lots.
 * Celle-ci permet de créer un formulaire de création de lots et de vérifier la validité des données inscrites dans les champs.
 * Elle permet aussi lorsque l'on veut créer un formulaire pour créer un lot, d'ajouter des champs qui n'existe pas dans la bdd.
 * ex : upfilename, pathfile, datept.
 * 
 * Cette classe est a utiliser lorsque vous voulez créer une vue avec un formulaire depuis le contrôleur (contrôleur Project ici).
 * 
 * @version Capatools v2.0
 * @since Classe existante depuis la Release v2.0
 */
class TaskLotCreateTaskForm extends Task
{


    /**
     * Fonction provenant de la classe ActiveRecord, elle permet de vérifier l'intégrité des données.
     */
    public function rules()
    {
        return [
            ['title', 'required', 'message' => 'Il faut un de tâche'],
            ['capa_user_id', 'required', 'message' => 'Il faut indiquer l\'intervenant de la tâche'],
            ['duration', 'required', 'message' => 'Il faut un temps pour la tâche.'],
            ['kind_duration', 'required', 'message' => 'Il faut indiquer l\'unité de temps'],
            ['risk', 'required', 'message' => 'Il faut renseigner l\'incertitude'],
        ];
    }
}
