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
class LotSimulate extends Lot
{

    public $total_cost_human_with_margin;
    public $total_cost_invest_with_margin;
    public $total_cost_repayement_with_margin;
    public $total_cost_building_project = 500;
    public $total_cost_lot;
    public $mean_lot_margin;
    public $support_cost;
    public $total_cost_lot_with_support;

    public function getTotalCostHuman()
    {
        return "1000";
    }

    public function getTotalCostInvest()
    {
        return "2200";
    }

    public function getTotalCostRepayement()
    {
        return "5000";
    }
}
