<?php

namespace app\models\devis;

use yii\db\ActiveRecord;

class Milestone extends ActiveRecord
{
    public $delivery_date_view;

    public function rules()
    {
        return [
            [['delivery_date_view','label','price','comments','milestone_statut_id','devis_id'], 'safe'],
            ['price', 'required', 'message' => 'Indiquer le prix du jalon.'],
            ['price', 'double', 'min' => 1, 'tooSmall' => 'Le prix du jalon doit être supérieur à 0.', 'message' => 'Le prix du jalon doit être positif.'],
            ['label', 'required', 'message' => 'Un nom de jalon est obligatoire'],
            ['delivery_date_view', 'required', 'message' => 'une date de jalon doit être estimée'],

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

    public function formatDateToSql()
    {
    
        $this->delivery_date = date("Y-m-d", strtotime($this->delivery_date_view));
      
    }
    public function formatDateFromSql()
    {
        $this->delivery_date_view = date("d-m-Y", strtotime($this->delivery_date)); 
    }
}
