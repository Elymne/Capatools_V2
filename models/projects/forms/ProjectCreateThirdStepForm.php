<?php

namespace app\models\projects\forms;

use app\models\laboratories\Laboratory;
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
class ProjectCreateThirdStepForm extends Model
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

    /**
     * Permet de définir l'index de la liste déroulante des laboratoire pour ce formulaire depuis l'ID du laboratoire envoyé.
     * cf voir l'entité laboratoryselected.
     */
    public function setLaboratorySelectedFromLaboID($id)
    {
        // Valeur par défaut.
        $this->laboratoryselected = 0;
        $laboArray = Laboratory::getAll();

        foreach ($laboArray as $key => $labo) {
            // Si c'est le bon labo, on associe alors la bonne clé. On ajoute 1 car sur le liste selectionable, la valeur n°1 est égale à 1 et non à 0 comme pour un tableau.
            if ($labo->id == $id) $this->laboratoryselected = $key + 1;
        }
    }
}
