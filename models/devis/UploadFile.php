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
            [['file'], 'file', 'skipOnEmpty' => true]
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

    /**
     * Save the file stocked in $file attribute.
     * Save the file in app/web/uploads
     * 
     * @return bool Result.
     */
    public function upload(): bool
    {
        if ($this->validate() && $this->file != null) {
            $this->file->saveAs('uploads/' . $this->file->baseName . '.' . $this->file->extension);
            return true;
        } else {
            return false;
        }
    }
}
