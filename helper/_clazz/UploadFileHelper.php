<?php

namespace app\helper\_clazz;

use app\models\devis\UploadFile;
use Yii;

class UploadFileHelper
{

    /**
     * Save the file stocked in $file attribute.
     * Save the file in app/web/uploads.
     * Save the data file in db.
     * 
     * @return bool Result if you wish to manage errors.
     */
    public static function upload(UploadFile $fileModel, string $filename, int $devis_id): bool
    {
        $result = true;
        $fileModelCheck = UploadFile::getFileByIdCapa($filename);

        if ($fileModelCheck == null) {
            // If file does not exists, we add it to database and set version to 1.
            if (self::uploadFile($filename, $fileModel)) {
                $fileModel->devis_id = $devis_id;
                $fileModel->name = $filename;
                $fileModel->type = $fileModel->file->extension;
                $fileModel->version = 1;
                $fileModel->save();
            } else {
                $result = false;
            }
        } else {
            // =If it exists, we just update extension file and versionning.
            if (self::uploadFile($filename, $fileModel)) {
                $fileModelCheck->delete();
                $fileModel->devis_id = $devis_id;
                $fileModel->name = $filename;
                $fileModel->type = $fileModel->file->extension;
                $fileModel->version += $fileModel->version;
                $fileModel->save();
            } else {
                $result = false;
            }
        }

        return $result;
    }

    private function uploadFile(string $capaId, UploadFile $uploadFile): bool
    {
        $result = true;

        if ($uploadFile->validate() && $uploadFile->file != null) {
            $uploadFile->file->saveAs('uploads/' . $capaId . '.' . $uploadFile->file->extension);
        } else {
            $result = false;
        }

        return $result;
    }

    public static function downloadFile(string $file)
    {
        $path = Yii::getAlias('@webroot') . '/uploads/' . $file;

        if (file_exists($path)) {
            return Yii::$app->response->sendFile($path, $file);
        }
    }
}
