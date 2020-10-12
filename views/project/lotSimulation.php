<?php

use app\assets\AppAsset;
use app\assets\projects\ProjectLotSimulationAppAsset;
use app\widgets\TopTitle;
use yii\bootstrap\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap\Alert;

AppAsset::register($this);
ProjectLotSimulationAppAsset::register($this);

$this->title = 'Simulation de lot';
?>

<?= TopTitle::widget(['title' => $this->title]) ?>
<!-- Gère les bandeaux d'alerts -->
<?php if ($SaveSucess != null) : ?>
    <?php if ($SaveSucess) : ?>
        <?= Alert::widget(['options' => ['class' => 'alert-success',], 'body' => 'Enregistrement réussi ...',]) ?>
    <?php else : ?>
        <?= Alert::widget(['options' => ['class' => 'alert-danger',], 'body' => 'Enregistrement échoué ...',]) ?>
    <?php endif; ?>
<?php endif; ?>

<div class="container">
    <div class="project-create">
        <?php $form = ActiveForm::begin(['id' => 'dynamic-form', 'options' => ['enctype' => 'multipart/form-data']]); ?>
        <div class="row">
            <div class="col s6">
                <!-- Card view basique -->
                <div class="card">
                    <div class="card-content">
                        <label>Marges</label>
                    </div>
                    <div class="card-action">
                        <table class="highlight">
                            <tbody>
                                <tr>
                                    <td><label class='blue-text control-label typeLabel'>Marge Temps homme</label></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>Taux de marge temps homme (%) :</td>
                                    <td><?= $form->field($lot, "rate_human_margin")->input('number', ['min' => 10, 'max' => 100, 'step' => 0.5])->label(false) ?></td>
                                </tr>
                                <tr>
                                    <td>Total Prix de revient H.T. temps homme :</td>
                                    <td><?= $form->field($lot, "total_cost_human_with_margin")->textInput(['disabled' => true, 'autocomplete' => 'off', 'maxlength' => true, 'readonly' => true])->label(false) ?></td>
                                </tr>
                                <tr>
                                    <td><label class='blue-text control-label typeLabel'>Marge consommables, déplacements et achat</label></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>Taux de marge consommables, déplacements et achat (%) :</td>
                                    <td><?= $form->field($lot, "rate_consumable_investement_margin")->input('number', ['min' => 10, 'max' => 100, 'step' => 0.5])->label(false) ?></td>
                                </tr>
                                <tr>
                                    <td>Total Prix de revient H.T. consommables, déplacements et achat :</td>
                                    <td><?= $form->field($lot, "total_cost_invest_with_margin")->textInput(['disabled' => true, 'autocomplete' => 'off', 'maxlength' => true, 'readonly' => true])->label(false) ?></td>
                                </tr>
                                <tr>
                                    <td><label class='blue-text control-label typeLabel'>Marge reversement Laboratoire</label></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>Taux de marge reversement Laboratoire (%):</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>Taux de marge consommables, déplacements et achat (%) :</td>
                                    <td><?= $form->field($lot, "rate_repayement_margin")->input('number', ['min' => 10, 'max' => 100, 'step' => 0.5])->label(false) ?></td>
                                </tr>
                                <tr>
                                    <td>Total Prix de revient H.T. reversement Laboratoire :</td>
                                    <td><?= $form->field($lot, "total_cost_repayement_with_margin")->textInput(['disabled' => true, 'autocomplete' => 'off', 'maxlength' => true, 'readonly' => true])->label(false) ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col s6">
                <div class="card">
                    <div class="card-content">
                        <label>Détail des coûts du lot</label>
                    </div>
                    <div class="card-action">
                        <table class="highlight">
                            <tbody>
                                <tr>
                                    <td width="50%" class="table-font-bold">Total coût temps homme :</td>
                                    <td><?= $form->field($lot, "totalCostHuman", ['inputOptions' => ['disabled' => true, 'readonly' => true, 'value' => Yii::$app->formatter->asCurrency($lot->totalCostHuman)]])->label(false) ?></td>
                                </tr>
                                <tr>
                                    <td width="50%" class="table-font-bold">Total des dépenses et investissement :</td>
                                    <td> <?= $form->field($lot, "totalCostInvest", ['inputOptions' => ['disabled' => true, 'readonly' => true, 'value' => Yii::$app->formatter->asCurrency($lot->totalCostInvest)]])->label(false) ?></td>
                                </tr>
                                <tr>
                                    <td width="50%" class="table-font-bold">Total des reversements laboratoires :</td>
                                    <td><?= $form->field($lot, "totalCostRepayement", ['inputOptions' => ['disabled' => true, 'readonly' => true, 'value' => Yii::$app->formatter->asCurrency($lot->totalCostRepayement)]])->label(false) ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card">
                    <div class="card-content">
                        <label>Prix Total du lot</label>
                    </div>
                    <div class="card-action">
                        <table class="highlight">
                            <tbody>
                                <tr>
                                    <td width="50%" class="table-font-bold">Montant Total HT :</td>
                                    <td><?= $form->field($lot, "total_cost_lot")->textInput(['disabled' => true, 'autocomplete' => 'off', 'maxlength' => true, 'readonly' => true, 'format' => ['decimal', 2]])->label(false) ?></td>
                                </tr>
                                <tr>
                                    <td width="50%" class="table-font-bold">Taux de marge moyen avant frais de gestion :</td>
                                    <td><?= $form->field($lot, "average_lot_margin")->textInput(['disabled' => true, 'autocomplete' => 'off', 'maxlength' => true, 'readonly' => true])->label(false) ?></td>
                                </tr>
                                <tr>
                                    <td width="50%" class="table-font-bold">Frais de gestion du support HT :</td>
                                    <td><?= $form->field($lot, "support_cost")->textInput(['disabled' => true, 'autocomplete' => 'off', 'maxlength' => true, 'readonly' => true])->label(false) ?></td>
                                </tr>
                                <tr>
                                    <td width="50%" class="table-font-bold">Prix de vente du lot HT :</td>
                                    <td> <?= $form->field($lot, "total_cost_lot_with_support")->textInput(['disabled' => true, 'autocomplete' => 'off', 'maxlength' => true, 'readonly' => true])->label(false) ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="form-group to-the-right">
                    <?= Html::a(
                        Yii::t('app', '<i class="material-icons right">arrow_back</i>Annuler'),
                        ['project/project-simulate?project_id=' . $lot->project_id],
                        ['class' => 'waves-effect waves-light btn btn-grey', 'title' => 'Annuler']
                    ) ?>
                    <?= Html::submitButton(
                        '<i class="material-icons right">save</i>Suivant',
                        ['class' => 'waves-effect waves-light btn btn-blue', 'title' => 'Suivant']
                    ) ?>
                </div>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>

<!-- Informations relatives aux données présentes. -->
<div id="info-data-target" style="display: none;">
    <?php
    $totalCostHumanToJson = json_encode($lot->totalCostHuman);
    $totalCostInvestToJson = json_encode($lot->totalCostInvest);
    $totalCostRepayementToJson = json_encode($lot->totalCostRepayement);
    $management_rateToJson = $lot->project->management_rate;

    // Envoi de données.
    echo json_encode([
        'totalHumanCost' => $totalCostHumanToJson,
        'totalCostInvest' => $totalCostInvestToJson,
        'totalCostRepayement' => $totalCostRepayementToJson,
        'managementRate' => $management_rateToJson,
    ]);
    ?>
</div>