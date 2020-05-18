<?php

namespace app\models\devis;

use yii\db\ActiveRecord;

/**
 * Classe modèle métier des jalons d'un devis..
 * Permet de faire des requêtes depuis la table milestone de la db associé à l'app.
 * Marche de la même manière qu'un ORM (voir la fonction getAll par l'exemple).
 * 
 * @version Capatools v2.0
 * @since Classe existante depuis la Release v2.0
 */
class Milestone extends ActiveRecord
{

    /**
     * Fonction provenant de la classe ActiveRecord, elle permet de vérifier l'intégrité des données.
     */
    public function rules()
    {
        return [
            [['delivery_date', 'label', 'price', 'comments', 'milestone_statut_id', 'devis_id'], 'safe'],
            ['price', 'required', 'message' => 'Indiquer le prix du jalon.'],
            ['price', 'double', 'min' => 1, 'tooSmall' => 'Le prix du jalon doit être supérieur à 0.', 'message' => 'Le prix du jalon doit être positif.'],
            ['label', 'required', 'message' => 'Un nom de jalon est obligatoire'],
            // waiting for input.
            //['delivery_date', 'required', 'message' => 'une date de jalon doit être estimée'],

        ];
    }

    public static function tableName()
    {
        return 'milestone';
    }

    public static function getAll()
    {
        return static::find();
    }

    public static function getOneById($id)
    {
        return static::find()->where(['id' => $id])->one();
    }

    public static function setStatusById($id, $status)
    {
        $milestone = static::find()->where(['id' => $id])->one();
        $milestone->milestone_status_id = $status;
        $milestone->save();
    }


    // Milestone Status Constraint.
    public function getMilestoneStatus()
    {
        return $this->hasOne(MilestoneStatus::className(), ['id' => 'milestone_status_id']);
    }
}
