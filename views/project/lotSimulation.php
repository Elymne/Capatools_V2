<?php

use app\assets\AppAsset;
use app\models\projects\Project;
use app\widgets\TopTitle;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\bootstrap\Html;
use yii\widgets\ActiveForm;

$this->title = 'Simulation de lot';

AppAsset::register($this);
?>

<?= TopTitle::widget(['title' => $this->title]) ?>
<div class="container">
    <div class="project-create">
        <?php $form = ActiveForm::begin(['id' => 'dynamic-form', 'options' => ['enctype' => 'multipart/form-data']]); ?>
        <div class="row">
            <div class="col s10 offset-s1">

                <!-- Card view basique -->
                <div class="card">

                    <div class="card-content">
                        <label>Détail des coûts du lot (avec les coûts d'avant projet)</label>
                    </div>

                    <div class="card-action">
                        <div class="row">
                            <div class="col s3">
                                Total coût temps homme (€):
                            </div>
                            <div class="col s1">
                                <?= $form->field($lot, "totalCostHuman")->textInput(['autocomplete' => 'off', 'maxlength' => true, 'readonly' => true])->label(false) ?>

                            </div>


                        </div>
                        <div class="row">
                            <div class="col s3">
                                Total des dépenses et investissement (€):
                            </div>
                            <div class="col s1">
                                <?= $form->field($lot, "totalCostInvest")->textInput(['autocomplete' => 'off', 'maxlength' => true, 'readonly' => true])->label(false) ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col s3">
                                Total des reversements laboratoires (€):
                            </div>
                            <div class="col s1">
                                <?= $form->field($lot, "totalCostRepayement")->textInput(['autocomplete' => 'off', 'maxlength' => true, 'readonly' => true])->label(false) ?>
                            </div>
                        </div>

                    </div>
                </div>
                <!-- Card view basique -->
                <div class="card">

                    <div class="card-content">
                        <label>Marges</label>
                    </div>

                    <div class="card-action">

                        <label class='blue-text control-label typeLabel'>Marge Temps homme</label>
                        <div class="row">
                            <div class="col s4">
                                <!-- Détail du coût  -->
                                Taux de marge temps homme (%):
                            </div>
                            <div class="col s1">
                                <!-- Détail du coût  -->
                                <?= $form->field($lot, "rate_humain_margin")->textInput(['autocomplete' => 'off', 'maxlength' => true, 'readonly' => true])->label(false) ?>
                            </div>
                            <div class="col s4">
                                <?= Html::button("+", ['title' => "Topic", 'onclick' => 'console.log(\'toto\');', 'class' => 'waves-effect waves-light btn btn']) ?>
                                <?= Html::button("-", ['title' => "Topic", 'onclick' => 'console.log(\'toto\');', 'class' => 'waves-effect waves-light btn btn-red']) ?>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col s4">
                                <!-- Détail du coût  -->
                                Total Prix de revient H.T. temps homme (€):
                            </div>
                            <div class="col s1">
                                <!-- Détail du coût  -->
                                <?= $form->field($lot, "total_cost_human_with_margin")->textInput(['autocomplete' => 'off', 'maxlength' => true, 'readonly' => true])->label(false) ?>
                            </div>
                        </div>

                        <label class='blue-text control-label typeLabel'>Marge consommables, déplacements et achat</label>

                        <div class="row">
                            <div class="col s4">
                                Taux de marge consommables, déplacements et achat (%):

                            </div>
                            <div class="col s1">
                                <!-- Détail du coût  -->
                                <?= $form->field($lot, "rate_consumable_investement_margin")->textInput(['autocomplete' => 'off', 'maxlength' => true, 'readonly' => true])->label(false) ?>
                            </div>
                            <div class="col s4">
                                <?= Html::button("+", ['title' => "Topic", 'onclick' => 'console.log(\'toto\');', 'class' => 'waves-effect waves-light btn btn']) ?>
                                <?= Html::button("-", ['title' => "Topic", 'onclick' => 'console.log(\'toto\');', 'class' => 'waves-effect waves-light btn btn-red']) ?>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col s4">
                                <!-- Détail du coût  -->
                                Total Prix de revient H.T. consommables, déplacements et achat (€):
                            </div>
                            <div class="col s1">
                                <!-- Détail du coût  -->
                                <?= $form->field($lot, "total_cost_invest_with_margin")->textInput(['autocomplete' => 'off', 'maxlength' => true, 'readonly' => true])->label(false) ?>
                            </div>
                        </div>

                        <label class='blue-text control-label typeLabel'>Marge reversement Laboratoire</label>

                        <div class="row">
                            <div class="col s4">
                                Taux de marge reversement Laboratoire (%):

                            </div>
                            <div class="col s1">
                                <!-- Détail du coût  -->
                                <?= $form->field($lot, "rate_repayement_margin")->textInput([
                                    'autocomplete' => 'off',
                                    'maxlength' => true,
                                    'onchange' => ' js:alert("toto"); UpdateRepayementMargin();'
                                ])->label(false) ?>
                            </div>
                            <div class="col s4">
                                <?= Html::button("+", ['title' => "Topic", 'onclick' => 'js:UpdateRepayementMargin();', 'class' => 'waves-effect waves-light btn btn']) ?>
                                <?= Html::button("-", ['title' => "Topic", 'onclick' => 'console.log(\'toto\');', 'class' => 'waves-effect waves-light btn btn-red']) ?>

                            </div>
                        </div>

                        <div class="row">
                            <div class="col s4">
                                <!-- Détail du coût  -->
                                Total Prix de revient H.T. reversement Laboratoire (€):
                            </div>
                            <div class="col s1">
                                <!-- Détail du coût  -->
                                <?= $form->field($lot, "total_cost_repayement_with_margin")->textInput(['autocomplete' => 'off', 'maxlength' => true, 'readonly' => true])->label(false) ?>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- Card view basique -->
                <div class="card">

                    <div class="card-content">
                        <label>Prix Total du lot</label>
                    </div>

                    <div class="card-action">

                        <div class="row">
                            <div class="col s3">
                                Montant Total HT (€):
                            </div>
                            <div class="col s1">
                                <?= $form->field($lot, "total_cost_lot")->textInput(['autocomplete' => 'off', 'maxlength' => true, 'readonly' => true])->label(false) ?>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col s3">
                                Taux de marge moyen avant frais de gestion (%):
                            </div>
                            <div class="col s1">
                                <?= $form->field($lot, "mean_lot_margin")->textInput(['autocomplete' => 'off', 'maxlength' => true, 'readonly' => true])->label(false) ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col s3">
                                Frais de gestion du support HT (€):
                            </div>
                            <div class="col s1">
                                <?= $form->field($lot, "support_cost")->textInput(['autocomplete' => 'off', 'maxlength' => true, 'readonly' => true])->label(false) ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col s3">
                                Prix de vente du lot HT (€):
                            </div>
                            <div class="col s1">
                                <?= $form->field($lot, "total_cost_lot_with_support")->textInput(['autocomplete' => 'off', 'maxlength' => true, 'readonly' => true])->label(false) ?>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Buttons -->
                <div class="form-group">
                    <?= Html::submitButton('Enregistrer <i class="material-icons right">save</i>', ['class' => 'waves-effect waves-light btn btn-blue']) ?>
                    <?= Html::a(Yii::t('app', 'Précédent'), ['#'], ['class' => 'waves-effect waves-light btn btn-grey']) ?>
                </div>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>

<?php

$management_rate = $lot->project->management_rate;
$script = <<< JS

///Debug
var LotrateMargine = "#lotsimulate-rate_humain_margin";
$(LotrateMargine).val(10);


LotrateMargine = "#lotsimulate-rate_consumable_investement_margin";
$(LotrateMargine).val(20);
  

LotrateMargine = "#lotsimulate-rate_repayement_margin";
$(LotrateMargine).val(30);
 
//Fin debug





UpdateHumanMargin();
UpdateInvestMargin();
UpdateRepayementMargin();
CalculTotalLot();

function UpdateHumanMargin()
{
    var totalcostwithmargin = "#lotsimulate-total_cost_human_with_margin";
    var LotrateMargin = "#lotsimulate-rate_humain_margin";
    var totalcost = "#lotsimulate-totalcosthuman";
    var resultattwithmargin = (1 + $(LotrateMargin).val()/100) * $(totalcost).val();
    $(totalcostwithmargin).val(resultattwithmargin);

 
}
function UpdateInvestMargin()
{
    var totalcostwithmargin = "#lotsimulate-total_cost_invest_with_margin";
    var LotrateMargin = "#lotsimulate-rate_consumable_investement_margin";
    var totalcost = "#lotsimulate-totalcostinvest";
    var resultattwithmargin = (1 + $(LotrateMargin).val()/100) * $(totalcost).val();
    $(totalcostwithmargin).val(resultattwithmargin);
 
}

function UpdateRepayementMargin()
{
    var totalcostwithmargin = "#lotsimulate-total_cost_repayement_with_margin";
    var LotrateMargin = "#lotsimulate-rate_repayement_margin";
    var totalcost = "#lotsimulate-totalcostrepayement";
    var resultattwithmargin = (1 + $(LotrateMargin).val()/100) * $(totalcost).val();
    $(totalcostwithmargin).val(resultattwithmargin);
}



function CalculTotalLot()
{

    
    var totalcosthuman = "#lotsimulate-totalcosthuman";
    var totalcostinvest = "#lotsimulate-totalcostinvest";
    var totalcostrepayement = "#lotsimulate-totalcostrepayement";

    var totalcostlot = "#lotsimulate-total_cost_lot";
    var totalcosthumanwithmargin = "#lotsimulate-total_cost_human_with_margin";
    var totalcostinvestwithmargin = "#lotsimulate-total_cost_invest_with_margin";
    var totalcostrepayementwithmargin = "#lotsimulate-total_cost_repayement_with_margin";

    var totalcost = parseInt($(totalcosthuman).val()) + parseInt($(totalcostinvest).val()) + parseInt($(totalcostrepayement).val())  ;
    var totalcostwithMargin = parseInt($(totalcosthumanwithmargin).val()) + parseInt($(totalcostinvestwithmargin).val()) + parseInt($(totalcostrepayementwithmargin).val())  ;
    $(totalcostlot).val(totalcostwithMargin);


    var meanlotmargin = "#lotsimulate-mean_lot_margin";
   


    var mean = ((totalcostwithMargin / totalcost) - 1) * 100;
    $(meanlotmargin).val(mean.toFixed(2));

    var supportcost = "#lotsimulate-support_cost";
    var totalcostlotwithsupport = "#lotsimulate-total_cost_lot_with_support";

    var ratesupp = $management_rate;


    var support = totalcostwithMargin * ratesupp /100;
    $(supportcost).val(support.toFixed(2));

    var totalwithsupport = support + totalcostwithMargin
    $(totalcostlotwithsupport).val(totalwithsupport.toFixed(2));

    
}

JS;

$this->registerJs($script);
