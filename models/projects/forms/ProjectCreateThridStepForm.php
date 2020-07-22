<?php

namespace app\models\projects\forms;


use app\models\Model;

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
class ProjectCreateThridStepForm extends Model
{

    /**
     * Gestion combobox lot.
     */
    public $laboratoryselected;

    public function rules()
    {
        return [
            ['laboratoryselected', 'safe']
        ];
    }
}
