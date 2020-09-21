<?php

use app\assets\AppAsset;
use app\widgets\TopTitle;
use yii\bootstrap\Html;
use yii\widgets\ActiveForm;

use yii\bootstrap\Alert;

$this->title = 'Simulation de lot';

AppAsset::register($this);
?>

<?= TopTitle::widget(['title' => $this->title]) ?>
<?php
///Gère les bandeaux d'alerts
if ($SaveSucess != null) {
    if ($SaveSucess) {
        echo Alert::widget([
            'options' => [
                'class' => 'alert-success',
            ],
            'body' => 'Enregistrement réussi ...',
        ]);
    } else {
        echo Alert::widget([
            'options' => [
                'class' => 'alert-danger',
            ],
            'body' => 'Enregistrement échoué ...',
        ]);
    }
}
?>
<div class="container">
    <div class="project-create">
        <?php $form = ActiveForm::begin(['id' => 'dynamic-form', 'options' => ['enctype' => 'multipart/form-data']]); ?>
        <div class="row">
            <div class="col s10 offset-s1">

                <!-- Card view basique -->
                <div class="card">

                    <div class="card-content">
                        <label>Détail des coûts du lot </label>
                    </div>

                    <div class="card-action">
                        <div class="row">
                            <div class="col s3">
                                Total coût temps homme :
                            </div>
                            <div class="col s1">
                                <?= $form->field($lot, "totalCostHuman", ['inputOptions' => ['readonly' => true, 'value' => Yii::$app->formatter->asCurrency($lot->totalCostHuman)]])->label(false) ?>

                            </div>


                        </div>
                        <div class="row">
                            <div class="col s3">
                                Total des dépenses et investissement :
                            </div>
                            <div class="col s1">
                                <?= $form->field($lot, "totalCostInvest", ['inputOptions' => ['readonly' => true, 'value' => Yii::$app->formatter->asCurrency($lot->totalCostInvest)]])->label(false) ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col s3">
                                Total des reversements laboratoires :
                            </div>
                            <div class="col s1">
                                <?= $form->field($lot, "totalCostRepayement", ['inputOptions' => ['readonly' => true, 'value' => Yii::$app->formatter->asCurrency($lot->totalCostRepayement)]])->label(false) ?>
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
                            <div class="col s2">
                                <!-- Détail du coût  -->
                                <?= $form->field($lot, "rate_human_margin")->textInput(['autocomplete' => 'off', 'maxlength' => true,])->label(false) ?>
                            </div>
                            <div class="col s4">
                                <?= Html::button("+", ['id' => 'lotsimulate-rate_human_marginup',   'class' => 'waves-effect waves-light btn btn']) ?>
                                <?= Html::button("-", ['id' => 'lotsimulate-rate_human_margindown',   'class' => 'waves-effect waves-light btn btn-red']) ?>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col s4">
                                <!-- Détail du coût  -->
                                Total Prix de revient H.T. temps homme :
                            </div>
                            <div class="col s2">
                                <!-- Détail du coût  -->
                                <?= $form->field($lot, "total_cost_human_with_margin")->textInput(['autocomplete' => 'off', 'maxlength' => true, 'readonly' => true])->label(false) ?>
                            </div>
                        </div>

                        <label class='blue-text control-label typeLabel'>Marge consommables, déplacements et achat</label>

                        <div class="row">
                            <div class="col s4">
                                Taux de marge consommables, déplacements et achat (%):

                            </div>
                            <div class="col s2">
                                <!-- Détail du coût  -->
                                <?= $form->field($lot, "rate_consumable_investement_margin")->textInput(['autocomplete' => 'off', 'maxlength' => true,])->label(false) ?>
                            </div>
                            <div class="col s4">
                                <?= Html::button("+", ['id' => 'lotsimulate-rate_consumable_investement_marginup',   'class' => 'waves-effect waves-light btn btn']) ?>
                                <?= Html::button("-", ['id' => 'lotsimulate-rate_consumable_investement_margindown',   'class' => 'waves-effect waves-light btn btn-red']) ?>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col s4">
                                <!-- Détail du coût  -->
                                Total Prix de revient H.T. consommables, déplacements et achat :
                            </div>
                            <div class="col s2">
                                <!-- Détail du coût  -->
                                <?= $form->field($lot, "total_cost_invest_with_margin")->textInput(['autocomplete' => 'off', 'maxlength' => true, 'readonly' => true])->label(false) ?>
                            </div>
                        </div>

                        <label class='blue-text control-label typeLabel'>Marge reversement Laboratoire</label>

                        <div class="row">
                            <div class="col s4">
                                Taux de marge reversement Laboratoire (%):

                            </div>
                            <div class="col s2">
                                <!-- Détail du coût  -->
                                <?= $form->field($lot, "rate_repayement_margin")->textInput([
                                    'autocomplete' => 'off',
                                    'maxlength' => true,
                                ])->label(false) ?>
                            </div>
                            <div class="col s4">
                                <?= Html::button("+", ['id' => 'lotsimulate-rate_repayement_marginup',  'class' => 'waves-effect waves-light  btn']) ?>
                                <?= Html::button("-", ['id' => 'lotsimulate-rate_repayement_margindown',  'class' => 'waves-effect waves-light btn btn-red']) ?>

                            </div>
                        </div>

                        <div class="row">
                            <div class="col s4">
                                <!-- Détail du coût  -->
                                Total Prix de revient H.T. reversement Laboratoire :
                            </div>
                            <div class="col s2">
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
                                Montant Total HT :
                            </div>
                            <div class="col s2">
                                <?= $form->field($lot, "total_cost_lot")->textInput(['autocomplete' => 'off', 'maxlength' => true, 'readonly' => true, 'format' => ['decimal', 2]])->label(false) ?>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col s3">
                                Taux de marge moyen avant frais de gestion :
                            </div>
                            <div class="col s2">
                                <?= $form->field($lot, "average_lot_margin")->textInput(['autocomplete' => 'off', 'maxlength' => true, 'readonly' => true])->label(false) ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col s3">
                                Frais de gestion du support HT :
                            </div>
                            <div class="col s2">
                                <?= $form->field($lot, "support_cost")->textInput(['autocomplete' => 'off', 'maxlength' => true, 'readonly' => true])->label(false) ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col s3">
                                Prix de vente du lot HT :
                            </div>
                            <div class="col s2">
                                <?= $form->field($lot, "total_cost_lot_with_support")->textInput(['autocomplete' => 'off', 'maxlength' => true, 'readonly' => true])->label(false) ?>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Buttons -->
                <div class="form-group">
                    <div style="bottom: 50px; right: 25px;" class="fixed-action-btn direction-top">
                        <?= Html::a(
                            Yii::t('app', '<i class="material-icons right">arrow_back</i>'),
                            ['project/project-simulate?project_id=' . $lot->project_id],
                            ['class' => 'waves-effect waves-light btn-floating btn-large btn-grey', 'title' => 'Retour à la page de simulation']
                        ) ?>
                        <?= Html::submitButton(
                            '<i class="material-icons right">save</i>',
                            ['class' => 'waves-effect waves-light btn-floating btn-large btn-blue', 'title' => 'Sauvegarder les options']
                        ) ?>
                    </div>
                </div>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>

