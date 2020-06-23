<?php

namespace app\models\projects;

use app\models\users\CapaUser;
use yii\db\ActiveRecord;

/**
 * Classe modèle métier des tâches.
 * Permet de faire des requêtes depuis la table devis de la db associé à l'app.
 * Marche de la même manière qu'un ORM (voir la fonction getAll par l'exemple).
 * 
 * @version Capatools v2.0
 * @since Classe existante depuis la Release v2.0
 */
class Task extends ActiveRecord
{

    const RISK_LOW = 'Faible';
    const RISK_NORMAL = 'Normal';
    const RISK_HIGH = "Haut";
    const RISKS = [self::RISK_LOW, self::RISK_NORMAL, self::RISK_HIGH];

    public static function tableName()
    {
        return 'task';
    }

    public static function getAll()
    {
        return static::find();
    }

    public static function getOneById($id)
    {
        return static::find()->where(['id' => $id])->one();
    }

    public function getLot()
    {
        return $this->hasOne(Lot::className(), ['id' => 'lot_id']);
    }

    public function getContributor()
    {
        return $this->hasOne(CapaUser::className(), ['id' => 'capa_user_id']);
    }
}
