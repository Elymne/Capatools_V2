<?php

namespace app\models\devis;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Classe modèle métier d'un fichier lié à un devis..
 * Permet de faire des requêtes depuis la table upload_file de la db associé à l'app.
 * Marche de la même manière qu'un ORM (voir la fonction getAll par l'exemple).
 * 
 * Cette table sert à sauvegarder les données informatives quant à un fichier stocké dans l'application (et non dans la bdd).
 * 
 * @version Capatools v2.0
 * @since Classe existante depuis la Release v2.0
 */
class UploadFile extends ActiveRecord
{

    /**
     * @var file File attribute to upload.
     */
    public $file;

    public function rules(): array
    {
        return [
            [['file'], 'file', 'skipOnEmpty' => true]
        ];
    }

    /**
     * Get all files in db.
     * 
     * @return ActiveQuery Result of query.
     */
    public static function getAll()
    {
        return static::find();
    }

    public static function getByDevis($devis_id)
    {
        return static::find()->where(['devis_id' => $devis_id])->One();
    }

    public static function getFileByIdCapa(string $idCapa)
    {
        return static::find()->where(['name' => $idCapa])->one();
    }

    public static function doesFileAlreadyExists($filename): bool
    {
        $result = true;
        $file = static::find()->where(['name' => $filename])->one();

        if ($file == null)
            $result =  false;

        return $result;
    }

    public function getFullFilename(): string
    {
        return $this->name . '.' . $this->type;
    }
}