<?php

$management_rate = $lot->project->management_rate;
$script = <<< JS
let stepsize = 0.5;



//Fin debug
let InputRateHumamMargin = "#lotsimulate-rate_human_margin";
    $(InputRateHumamMargin).on('blur', function(e){
        let rate = parseFloat(e.currentTarget.value);
        if(rate < 10  || isNaN(rate))
        {
            e.currentTarget.value = 10;
        }

    })

    $(InputRateHumamMargin).on('input', function(e){
        UpdateHumanMargin();    
        CalculTotalLot();
    })


    let InputInvestMargin = "#lotsimulate-rate_consumable_investement_margin";
    $(InputInvestMargin).on('blur', function(e){
        let rate = parseFloat(e.currentTarget.value);
        if(rate < 0 || isNaN(rate))
        {
            e.currentTarget.value = 0;
        }

    })


    $(InputInvestMargin).on('input', function(e){
        UpdateInvestMargin();    
        CalculTotalLot();
    })


    let InputRepayementMargin = "#lotsimulate-rate_repayement_margin";
    $(InputRepayementMargin).on('blur', function(e){
        let rate = parseFloat(e.currentTarget.value);
        if(rate < 0.0 || isNaN(rate))
        {
            e.currentTarget.value = 0;
        }

    })  
    $(InputRepayementMargin).on('input', function(e){
        UpdateRepayementMargin();    
        CalculTotalLot();
    })


    let ButtonRateHumamMarginUp = "#lotsimulate-rate_human_marginup"; 
    $(ButtonRateHumamMarginUp).on('click', function(){
        let rate = parseFloat($(InputRateHumamMargin).val());
        if(!isNaN(rate))
        {
            $(InputRateHumamMargin).val(rate + stepsize);
            UpdateHumanMargin();    
            CalculTotalLot();
        }
    })
  
    let ButtonRateHumamMarginDown = "#lotsimulate-rate_human_margindown";
    $(ButtonRateHumamMarginDown).on('click', function(){
        let rate = parseFloat($(InputRateHumamMargin).val());
        if(!isNaN(rate))
        {
            
            rate = rate - stepsize;
           if(rate >= 10)
           {
                $(InputRateHumamMargin).val(rate );
                UpdateHumanMargin();    
                CalculTotalLot();
           }
        }
    })


    let ButtonInvestMarginUp = "#lotsimulate-rate_consumable_investement_marginup";
    $(ButtonInvestMarginUp).on('click', function(){
        let rate = parseFloat($(InputInvestMargin).val());
        if(!isNaN(rate))
        {
            $(InputInvestMargin).val(rate + stepsize);
            UpdateInvestMargin();    
            CalculTotalLot();
        }
    })

    let ButtonInvestMarginDown = "#lotsimulate-rate_consumable_investement_margindown";
    $(ButtonInvestMarginDown).on('click', function(){
        let rate = parseFloat($(InputInvestMargin).val());
        if(!isNaN(rate))
        {
            
            rate = rate - stepsize;
           if(rate >= 0)
            {
                $(InputInvestMargin).val(rate);
                UpdateInvestMargin();    
                CalculTotalLot();
           }
        }
    })

    let ButtonRepayementMarginUp = "#lotsimulate-rate_repayement_marginup";
    $(ButtonRepayementMarginUp).on('click', function(){
        let rate = parseFloat($(InputRepayementMargin).val());
        if(!isNaN(rate))
        {
            $(InputRepayementMargin).val(rate + stepsize);
            UpdateRepayementMargin();    
            CalculTotalLot();
        }
    })
    let ButtonRepayementMarginDown = "#lotsimulate-rate_repayement_margindown";
    $(ButtonRepayementMarginDown).on('click', function(){
        let rate = parseFloat($(InputRepayementMargin).val());
        if(!isNaN(rate))
        {
            
             rate = rate - stepsize;
            if(rate >= 0)
            {
                $(InputRepayementMargin).val(rate);
                UpdateRepayementMargin();    
                CalculTotalLot();
            }
        }
    })



