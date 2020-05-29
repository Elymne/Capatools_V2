<?php

namespace app\models\projects;

use yii\db\ActiveRecord;
use app\models\users\Cellule;
use app\models\users\CapaUser;
use app\models\companies\Company;

/**
 * Classe modèle métier des projets.
 * Permet de faire des requêtes depuis la table devis de la db associé à l'app.
 * Marche de la même manière qu'un ORM (voir la fonction getAll par l'exemple).
 * 
 * @version Capatools v2.0
 * @since Classe existante depuis la Release v2.0
 */
class Project extends ActiveRecord
{

    public static function tableName()
    {
        return 'project';
    }

    public static function getAll()
    {
        return static::find();
    }

    public static function getOneById($id)
    {
        return static::find()->where(['id' => $id])->one();
    }

    public static function getAllByCellule($idCellule)
    {
        return static::find()->where(['devis.cellule_id' => $idCellule]);
    }


    public function getCellule()
    {
        return $this->hasOne(Cellule::className(), ['id' => 'cellule_id']);
    }

    public function getCompany()
    {
        return $this->hasOne(Company::className(), ['id' => 'company_id']);
    }

    public function getProjectManager()
    {
        return $this->hasOne(CapaUser::className(), ['id' => 'capa_user_id']);
    }

    public function getLots()
    {
        return $this->hasMany(Lot::className(), ['project_id' => 'id']);
    }
}
