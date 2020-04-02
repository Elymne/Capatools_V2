<?php

namespace app\models\devis;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

class UploadFile extends ActiveRecord
{

    /**
     * @var file File attribute to upload.
     */
    public $file;

    public function rules(): array
    {
        return [
            [['file'], 'file', 'skipOnEmpty' => false]
        ];
    }

    /**
     * Get all files in db.
     * 
     * @return ActiveQuery Result of query.
     */
    public static function getAll(): ActiveQuery
    {
        return static::find();
    }

    public static function getAllByDevis($devis_id): ActiveQuery
    {
        return static::find()->where(['devis_id' => $devis_id]);
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
}
