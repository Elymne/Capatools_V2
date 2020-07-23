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

    const KINDDURATION_DAY = 'Jour(s)';
    const KINDDURATION_HOUR = 'Heure(s)';
    const KINDDURATION = [self::KINDDURATION_DAY => self::KINDDURATION_DAY, self::KINDDURATION_HOUR => self::KINDDURATION_HOUR];

    const CATEGORY_TASK = 'Tâche';
    const CATEGORY_MANAGEMENT = 'Management';
    const CATEGORIES = [self::CATEGORY_TASK, self::CATEGORY_MANAGEMENT];

    const RISK_LOW = 'Faible';
    const RISK_NORMAL = 'Normale';
    const RISK_HIGH = "Très haut";
    const RISKS = [self::RISK_LOW => self::RISK_LOW, self::RISK_NORMAL => self::RISK_NORMAL, self::RISK_HIGH => self::RISK_HIGH];

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

    public static function getTypeTaskByLotId($id, $kind)
    {
        return static::find()->where(['lot_id' => $id, 'task_category' => $kind])->all();
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
