<?php

use yii\widgets\ActiveForm;
use app\assets\AppAsset;
use app\assets\devis\RefactoringAsset;
use app\assets\projects\RefactoringAsset as ProjectsRefactoringAsset;
use app\widgets\TopTitle;
use kartik\select2\Select2;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\bootstrap\Html;

/* @var $this yii\web\View */
/* @var $model app\models\devis\Devis */

$this->title = 'Création';

AppAsset::register($this);
ProjectsRefactoringAsset::register($this);

?>

<?= TopTitle::widget(['title' => $this->title]) ?>


<div class="container">
    <div class="devis-update">

        <?php $form = ActiveForm::begin(['id' => 'dynamic-form', 'options' => ['enctype' => 'multipart/form-data']]); ?>
        <div class="row">

            <div class="col s10 offset-s1">

                <!-- Informations générales -->
                <div id="first-form-card" class="card">

                    <div class="card-content">
                        <label>Informations générales</label>
                    </div>

                    <div class="card-action">

                        <div class="col s12">
                            <div class="row">

                                <div class="input-field col s6">
                                    <?= $form->field($model, 'internal_name')
                                        ->textInput(['maxlength' => true], ['autocomplete' => 'off'])
                                        ->label("Nom du projet")
                                    ?>
                                </div>
                                <div class="input-field col s6">
                                    <?= $form->field($model, 'ref_interne')
                                        ->textInput(['maxlength' => true], ['autocomplete' => 'off'])
                                        ->label("Référence interne du projet")
                                    ?>
                                </div>

                            </div>
                        </div>

                        <div class="col s12">
                            <div class="row">

                                <div class="input-field col s6">
                                    <?= $form->field($model, 'company_name')
                                        ->widget(\yii\jui\AutoComplete::classname(), [
                                            'clientOptions' => [
                                                'source' => ['David Lynch'],
                                            ],
                                        ])->label(
                                            "Client"
                                        );
                                    ?>
                                    <?= Html::a('Créer un client', [''], ['class' => '']) ?>
                                </div>
                                <div class="input-field col s6">
                                    <?= $form->field($model, 'proba')->widget(Select2::classname(), [
                                        'data' => ['10 %', '20 %', '30 %', '40 %', '50 %', '60 %', '70 %', '80 %'],
                                        'language' => 'de',
                                        'options' => ['placeholder' => 'Select a state ...'],
                                        'pluginOptions' => [
                                            'allowClear' => true
                                        ],
                                    ]); ?>
                                </div>

                            </div>
                        </div>

                        <div class="col s12">
                            <div class="row">

                                <div class="input-field col s6">
                                    <?= $form->field($model, 'company_name')
                                        ->widget(\yii\jui\AutoComplete::classname(), [
                                            'clientOptions' => [
                                                'source' => ['Lar Von Trier'],
                                            ],
                                        ])->label(
                                            "Client"
                                        );
                                    ?>
                                    <?= Html::a('Créer un contact', [''], ['class' => '']) ?>
                                </div>
                                <div class="input-field col s6">
                                    <?= $form->field($fileModel, 'file')
                                        ->label('Document technique / Cahier des charges annexe (PDF)', [])
                                        ->fileInput([])
                                    ?>
                                </div>

                            </div>
                        </div>

                        <div class="col s12">
                            <div class="row">
                                <div class="input-field col s6">
                                    <?= $form->field($model, 'price')->widget(Select2::classname(), [
                                        'data' => ['someone'],
                                        'language' => 'de',
                                        'options' => ['placeholder' => 'Select a state ...'],
                                        'pluginOptions' => [
                                            'allowClear' => true
                                        ],
                                    ]); ?>
                                </div>
                            </div>
                        </div>

                        <div class="col s12">
                            <div class="row">

                                <div class="input-field col s1 offset-s11">
                                    <?= Html::a('Suivant', null, ['id' => 'first-next-link']) ?>
                                </div>

                            </div>
                        </div>

                    </div>

                </div>

                <!-- Informations générales -->
                <div id="second-form-card" class="card" style="display: none">

                    <div class="card-content">
                        <label>Tâches</label>
                    </div>

                    <div class="card-action">

                        <div class="col s12">
                            <div class="row">

                                <div class="input-field col s6">
                                    <?= $form->field($model, 'test')
                                        ->textInput(['maxlength' => true], ['autocomplete' => 'off'])
                                        ->label("Temps passé à la prospection, réunions, chiffrages")
                                    ?>
                                </div>

                            </div>
                        </div>

                        <div class="col s12">
                            <div class="row">
                                <div class="input-field col s12">
                                    <p>Liste des lots(optionnel) - Ensemble de tâches à regrouper et facturées</p>
                                </div>
                                <div class="input-field col s12">
                                    <?php DynamicFormWidget::begin([
                                        'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                                        'widgetBody' => '.container-items-lot', // required: css class selector
                                        'widgetItem' => '.item', // required: css class
                                        'limit' => 4, // the maximum times, an element can be cloned (default 999)
                                        'min' => 1, // 0 or 1 (default 1)
                                        'insertButton' => '.add-item', // css class
                                        'deleteButton' => '.remove-item', // css class
                                        'model' => $milestones[0],
                                        'formId' => 'dynamic-form',
                                        'formFields' => [
                                            'id',
                                            'prix_jalon',
                                            'price',
                                            'delivery_date',
                                            'comments'
                                        ],
                                    ]); ?>

                                    <div class="container-items-lot">
                                        <!-- widgetContainer -->
                                        <?php foreach ($milestones as $i => $milestone) : ?>
                                            <div class="item panel panel-default">
                                                <!-- widgetBody -->

                                                <div class="panel-body">
                                                    <?php
                                                    // necessary for update action.
                                                    if (!$milestone->isNewRecord) {
                                                        echo Html::activeHiddenInput($milestone, "[{$i}]id");
                                                    }
                                                    ?>

                                                    <div class="row">
                                                        <div class="col s6">
                                                            <?= $form->field($milestone, "[{$i}]label")->textInput(['autocomplete' => 'off', 'maxlength' => true])->label('Description du lot') ?>
                                                        </div>
                                                        <div class="col 1">
                                                            <button type="button" class="add-item waves-effect waves-light btn btn-grey"><i class="glyphicon glyphicon-plus"></i></button>
                                                        </div>
                                                        <div class="col 1">
                                                            <button type="button" class="remove-item waves-effect waves-light btn btn-grey"><i class="glyphicon glyphicon-minus"></i></button>
                                                        </div>
                                                    </div><!-- .row -->

                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>

                                    <?php DynamicFormWidget::end(); ?>
                                </div>
                            </div>
                        </div>

                        <div class="col s12">
                            <div class="row">
                                <div class="input-field col s12">
                                    <p>Liste des tâches</p>
                                </div>
                                <div class="input-field col s12">

                                    <?php DynamicFormWidget::begin([
                                        'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                                        'widgetBody' => '.container-items-task', // required: css class selector
                                        'widgetItem' => '.item', // required: css class
                                        'limit' => 4, // the maximum times, an element can be cloned (default 999)
                                        'min' => 1, // 0 or 1 (default 1)
                                        'insertButton' => '.add-item', // css class
                                        'deleteButton' => '.remove-item', // css class
                                        'model' => $milestones[0],
                                        'formId' => 'dynamic-form',
                                        'formFields' => [
                                            'id',
                                            'prix_jalon',
                                            'price',
                                            'delivery_date',
                                            'comments'
                                        ],
                                    ]); ?>

                                    <div class="container-items-task">
                                        <!-- widgetContainer -->
                                        <?php foreach ($milestones as $i => $milestone) : ?>
                                            <div class="item panel panel-default">
                                                <!-- widgetBody -->

                                                <div class="panel-body">
                                                    <?php
                                                    // necessary for update action.
                                                    if (!$milestone->isNewRecord) {
                                                        echo Html::activeHiddenInput($milestone, "[{$i}]id");
                                                    }
                                                    ?>

                                                    <div class="row">
                                                        <div class="col s5">
                                                            <?= $form->field($milestone, "[{$i}]label")->textInput(['autocomplete' => 'off', 'maxlength' => true])->label('Description de la tâche') ?>
                                                        </div>
                                                        <div class="col s1">
                                                            <?= $form->field($milestone, "[{$i}]label")->textInput(['autocomplete' => 'off', 'maxlength' => true])->label('Jours') ?>
                                                        </div>
                                                        <div class="col s1">
                                                            <?= $form->field($milestone, "[{$i}]label")->textInput(['autocomplete' => 'off', 'maxlength' => true])->label('No Lot') ?>
                                                        </div>
                                                        <div class="col s1">
                                                            <?= $form->field($milestone, "[{$i}]label")->textInput(['autocomplete' => 'off', 'maxlength' => true])->label('Intervenant') ?>
                                                        </div>
                                                        <div class="col s1">
                                                            <?= $form->field($milestone, "[{$i}]label")->textInput(['autocomplete' => 'off', 'maxlength' => true])->label('Risque') ?>
                                                        </div>
                                                        <div class="col 1">
                                                            <button type="button" class="add-item waves-effect waves-light btn btn-grey"><i class="glyphicon glyphicon-plus"></i></button>
                                                        </div>
                                                        <div class="col 1">
                                                            <button type="button" class="remove-item waves-effect waves-light btn btn-grey"><i class="glyphicon glyphicon-minus"></i></button>
                                                        </div>
                                                    </div><!-- .row -->

                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>

                                    <?php DynamicFormWidget::end(); ?>
                                </div>
                            </div>
                        </div>

                        <div class="col s12">
                            <div class="row">
                                <div class="input-field col s1 offset-s10">
                                    <?= Html::a('Retour', null, ['id' => 'second-back-link']) ?>
                                </div>


                                <div class="input-field col s1">
                                    <?= Html::a('Suivant', null, ['id' => 'second-next-link']) ?>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Informations générales -->
                <div id="third-form-card" class="card" style="display: none">

                    <div class="card-content">
                        <label>Labo</label>
                    </div>

                    <div class="card-action">

                        <div class="col s12">
                            <div class="row">
                                <div class="input-field col s12">
                                    <p>Liste des tâches</p>
                                </div>
                                <div class="input-field col s12">
                                    <?php DynamicFormWidget::begin([
                                        'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                                        'widgetBody' => '.container-items-task', // required: css class selector
                                        'widgetItem' => '.item', // required: css class
                                        'limit' => 4, // the maximum times, an element can be cloned (default 999)
                                        'min' => 1, // 0 or 1 (default 1)
                                        'insertButton' => '.add-item', // css class
                                        'deleteButton' => '.remove-item', // css class
                                        'model' => $milestones[0],
                                        'formId' => 'dynamic-form',
                                        'formFields' => [
                                            'id',
                                            'prix_jalon',
                                            'price',
                                            'delivery_date',
                                            'comments'
                                        ],
                                    ]); ?>

                                    <div class="container-items-task">
                                        <!-- widgetContainer -->
                                        <?php foreach ($milestones as $i => $milestone) : ?>
                                            <div class="item panel panel-default">
                                                <!-- widgetBody -->

                                                <div class="panel-body">
                                                    <?php
                                                    // necessary for update action.
                                                    if (!$milestone->isNewRecord) {
                                                        echo Html::activeHiddenInput($milestone, "[{$i}]id");
                                                    }
                                                    ?>

                                                    <div class="row">
                                                        <div class="col s5">
                                                            <?= $form->field($milestone, "[{$i}]label")->textInput(['autocomplete' => 'off', 'maxlength' => true])->label('Description de la tâche') ?>
                                                        </div>
                                                        <div class="col s1">
                                                            <?= $form->field($milestone, "[{$i}]label")->textInput(['autocomplete' => 'off', 'maxlength' => true])->label('(j) capa') ?>
                                                        </div>
                                                        <div class="col s1">
                                                            <?= $form->field($milestone, "[{$i}]label")->textInput(['autocomplete' => 'off', 'maxlength' => true])->label('(j) labo') ?>
                                                        </div>
                                                        <div class="col s1">
                                                            <?= $form->field($milestone, "[{$i}]label")->textInput(['autocomplete' => 'off', 'maxlength' => true])->label('Prix labo') ?>
                                                        </div>
                                                        <div class="col s1">
                                                            <?= $form->field($milestone, "[{$i}]label")->textInput(['autocomplete' => 'off', 'maxlength' => true])->label('Risque') ?>
                                                        </div>
                                                        <div class="col 1">
                                                            <button type="button" class="add-item waves-effect waves-light btn btn-grey"><i class="glyphicon glyphicon-plus"></i></button>
                                                        </div>
                                                        <div class="col 1">
                                                            <button type="button" class="remove-item waves-effect waves-light btn btn-grey"><i class="glyphicon glyphicon-minus"></i></button>
                                                        </div>
                                                    </div><!-- .row -->

                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>

                                    <?php DynamicFormWidget::end(); ?>
                                </div>
                            </div>
                        </div>

                        <div class="col s12">
                            <div class="row">
                                <div class="input-field col s1 offset-s10">
                                    <?= Html::a('Retour', null, ['id' => 'third-back-link']) ?>
                                </div>


                                <div class="input-field col s1">
                                    <?= Html::a('Suivant', null, ['id' => 'third-next-link']) ?>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </div>

    </div>
    <?php ActiveForm::end(); ?>

</div>
</div>