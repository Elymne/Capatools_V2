<?php

namespace app\models\projects\forms;

use app\models\companies\Company;
use app\models\companies\Contact;
use app\models\projects\Project;
use yii\helpers\ArrayHelper;

use yii\web\UploadedFile;

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
class ProjectCreateForm extends Project
{

    public $upfilename;
    public $pathfile;
    public $datept;
    public $thematique;
    public $responsable;
    /**
     * Fonction provenant de la classe ActiveRecord, elle permet de vérifier l'intégrité des données.
     */
    public function rules()
    {
        return [
            [['signing_probability', 'capa_user_id', 'thematique'], 'safe'],

            ['internal_name', 'required', 'message' => 'Un nom de projet est obligatoire.'],
            ['thematique', 'required', 'message' => 'Indiquer la thématique du projet.'],
            ['capa_user_id', 'required', 'message' => 'Indiquer le chef de projet'],
            ['signing_probability', 'required', 'message' => 'Indiquez la probabilité de signature !.'],
            [['upfilename'], 'file', 'skipOnEmpty' => true, 'maxSize' => 2000000, 'extensions' => 'pdf', 'tooBig' => 'Le document est trop gros (2Mo maxi)}', 'message' => 'Une proposition technique doit être associée au devis.'],
        ];
    }


    //chage le fichier
    public function upload()
    {
        if ($this->upfilename) {

            //J Save the file into upload path.
            $path = 'uploads/' . $this->id_capa;
            if (is_dir($path)) {
                rmdir($path);
            }
            mkdir($path);
            $this->file_path = $path . '/' . $this->upfilename[0]->name;
            $result = true;
            if ($result) {

                ($this->upfilename[0])->saveAs($this->file_path);
            }
            return true;
        }
    }
}
