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

    /**
     * Fonction provenant de la classe ActiveRecord, elle permet de vérifier l'intégrité des données.
     */
    public function rules()
    {
        return [

            ['rate_consumable_investement_margin', 'required', 'message' => 'Il faut une marge d\'investissement'],
            ['rate_human_margin', 'required', 'message' => 'Il faut une marge sur le temps humain'],
            ['rate_repayement_margin', 'required', 'message' => 'Il faut une marge sur le reversement laboratoire'],

        ];
    }
    public $total_cost_human_with_margin;
    public $total_cost_invest_with_margin;
    public $total_cost_repayement_with_margin;
    public $total_cost_building_project = 500;
    public $total_cost_lot;
    public $average_lot_margin;
    public $support_cost;
    public $total_cost_lot_with_support;
    public $ButtonRateHumamMarginup;
    public $ButtonRateHumamMargindown;
    public $ButtonInvestMarginup;
    public $ButtonInvestMargindown;
    public $ButtonRepayementMarginup;
    public $ButtonRepayementMargindown;
}
