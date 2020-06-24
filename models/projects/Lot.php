<?php

namespace app\models\projects;

use yii\db\ActiveRecord;

/**
 * Classe modèle métier des lots.
 * Permet de faire des requêtes depuis la table devis de la db associé à l'app.
 * Marche de la même manière qu'un ORM (voir la fonction getAll par l'exemple).
 * 
 * @version Capatools v2.0
 * @since Classe existante depuis la Release v2.0
 */
class Lot extends ActiveRecord
{

    const STATE_IN_PROGRESS = 'En cours';

    public static function tableName()
    {
        return 'lot';
    }

    /**
     * Fonction provenant de la classe ActiveRecord, elle permet de vérifier l'intégrité des données.
     */
    public function rules()
    {
        return [
            [['title'], 'safe',],
        ];
    }

    public static function getAll()
    {
        return static::find();
    }

    public static function getOneById($id)
    {
        return static::find()->where(['id' => $id])->one();
    }

    public function getProject()
    {
        return $this->hasOne(Project::className(), ['id' => 'project_id']);
    }

    public function getTasks()
    {
        return $this->hasMany(Task::className(), ['lot_id' => 'id']);
    }

    public function getConsumables()
    {
        return $this->hasMany(Consumable::className(), ['lot_id' => 'id']);
    }
}