UpdateHumanMargin();
UpdateInvestMargin();
UpdateRepayementMargin();
CalculTotalLot();

function UpdateHumanMargin()
{
    let totalcostwithmargin = "#lotsimulate-total_cost_human_with_margin";
    let LotrateMargin = "#lotsimulate-rate_human_margin";
    let resultattwithmargin =$lot->totalCostHuman  * (1 + $(LotrateMargin).val()/100)
    
    if(isNaN(resultattwithmargin))
    {
        resultattwithmargin = 0;
    }
    $(totalcostwithmargin).val(new Intl.NumberFormat('fr-FR', { style: 'currency', currency: 'EUR' }).format(resultattwithmargin.toFixed(2)));

 
}
function UpdateInvestMargin()
{
    let totalcostwithmargin = "#lotsimulate-total_cost_invest_with_margin";
    let LotrateMargin = "#lotsimulate-rate_consumable_investement_margin";
    let resultattwithmargin =$lot->totalCostInvest * (1 + $(LotrateMargin).val()/100)  ;
    if(isNaN(resultattwithmargin))
    {
        resultattwithmargin = 0;
    }
    $(totalcostwithmargin).val( new Intl.NumberFormat('fr-FR', { style: 'currency', currency: 'EUR' }).format(resultattwithmargin.toFixed(2)));
 
}

