<?php

namespace app\models\projects;

use app\models\equipments\Equipment;
use app\models\equipments\EquipmentRepayment;
use app\models\laboratories\LaboratoryContributor;
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

    public static function duplicateToProject(Lot $lot, $idproject)
    {

        $newlot = new Lot();
        $newlot->title = $lot->title;
        $newlot->number = $lot->number;
        $newlot->status = $lot->status;
        $newlot->comment = $lot->comment;
        $newlot->rate_human_margin = $lot->rate_human_margin;
        $newlot->rate_repayement_margin = $lot->rate_repayement_margin;
        $newlot->rate_consumable_investement_margin = $lot->rate_consumable_investement_margin;
        $newlot->project_id = $idproject;
        $newlot->laboratory_id = $lot->laboratory_id;

        $newlot->save();

        foreach ($lot->tasks as $task) {
            Task::duplicateToLot($task, $newlot->id);
        }

        foreach ($lot->consumables as $consumable) {
            Consumable::duplicateToLot($consumable, $newlot->id);
        }
        foreach ($lot->invests as $invest) {
            Investment::duplicateToLot($invest, $newlot->id);
        }

        foreach ($lot->labotorycontributors as $labotorycontributor) {
            LaboratoryContributor::duplicateToLot($labotorycontributor, $newlot->id);
        }

        foreach ($lot->equipmentrepayments as $equipmentrepayment) {
            EquipmentRepayment::duplicateToLot($equipmentrepayment, $newlot->id);
        }
    }

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

    public static function getAllByIdProject($idProject)
    {
        return static::find()->where(['project_id' => $idProject])->all();
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

    public function getLabotorycontributors()
    {
        return $this->hasMany(LaboratoryContributor::className(), ['lot_id' => 'id']);
    }

    public function getEquipmentrepayments()
    {
        return $this->hasMany(EquipmentRepayment::className(), ['lot_id' => 'id']);
    }


    public function getTotalCostHuman()
    {
        $result = 0;
        $taskslot = $this->tasks;
        foreach ($taskslot as $task) {
            $result  = $result + $task->totalprice;
        }

        return $result;
    }


    public function getTotalCostHumanWithMargin()
    {
        $result = 0;
        $taskslot = $this->tasks;
        foreach ($taskslot as $task) {
            $result  = $result + $task->totalprice;
        }
        return $result * (1 + $this->rate_human_margin / 100);
    }


    public function getTotalTimeWithRisk()
    {
        $result = 0;
        $taskslot = $this->tasks;
        foreach ($taskslot as $task) {
            $result  = $result +   $task->risk_duration_day;
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
        $result =  0.000;
        $Equipementrepayements = $this->equipmentrepayments;
        foreach ($Equipementrepayements as $Equipementrepayement) {
            $result  = $result + $Equipementrepayement->price;
        }

        $LabotoryContributors = $this->labotorycontributors;
        foreach ($LabotoryContributors as $LabotoryContributor) {
            $result  = $result + $LabotoryContributor->price;
        }


        return $result;
    }

    public function getTotal()
    {
        $result = 0.000;
        $result =  $this->totalcosthuman
            + $this->totalcostinvest
            + $this->totalcostrepayement;
        return round($result, 2);
    }

    public function getTotalWithMargin()
    {
        $result = 0.000;
        $result =  $this->totalcosthuman * (1 + $this->rate_human_margin / 100)
            + $this->totalcostinvest * (1 + $this->rate_consumable_investement_margin / 100)
            + $this->totalcostrepayement * (1 + $this->rate_repayement_margin / 100);
        return round($result, -2);
    }
}
