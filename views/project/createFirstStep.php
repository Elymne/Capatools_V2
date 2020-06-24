<?php

use app\assets\AppAsset;
use app\assets\projects\ProjectCreateFirstPhaseAsset;
use app\models\projects\Project;
use app\widgets\TopTitle;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\bootstrap\Html;
use yii\widgets\ActiveForm;

$this->title = 'Création d\'un projet - paramètres généraux';
$this->params['breadcrumbs'][] = ['label' => 'Devis', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';

AppAsset::register($this);
ProjectCreateFirstPhaseAsset::register($this);

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
                        <label>Paramètres généraux</label>
                    </div>

                    <div class="card-action">

                        <!-- Type de projet  -->
                        <label class='blue-text control-label typeLabel'>Type de projet</label>
                        <?= $form->field($model, 'combobox_type_checked')->radioList(Project::TYPES, [
                            'item' => function ($index, $label, $name, $checked, $value) {

                                if ($index == 0) $check = "checked";
                                else $check = "";

                                $return = '<label class="modal-radio">';
                                $return .= '<input ' . $check . ' type="radio" name="' . $name . '" value="' . $value . '" tabindex="3">';
                                $return .= '<span>' . ucwords($label) . '</span>';
                                $return .= '</label>';
                                return $return;
                            }
                        ])->label(false); ?>

                        <!-- lot ou pas ? -->
                        <label class='blue-text control-label typeLabel'>Le projet comprend-il des lots ou des options ?</label>
                        <?= $form->field($model, 'combobox_lot_checked')->radioList([1 => "non", 2 => "oui"], [
                            'item' => function ($index, $label, $name, $checked, $value) {

                                if ($index == 1) $check = "checked";
                                else $check = "";

                                $return = '<label class="modal-radio">';
                                $return .= '<input ' . $check . ' type="radio" name="' . $name . '" value="' . $value . '" tabindex="3">';
                                $return .= '<span>' . ucwords($label) . '</span>';
                                $return .= '</label>';
                                return $return;
                            }
                        ])->label(false); ?>

                        <!-- renversement labo ou pas ? -->
                        <label class='blue-text control-label typeLabel'>Le projet comprend-il des reversements labo ?</label>
                        <?= $form->field($model, 'combobox_repayment_checked')->radioList([1 => "non", 2 => "oui"], [
                            'item' => function ($index, $label, $name, $checked, $value) {

                                if ($index == 1) $check = "checked";
                                else $check = "";

                                $return = '<label class="modal-radio">';
                                $return .= '<input ' . $check . ' type="radio" name="' . $name . '" value="' . $value . '" tabindex="3">';
                                $return .= '<span>' . ucwords($label) . '</span>';
                                $return .= '</label>';
                                return $return;
                            }
                        ])->label(false); ?>

                        <!-- Création de lot -->
                        <label id="lot-management-label" class='blue-text control-label typeLabel'>Créer des lots - ils seront éditables par la suite</label>
                        <div id="lot-management-body" class="col s12">
                            <div class="row">
                                <div class="input-field col s12">

                                    <?php DynamicFormWidget::begin([
                                        'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                                        'widgetBody' => '.container-items-task', // required: css class selector
                                        'widgetItem' => '.item', // required: css class
                                        'limit' => 10, // the maximum times, an element can be cloned (default 999)
                                        'min' => 1, // 0 or 1 (default 1)
                                        'insertButton' => '.add-item', // css class
                                        'deleteButton' => '.remove-item', // css class
                                        'model' => $lots[0],
                                        'formId' => 'dynamic-form',
                                        'formFields' => [
                                            'id',
                                            'title'
                                        ],
                                    ]); ?>

                                    <div class="container-items-task">
                                        <!-- widgetContainer -->
                                        <?php foreach ($lots as $i => $lot) : ?>
                                            <div class="item">

                                                <?php
                                                $lot_rank = $i + 1;
                                                // necessary for update action.
                                                if (!$lot->isNewRecord) {
                                                    echo Html::activeHiddenInput($lot, "[{$i}]id");
                                                }
                                                ?>

                                                <div class="row">
                                                    <div class="col s6">
                                                        <?= $form->field($lot, "[{$i}]title")->textInput(['autocomplete' => 'off', 'maxlength' => true])->label("Titre lot") ?>
                                                    </div>
                                                    <div class="col 2">
                                                        <button type="button" class="add-item btn-floating btn-large waves-effect waves-light btn-grey"><i class="glyphicon glyphicon-plus"></i></button>
                                                    </div>
                                                    <div class="col 2">
                                                        <button type="button" class="remove-item btn-floating btn-large waves-effect waves-light btn-grey"><i class="glyphicon glyphicon-minus"></i></button>
                                                    </div>
                                                </div><!-- .row -->

                                            </div>
                                        <?php endforeach; ?>
                                    </div>

                                    <?php DynamicFormWidget::end(); ?>

                                </div>
                            </div>
                        </div>


                        <div class="form-group">
                            <?= Html::submitButton('Enregistrer <i class="material-icons right">save</i>', ['class' => 'waves-effect waves-light btn btn-blue']) ?>
                            <?= Html::a(Yii::t('app', 'Annuler'), ['#'], ['class' => 'waves-effect waves-light btn btn-grey']) ?>
                        </div>

                    </div>

                </div>

            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>