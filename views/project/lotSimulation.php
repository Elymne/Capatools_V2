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
                        <label>Détail des coûts</label>
                    </div>

                    <div class="card-action">
                        <div class="row">
                            <div class="col s3">
                                Total coût humain des tâches
                            </div>
                            <div class="col s1">
                                <?= $form->field($lot, "totalCostHuman")->textInput(['autocomplete' => 'off', 'maxlength' => true, 'readonly' => true])->label(false) ?>

                            </div>


                        </div>
                        <div class="row">
                            <div class="col s3">
                                Total des dépenses et investissement
                            </div>
                            <div class="col s1">
                                <?= $form->field($lot, "totalCostHuman")->textInput(['autocomplete' => 'off', 'maxlength' => true, 'readonly' => true])->label(false) ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col s3">
                                Total des reversements laboratoires
                            </div>
                            <div class="col s1">
                                <?= $form->field($lot, "totalCostHuman")->textInput(['autocomplete' => 'off', 'maxlength' => true, 'readonly' => true])->label(false) ?>
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
                                Total Prix de revient H.T. temps homme (CAPA + Labo)
                            </div>
                            <div class="col s1">
                                <!-- Détail du coût  -->
                                <?= $form->field($lot, "totalCostHuman")->textInput(['autocomplete' => 'off', 'maxlength' => true, 'readonly' => true])->label(false) ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col s4">
                                <!-- Détail du coût  -->
                                Taux de marge temps homme
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
                        <label class='blue-text control-label typeLabel'>Marge consommables, déplacements et achat</label>
                        <div class="row">
                            <div class="col s4">
                                <!-- Détail du coût  -->
                                Total Prix de revient H.T. consommables, déplacements et achat
                            </div>
                            <div class="col s1">
                                <!-- Détail du coût  -->
                                <?= $form->field($lot, "totalCostHuman")->textInput(['autocomplete' => 'off', 'maxlength' => true, 'readonly' => true])->label(false) ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col s4">
                                Taux de marge consommables, déplacements et achat

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

                        <label class='blue-text control-label typeLabel'>Marge reversement Laboratoire</label>
                        <div class="row">
                            <div class="col s4">
                                <!-- Détail du coût  -->
                                Total Prix de revient H.T. reversement Laboratoire
                            </div>
                            <div class="col s1">
                                <!-- Détail du coût  -->
                                <?= $form->field($lot, "totalCostHuman")->textInput(['autocomplete' => 'off', 'maxlength' => true, 'readonly' => true])->label(false) ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col s4">
                                Taux de marge reversement Laboratoire

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
                            <div class="col s1">
                                <?= $form->field($lot, "totalCostHuman")->textInput(['autocomplete' => 'off', 'maxlength' => true, 'readonly' => true])->label(false) ?>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col s3">
                                Taux marge moyen avant frais de gestion :
                            </div>
                            <div class="col s1">
                                <?= $form->field($lot, "totalCostHuman")->textInput(['autocomplete' => 'off', 'maxlength' => true, 'readonly' => true])->label(false) ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col s3">
                                Frais de gestion du support HT :
                            </div>
                            <div class="col s1">
                                <?= $form->field($lot, "totalCostHuman")->textInput(['autocomplete' => 'off', 'maxlength' => true, 'readonly' => true])->label(false) ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col s3">
                                Prix de vente du lot HT :
                            </div>
                            <div class="col s1">
                                <?= $form->field($lot, "totalCostHuman")->textInput(['autocomplete' => 'off', 'maxlength' => true, 'readonly' => true])->label(false) ?>
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