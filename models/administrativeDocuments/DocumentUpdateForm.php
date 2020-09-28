<?php

namespace app\models\administrativeDocuments;

use app\models\administrativeDocuments\AdministrativeDocument;

/**
 * Classe relative au modèle métier des docuements.
 * Celle-ci permet de créer un formulaire de création d'un document et de vérifier la validité des données inscrites dans les champs.
 * 
 * Cette classe est a utiliser lorsque vous voulez créer une vue avec un formulaire depuis le contrôleur (contrôleur Administration ici).
 * 
 * @version Capatools v2.0
 * @since Classe existante depuis la Release v2.0
 */
class DocumentUpdateForm extends AdministrativeDocument
{

    public $File;
    public $file_name;
    /**
     * Fonction provenant de la classe ActiveRecord, elle permet de vérifier l'intégrité des données.
     */
    public function rules()
    {
        return [
            [['title', 'type', 'File', 'file_name', 'internal_link'], 'safe'],
            ['type', 'required', 'message' => 'Veulliez renseigner le type du document'],
            [['File'], 'file', 'skipOnEmpty' => true, 'maxSize' => 2000000,  'tooBig' => 'Le document est trop gros (2Mo maxi)}'],

        ];
    }
    /**
     * Fonction permettant d'upload le fichier.
     * 
     * @return bool, retourne vrai ou faux suivant si les étapes se sont bien passés.
     */
    public function upload(): bool
    {
        // On attribut le nom du fichier à l'arribut file_name qui sera stocké en bdd.
        if ($this->File) {
            $this->file_name =  $this->File[0]->name;

            $path = 'referencedoc';

            // Si le dossier n'existe pas, on le créer.
            if (!is_dir($path)) {
                mkdir($path);
            }

            // Si le fichier précédent existe, on le supprime.
            if ($this->internal_link != '' || $this->internal_link != NULL) {
                unlink($this->file_path);
            }

            $this->internal_link = $path . '/' . $this->file_name;
        }
        return $this->File[0]->saveAs($this->internal_link);
    }
}
