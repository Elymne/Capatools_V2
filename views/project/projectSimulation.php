<?php

use app\assets\AppAsset;
use app\models\projects\Project;
use app\assets\projects\ProjectSimulationAsset;
use app\widgets\TopTitle;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\bootstrap\Html;
use yii\widgets\ActiveForm;

$this->title = 'Simulation du projet';

AppAsset::register($this);

ProjectSimulationAsset::register($this);
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
                        <label>Détail des coûts d'avant projet (hors marges)</label>
                    </div>

                    <div class="card-action">
                        <div class="row">
                            <div class="col s3">
                                Total coût temps homme (€):
                            </div>
                            <div class="col s1">
                                <?= $form->field($lotavp, "totalCostHuman")->textInput(['autocomplete' => 'off', 'maxlength' => true, 'readonly' => true])->label(false) ?>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col s3">
                                Total des dépenses et investissement (€):
                            </div>
                            <div class="col s1">
                                <?= $form->field($lotavp, "totalCostInvest")->textInput(['autocomplete' => 'off', 'maxlength' => true, 'readonly' => true])->label(false) ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col s3">
                                Total des reversements laboratoires (€):
                            </div>
                            <div class="col s1">
                                <?= $form->field($lotavp, "totalCostRepayement")->textInput(['autocomplete' => 'off', 'maxlength' => true, 'readonly' => true])->label(false) ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col s3">
                                Total de l'avant projet (€):
                            </div>
                            <div class="col s1">
                                <?= $form->field($lotavp, "total")->textInput(['autocomplete' => 'off', 'maxlength' => true, 'readonly' => true])->label(false) ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col s3">
                                <?= Html::a(Yii::t('app', 'Modifier les tâches'), ['#'], ['class' => 'waves-effect waves-light btn btn-blue']) ?>

                            </div>
                            <div class="col s1">
                                <?= Html::a(Yii::t('app', 'Modifier les investissements/Consomable/Laboratoire'), ['#'], ['class' => 'waves-effect waves-light btn btn-blue']) ?>
                            </div>
                        </div>

                    </div>
                </div>
                <!-- Card view basique -->
                <div class="card">

                    <div class="card-content">
                        <label>Résumer du projet</label>
                        <label>avec les coûts d'avant projet intégré dans chaque lot</label>
                    </div>

                    <?php
                    $MargeAverage = $project->marginaverage;
                    $totalcostavplot = ($lotavp->total *  ($project->marginaverage / 100 + 1)) / (count($lots) - 1);
                    $totalprojet = 0.0

                    ?>
                    <div class="card-action">
                        <?php foreach ($lots as $lotproject) {
                            if ($lotproject->number != 0) {
                        ?>
                                <label class='blue-text control-label typeLabel'> <?= $lotproject->title ?> </label>
                                <div class="row">
                                    <div class="col s3">
                                        <!-- Détail du coût  -->
                                        Prix du total lot :
                                    </div>
                                    <div class="col s2">
                                        <!-- Détail du coût  -->
                                        <?= Html::input('text', '', $lotproject->totalwithmargin + $project->additionallotprice, $options = ['autocomplete' => 'off', 'maxlength' => true, 'readonly' => true,]) ?>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col s3">
                                        <?= Html::a(Yii::t('app', 'Modifier les tâches'), ['#'], ['class' => 'waves-effect waves-light btn btn-blue']) ?>

                                    </div>
                                    <div class="col s5">
                                        <?= Html::a(Yii::t('app', 'Modifier les invest/Consomable/Laboratoire'), ['#'], ['class' => 'waves-effect waves-light btn btn-blue']) ?>
                                    </div>
                                    <div class="col s1">
                                        <?= Html::a(Yii::t('app', 'Modifier les marges'), ['#'], ['class' => 'waves-effect waves-light btn btn-blue']) ?>
                                    </div>
                                </div>

                        <?php
                            }
                        } ?>


                    </div>

                </div>
                <!-- Card view basique -->
                <div class="card">

                    <div class="card-content">
                        <label>Prix Total du projet</label>
                    </div>

                    <div class="card-action">

                        <div class="row">
                            <div class="col s3">
                                Montant Total HT (€):
                            </div>
                            <div class="col s2">
                                <?= $form->field($project, "total")->textInput(['autocomplete' => 'off', 'maxlength' => true, 'readonly' => true])->label(false) ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col s3">
                                Taux de marge moyen avant frais de gestion (%):
                            </div>
                            <div class="col s2">
                                <?= $form->field($project, "marginaverage")->textInput(['autocomplete' => 'off', 'maxlength' => true, 'readonly' => true])->label(false) ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col s3">
                                Frais de gestion du support HT (€):
                            </div>
                            <div class="col s2">
                                <?= $form->field($project, "supportprice")->textInput(['autocomplete' => 'off', 'maxlength' => true, 'readonly' => true])->label(false) ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col s3">
                                Prix de vente du lot HT (€):
                            </div>
                            <div class="col s2">
                                <?= $form->field($project, "SellingPrice")->textInput(['autocomplete' => 'off', 'maxlength' => true, 'readonly' => true])->label(false) ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">

                    <div class="card-content">
                        <label>Facturation</label>
                    </div>

                    <div class="card-action">
                        <?php

                        DynamicFormWidget::begin([
                            'widgetContainer' => 'dynamicform_millestone', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                            'widgetBody' => '.container-items-millestone', // required: css class selector
                            'widgetItem' => '.item-millestone', // required: css class
                            'limit' => 10, // the maximum times, an element can be cloned (default 999)
                            'min' => 1, // 0 or 1 (default 1)
                            'insertButton' => '.add-item-millestone', // css class
                            'deleteButton' => '.remove-item-millestone', // css class
                            'model' => $millestones[0],
                            'formId' => 'dynamic-form',
                            'formFields' => [
                                'pourcentage',
                            ],
                        ]); ?>
                        <div class="container-items-millestone">
                            <!-- widgetContainer -->
                            <?php foreach ($millestones as $i => $millestone) : ?>
                                <div class="item-millestone">

                                    <?php
                                    // necessary for update action.
                                    if (!$millestone->isNewRecord) {
                                        echo Html::activeHiddenInput($millestone, "[{$i}]id");
                                    }
                                    ?>
                                    <div class="row">
                                        <div class="col s3">
                                            <?= $form->field($millestone, "[{$i}]comment")->textInput(['autocomplete' => 'off', 'maxlength' => true,])->label("Titre") ?>

                                        </div>
                                        <div class="col s2">
                                            <?= $form->field($millestone, "[{$i}]pourcentage")->textInput(['autocomplete' => 'off', 'maxlength' => true,])->label("Pourcentage") ?>
                                        </div>
                                        <div class="col s2">
                                            <?= $form->field($millestone, "[{$i}]price")->textInput(['autocomplete' => 'off', 'maxlength' => true,])->label("Prix") ?>
                                        </div>
                                        <div class="col 2">
                                            <button type="button" class="add-item-millestone btn-floating waves-effect waves-light btn-grey"><i class="glyphicon glyphicon-plus"></i></button>
                                        </div>
                                        <div class="col 2">
                                            <button type="button" class="remove-item-millestone btn-floating waves-effect waves-light btn-grey"><i class="glyphicon glyphicon-minus"></i></button>
                                        </div>
                                    </div>

                                </div>
                            <?php endforeach; ?>
                        </div>

                        <?php DynamicFormWidget::end(); ?>
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