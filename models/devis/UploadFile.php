<?php

namespace app\models\devis;

use yii\base\Model;

class UploadFile extends Model
{

    /**
     * @var file File attribute to upload.
     */
    public $file;

    function rules()
    {
        return [
            [['file'], 'file', 'skipOnEmpty' => true]
        ];
    }

    function upload()
    {
        if ($this->validate() && $this->file != null) {
            $this->file->saveAs('uploads/' . $this->file->baseName . '.' . $this->file->extension);
            return true;
        } else {
            return false;
        }
    }
}
