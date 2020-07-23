<?php

namespace app\models\projects\forms;

use app\models\projects\Task;

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
class ProjectCreateLotTaskForm extends Task
{
    public $risk_duration;

    /**
     * Fonction provenant de la classe ActiveRecord, elle permet de vérifier l'intégrité des données.
     */
    public function rules()
    {
        return [
            [['title', 'capa_user_id', 'risk', 'day_duration', 'hour_duration', 'price', 'number', 'risk_duration_hour'], 'safe',],
            ['title', 'required', 'message' => 'Il faut un titre de tâche'],
            ['capa_user_id', 'required', 'message' => 'Il faut indiquer l\'intervenant de la tâche'],
            ['risk', 'required', 'message' => 'Il faut renseigner l\'incertitude'],
            ['day_duration', 'required', 'message' => 'Il faut renseigner le nombre de jour'],
            ['hour_duration', 'required', 'message' => 'Il faut renseigner le nombre d\'heure'],
            ['risk', 'required', 'message' => 'Il faut renseigner l\'incertitude'],
        ];
    }
}
