<?php

namespace app\models\devis;

use yii\db\ActiveRecord;

class Milestone extends ActiveRecord
{

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

    /**
     * @return MilestoneStatus The actual milestone status.
     */
    public function getMilestoneStatus()
    {
        return $this->hasOne(MilestoneStatus::className(), ['id' => 'milestone_status_id']);
    }
}
