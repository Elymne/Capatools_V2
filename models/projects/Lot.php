<?php

namespace app\models\projects;

use yii\db\ActiveRecord;

use Yii;

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

    public static function getAll()
    {
        return static::find();
    }

    public static function getOneById($id)
    {
        return static::find()->where(['id' => $id])->one();
    }

    public static function getOneByIdProjectAndNumber($idProject, $nb)
    {
        return static::find()->where(['project_id' => $idProject, 'number' => $nb])->one();
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

    public function getInvests()
    {
        return $this->hasMany(Investment::className(), ['lot_id' => 'id']);
    }


    public function getTotalCostHuman()
    {
        $result = 0;
        $taskslot = $this->tasks;
        foreach ($taskslot as $task) {
            preg_match_all('!\d+!', $task->risk_duration, $matches);
            $day = intval($matches[0][0]);
            $totalhour =  intval($matches[0][1]) + $day * Yii::$app->params['LaboxyTimeDay'];
            $pricehoraire = $task->price;
            $result  = $result + ($pricehoraire * $totalhour);
        }

        return $result;
    }


    public function getTotalCostInvest()
    {
        $result = 0.0;
        $consumables = $this->consumables;
        foreach ($consumables as $consumable) {
            $result  = $result + $consumable->price;
        }


        $Invests = $this->invests;
        foreach ($Invests as $Invest) {
            $result  = $result + $Invest->price;
        }


        return $result;
    }


    public function getTotalCostRepayement()
    {
        return "5000";
    }
}
