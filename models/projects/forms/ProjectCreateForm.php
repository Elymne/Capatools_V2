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

    /**
     * @var string $upfilename,
     * @var string $projectManagerSelectedValue,
     */
    public $pdfFile;
    public $projectManagerSelectedValue;

    /**
     * Fonction provenant de la classe ActiveRecord, elle permet de vérifier l'intégrité des données.
     */
    public function rules()
    {
        return [
            [['signing_probability', 'capa_user_id', 'thematique', 'file_path', 'pdfFile', 'projectManagerSelectedValue'], 'safe'],

            ['internal_name', 'required', 'message' => 'Un nom de projet est obligatoire.'],
            ['thematique', 'required', 'message' => 'Indiquer la thématique du projet.'],
            ['capa_user_id', 'required', 'message' => 'Indiquer le chef de projet'],
            ['signing_probability', 'required', 'message' => 'Indiquez la probabilité de signature !.'],
            [['pdfFile'], 'file', 'skipOnEmpty' => true, 'maxSize' => 2000000, 'extensions' => 'pdf', 'tooBig' => 'Le document est trop gros (2Mo maxi)}', 'message' => 'Une proposition technique doit être associée au devis.'],
        ];
    }


    /**
     * Fonction permettant d'upload le fichier.
     * 
     * @return bool, retourne vrai ou faux suivant si les étapes se sont bien passés.
     */
    public function upload(): bool
    {
        if ($this->pdfFile) {
            // On attribut le nom du fichier à l'arribut file_name qui sera stocké en bdd.
            $this->file_name =  $this->pdfFile[0]->name;

            $path = 'uploads/' . $this->id_capa;

            // Si le dossier n'existe pas, on le créer.
            if (!is_dir($path))
                mkdir($path);

            // Si le dossier existe déjà (donc qu'il y a déjà un fichier existant), on le supprime.
            if ($this->file_path != '')
                unlink($this->file_path);

            $this->file_path = $path . '/' . $this->file_name;
            return $this->pdfFile[0]->saveAs($this->file_path);
        }
        return false;
    }
}
