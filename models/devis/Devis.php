<?php

namespace app\models\devis;

use yii\db\ActiveRecord;

use app\models\User\Cellule;
use app\models\User\Capaidentity;

class Devis extends ActiveRecord
{

    public static function tableName()
    {
        return 'Devis';
    }


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


    public function getCellule() {
        return $this->hasOne(Cellule::className(), ['id' => 'cellule_id']);
    }

    public function getCompany() {
        return $this->hasOne(Company::className(), ['id' => 'company_id']);
    }
    public function getStatut() {
        return $this->hasOne(Devisstatut::className(), ['id' => 'statut_id']);
    }

    public function getCapaidentity() {
        return $this->hasOne(Capaidentity::className(), ['id' => 'capaidentity_id']);
    }

}
