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

    /**
     * Save the file stocked in $file attribute.
     * Save the file in app/web/uploads
     * 
     * @return bool Result if you wish to manage errors.
     */
    public function upload(int $id): bool
    {
        $result = true;

        if (!self::doesFileAlreadyExists()) {
            if (self::uploadFile()) {
                $this->devis_id = $id;
                $this->name = $this->file->baseName;
                $this->save();
            } else {
                $result = false;
            }
        } else {
            $result = false;
        }

        return $result;
    }

    /**
     * Return true if file already exists, else false.
     * 
     * @return bool
     */
    private function doesFileAlreadyExists(): bool
    {
        $result = true;
        $file = $this->find()->where(['name' => $this->file->baseName])->one();

        if ($file == null)
            $result =  false;

        return $result;
    }

    private function uploadFile(): bool
    {

        $result = true;

        if ($this->validate() && $this->file != null) {
            $this->file->saveAs('uploads/' . $this->file->baseName . '.' . $this->file->extension);
        } else {
            $result = false;
        }

        return $result;
    }
}
