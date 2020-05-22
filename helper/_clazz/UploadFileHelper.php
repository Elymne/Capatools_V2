<?php

namespace app\helper\_clazz;

use app\models\devis\UploadFile;
use Yii;

/**
 * Classe utilisé pour gérer la gestion du download des fichiers pour un devis principalement.
 * Se base sur le modèle métier UploadFile.
 * 
 * @version Capatools v2.0
 * @since Classe existante depuis la Release v2.0
 */
class UploadFileHelper
{

    /**
     * Cette fonction est utilisé pour plusieurs choses :
     * - Stocker le fichier tel qu'est dans un dossier (web/uploads).
     * - Ajouter dans la base de données l'information qu'un fichier est associé à un devis.
     * 
     * @param FileModel $fileModel.
     * @param string $filename.
     * @param int $devis_id.
     * 
     * @return bool Retourne vrai si le download s'est correctement passé.
     */
    public static function upload(UploadFile $fileModel, string $filename, int $devis_id): bool
    {
        $result = true;
        $fileModelCheck = UploadFile::getFileByIdCapa($filename);

        if ($fileModelCheck == null) {
            // If file does not exists, we add it to database and set version to 1.
            if (self::saveFile($filename, $fileModel)) {
                $fileModel->devis_id = $devis_id;
                $fileModel->name = $filename;
                $fileModel->type = $fileModel->file->extension;
                $fileModel->version = 1;
                $fileModel->save();
            } else {
                $result = false;
            }
        } else {
            // If it exists, we just update extension file and versioning.
            if (self::saveFile($filename, $fileModel)) {
                $version = $fileModelCheck->version + 1;

                //$fileModelCheck->delete();
                $fileModelCheck->devis_id = $devis_id;
                $fileModelCheck->name = $filename;
                $fileModelCheck->type = $fileModel->file->extension;
                $fileModelCheck->version = $version;
                $fileModelCheck->save();
            } else {
                $result = false;
            }
        }

        return $result;
    }

    /**
     * Fonction qui s'occupe uniquement de sauvegarder le fichier dans web/uploads.
     * Cette fonction existe car on suit le principe KISS.
     * 
     * @param string $capaId.
     * @param UploadFile $uploadFile.
     * 
     * @return bool Retourne vrai si le download s'est correctement passé.
     */
    private static function saveFile(string $capaId, UploadFile $uploadFile): bool
    {
        $result = true;

        if ($uploadFile->validate() && $uploadFile->file != null) {
            $uploadFile->file->saveAs('uploads/' . $capaId . '.' . $uploadFile->file->extension);
        } else {
            $result = false;
        }

        return $result;
    }

    /**
     * Utilisé pour simplement récupérer le fichier stocké dans web/uploads à partir du nom de celui-ci.
     * 
     * @param string $file.
     * @return Yii2_Object Un objet Yii2 qui permet de télécharger un fichier.
     */
    public static function downloadFile(string $file)
    {
        $path = Yii::getAlias('@webroot') . '/uploads/' . $file;

        if (file_exists($path)) {
            return Yii::$app->response->sendFile($path, $file);
        }
    }
}
