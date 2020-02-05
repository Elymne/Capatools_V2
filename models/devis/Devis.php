<?php

namespace app\models\devis;

use yii\db\ActiveRecord;
use app\helper\UUID;

class Devis extends ActiveRecord
{

    /**
     * Récupère tous les devis.
     */
    public static function getAll()
    {
        return static::find();
    }


    public static function getOneById($id)
    {
        return static::find()->where(['id' => $id])->one();
    }


    public static function getOneByName($id_capa)
    {
        return static::find()->where(['id_capa' => $id_capa])->one();
    }



    public function getUnit() {
        return $this->hasOne(Unit::className(), ['id' => 'unit_id']);
    }

    public function getClient() {
        return $this->hasOne(Client::className(), ['id' => 'client_id']);
    }

    public function getProjectManager() {
        return $this->hasOne(ProjectManager::className(), ['id' => 'project_manager_id']);
    }

}