function UpdateRepayementMargin()
{
    let totalcostwithmargin = "#lotsimulate-total_cost_repayement_with_margin";
    let LotrateMargin = "#lotsimulate-rate_repayement_margin";
    let totalcost = "#lotsimulate-totalcostrepayement";
    let resultattwithmargin = $lot->totalCostRepayement *(1 + $(LotrateMargin).val()/100) ;
    if(isNaN(resultattwithmargin))
    {
        resultattwithmargin = 0;
    }
    $(totalcostwithmargin).val(new Intl.NumberFormat('fr-FR', { style: 'currency', currency: 'EUR' }).format(resultattwithmargin.toFixed(2)));
}



function CalculTotalLot()
{

    
    let totalcosthuman = "#lotsimulate-totalcosthuman";
    let totalcostinvest = "#lotsimulate-totalcostinvest";
    let totalcostrepayement = "#lotsimulate-totalcostrepayement";

    let totalcostlot = "#lotsimulate-total_cost_lot";
    let totalcosthumanwithmargin = "#lotsimulate-total_cost_human_with_margin";
    let totalcostinvestwithmargin = "#lotsimulate-total_cost_invest_with_margin";
    let totalcostrepayementwithmargin = "#lotsimulate-total_cost_repayement_with_margin";
 let totalcosthumanprice =  (Number($(totalcosthuman).val().replace(',','.').replace(/[^0-9.-]+/g,""))); 
 let totalcostinvestprice =  (Number($(totalcostinvest).val().replace(',','.').replace(/[^0-9.-]+/g,""))); 
 let totalcostrepayementprice =  (Number($(totalcostrepayement).val().replace(',','.').replace(/[^0-9.-]+/g,""))); 
 let totalcosthumanwithmarginprice =  (Number($(totalcosthumanwithmargin).val().replace(',','.').replace(/[^0-9.-]+/g,""))); 
 let totalcostinvestwithmarginprice =  (Number($(totalcostinvestwithmargin).val().replace(',','.').replace(/[^0-9.-]+/g,""))); 
 let totalcostrepayementwithmarginprice =  (Number($(totalcostrepayementwithmargin).val().replace(',','.').replace(/[^0-9.-]+/g,""))); 

    let totalcost = totalcosthumanprice + totalcostinvestprice + totalcostrepayementprice  ;
    let totalcostwithMargin = totalcosthumanwithmarginprice +  totalcostinvestwithmarginprice + totalcostrepayementwithmarginprice  ;
    $(totalcostlot).val(new Intl.NumberFormat('fr-FR', { style: 'currency', currency: 'EUR' }).format(totalcostwithMargin.toFixed(2)));


    let averagelotmargin = "#lotsimulate-average_lot_margin";


    let average = ((totalcostwithMargin / totalcost) - 1);
    if(isNaN(average))
    {
        average = 0;
    } 
    $(averagelotmargin).val(new Intl.NumberFormat('fr-FR', { style: 'percent', maximumFractionDigits: 2 }).format(average));

    let supportcost = "#lotsimulate-support_cost";
    let totalcostlotwithsupport = "#lotsimulate-total_cost_lot_with_support";

    let ratesupp = $management_rate;


    let totalwithsupport = totalcostwithMargin / (1 - ratesupp /100);
    let support = totalwithsupport * (ratesupp /100);
    $(supportcost).val(new Intl.NumberFormat('fr-FR', { style: 'currency', currency: 'EUR' }).format(support.toFixed(2)));

    $(totalcostlotwithsupport).val(new Intl.NumberFormat('fr-FR', { style: 'currency', currency: 'EUR' }).format(totalwithsupport.toFixed(2)));

    
}

JS;

$this->registerJs($script);
