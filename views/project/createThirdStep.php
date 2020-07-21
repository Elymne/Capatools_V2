<?php

use app\assets\AppAsset;
use app\assets\projects\ProjectCreateThirdStepAsset;

use app\models\equipments\EquipmentRepayment;
use app\models\laboratories\LaboratoryContributor;
use app\models\projects\Consumable;

use app\widgets\TopTitle;
use kartik\select2\Select2;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\bootstrap\Html;
use yii\widgets\ActiveForm;

if ($number == 0) $this->title = 'Création d\'un projet - liste des dépenses et reversements : Avant-projet';
else $this->title = 'Création d\'un projet - liste des dépenses et reversements : Lot n°' . $number;

AppAsset::register($this);
ProjectCreateThirdStepAsset::register($this);

?>

<?= TopTitle::widget(['title' => $this->title]) ?>
<div class="container">
    <div class="project-create">
        <?php $form = ActiveForm::begin(['id' => 'dynamic-form', 'options' => ['enctype' => 'multipart/form-data']]); ?>
        <div class="row">
            <div class="col s12">

                <!-- Card : Gestion des consonmmables -->
                <div class="card">

                    <div class="card-content">
                        <label>Dépenses</label>
                    </div>

                    <div class="card-action">

                        <!-- Création de consommables -->
                        <label id="consumable-management-label" class='blue-text control-label typeLabel'>Consommables, prestataires, déplacements...</label>
                        <div id="consumable-management-body" class="col s12">
                            <div class="row">
                                <div class="input-field col s12">

                                    <?php DynamicFormWidget::begin([
                                        'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                                        'widgetBody' => '.container-items-consummable', // required: css class selector
                                        'widgetItem' => '.item-consummable', // required: css class
                                        'limit' => 10, // the maximum times, an element can be cloned (default 999)
                                        'min' => 1, // 0 or 1 (default 1)
                                        'insertButton' => '.add-item', // css class
                                        'deleteButton' => '.remove-item', // css class
                                        'model' => $consumables[0],
                                        'formId' => 'dynamic-form',
                                        'formFields' => ['title', 'price', 'type'],
                                    ]); ?>

                                    <div class="container-items-consummable">
                                        <!-- widgetContainer -->
                                        <?php foreach ($consumables as $i => $consumable) : ?>
                                            <div class="item-consummable">
                                                <?php
                                                // necessary for update action.
                                                if (!$consumable->isNewRecord) {
                                                    echo Html::activeHiddenInput($lot, "[{$i}]id");
                                                }
                                                ?>
                                                <div class="row">
                                                    <div class="col s4">
                                                        <?= $form->field($consumable, "[{$i}]title")->textInput(['autocomplete' => 'off', 'maxlength' => true])->label("Description") ?>
                                                    </div>
                                                    <div class="col s2">
                                                        <?= $form->field($consumable, "[{$i}]price")->input('number', ['min' => 0, 'max' => 10000, 'step' => 1])->label("Prix HT") ?>
                                                    </div>
                                                    <div class="col s4">
                                                        <!-- type dropdown field -->
                                                        <?= $form->field($consumable, "[{$i}]type")->widget(Select2::classname(), [
                                                            'data' => Consumable::TYPES,
                                                            'options' => ['value' => 0],
                                                            'pluginLoading' => false,
                                                            'pluginOptions' => [
                                                                'allowClear' => false
                                                            ],
                                                        ])->label(
                                                            "Type"
                                                        ); ?>
                                                    </div>
                                                    <div class="col 1">
                                                        <button type="button" class="add-item btn-floating waves-effect waves-light btn-grey"><i class="glyphicon glyphicon-plus"></i></button>
                                                    </div>
                                                    <div class="col 1">
                                                        <button type="button" class="remove-item btn-floating waves-effect waves-light btn-grey"><i class="glyphicon glyphicon-minus"></i></button>
                                                    </div>
                                                </div><!-- .row -->
                                            </div>
                                        <?php endforeach; ?>
                                    </div>

                                    <?php DynamicFormWidget::end(); ?>

                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="card-action">

                        <!-- Création dépense , d'investissements -->
                        <label id="expense-management-label" class='blue-text control-label typeLabel'>Liste des achats d'investissement éventuels</label>
                        <div id="expense-management-body" class="col s12">
                            <div class="row">
                                <div class="input-field col s12">

                                    <?php DynamicFormWidget::begin([
                                        'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                                        'widgetBody' => '.container-items-expense', // required: css class selector
                                        'widgetItem' => '.item-expense', // required: css class
                                        'limit' => 10, // the maximum times, an element can be cloned (default 999)
                                        'min' => 1, // 0 or 1 (default 1)
                                        'insertButton' => '.add-item', // css class
                                        'deleteButton' => '.remove-item', // css class
                                        'model' => $expenses[0],
                                        'formId' => 'dynamic-form',
                                        'formFields' => ['title', 'price'],
                                    ]); ?>

                                    <div class="container-items-expense">
                                        <!-- widgetContainer -->
                                        <?php foreach ($expenses as $i => $expense) : ?>
                                            <div class="item-expense">
                                                <?php
                                                // necessary for update action.
                                                if (!$expense->isNewRecord) {
                                                    echo Html::activeHiddenInput($lot, "[{$i}]id");
                                                }
                                                ?>
                                                <div class="row">
                                                    <div class="col s4">
                                                        <?= $form->field($expense, "[{$i}]title")->textInput(['autocomplete' => 'off', 'maxlength' => true])->label("Description") ?>
                                                    </div>
                                                    <div class="col s2">
                                                        <?= $form->field($expense, "[{$i}]price")->input('number', ['min' => 0, 'max' => 10000, 'step' => 1])->label("Prix HT") ?>
                                                    </div>
                                                    <div class="col 1">
                                                        <button type="button" class="add-item btn-floating waves-effect waves-light btn-grey"><i class="glyphicon glyphicon-plus"></i></button>
                                                    </div>
                                                    <div class="col 1">
                                                        <button type="button" class="remove-item btn-floating waves-effect waves-light btn-grey"><i class="glyphicon glyphicon-minus"></i></button>
                                                    </div>
                                                </div><!-- .row -->
                                            </div>
                                        <?php endforeach; ?>
                                    </div>

                                    <?php DynamicFormWidget::end(); ?>

                                </div>
                            </div>
                        </div>

                    </div>

                </div>

                <!-- Card : Gestion des reversements -->
                <div class="card">

                    <div class="card-content">
                        <label>Reversements Labo</label>
                    </div>

                    <div class="card-action">
                        <!-- Sélection d'un laboratoire -->
                        <label id="laboratory-management-label" class='blue-text control-label typeLabel'>Laboratoire</label>
                        <div id="laboratory-management-body" class="col s12">
                            <div class="row">
                                <div class="input-field col s4">

                                    <!-- type dropdown field -->
                                    <?= $form->field($repayment, "laboratorySelected")->widget(Select2::classname(), [
                                        'data' => array_map(function ($data) {
                                            return $data->name;
                                        }, $laboratoriesData),
                                        'options' => ['value' => 0],
                                        'pluginLoading' => false,
                                        'pluginOptions' => [
                                            'allowClear' => true
                                        ],
                                    ])->label(false); ?>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-action">
                        <!-- Association de matériels au reversement labo -->
                        <label id="equipment-management-label" class='blue-text control-label typeLabel'>Matériel utilisé</label>
                        <div id="equipment-management-body" class="col s12">
                            <div class="row">
                                <div class="input-field col s12">

                                    <?php DynamicFormWidget::begin([
                                        'widgetContainer' => 'dynamicform_wrapper_equipment', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                                        'widgetBody' => '.container-items-equipment', // required: css class selector
                                        'widgetItem' => '.item-equipment', // required: css class
                                        'limit' => 10, // the maximum times, an element can be cloned (default 999)
                                        'min' => 1, // 0 or 1 (default 1)
                                        'insertButton' => '.add-item', // css class
                                        'deleteButton' => '.remove-item', // css class
                                        'model' => $equipments[0],
                                        'formId' => 'dynamic-form',
                                        'formFields' => ['equipmentSelected', 'nb_days', 'nb_hours', 'price', 'riskSelected', 'timeRiskStringify'],
                                    ]); ?>

                                    <div class="container-items-equipment">
                                        <!-- widgetContainer -->
                                        <?php foreach ($equipments as $i => $equipment) : ?>
                                            <div class="item-equipment">
                                                <?php
                                                // necessary for update action.
                                                if (!$equipment->isNewRecord) {
                                                    echo Html::activeHiddenInput($lot, "[{$i}]id");
                                                }
                                                ?>
                                                <div class="row">
                                                    <div class="col s2">
                                                        <!-- type dropdown field -->
                                                        <?= $form->field($equipment, "[{$i}]equipmentSelected")->widget(Select2::classname(), [
                                                            'data' => array_map(function ($data) {
                                                                return $data->name;
                                                            }, $equipmentsData),
                                                            'options' => ['value' => 0],
                                                            'pluginLoading' => false,
                                                            'pluginOptions' => [],
                                                        ])->label("Matériel "); ?>
                                                    </div>

                                                    <div class="col s1">
                                                        <?= $form->field($equipment, "[{$i}]price")->textInput(['readonly' => true])->label("Coût") ?>
                                                    </div>
                                                    <div class="col s1">
                                                        <?= $form->field($equipment, "[{$i}]nb_days")->input('number', ['min' => 0, 'max' => 10000, 'step' => 1])->label("Jour(s)") ?>
                                                    </div>
                                                    <div class="col s1">
                                                        <?= $form->field($equipment, "[{$i}]nb_hours")->input('number', ['min' => 0, 'max' => 10000, 'step' => 1])->label("Heure(s)") ?>
                                                    </div>
                                                    <?php
                                                    if ($number != 0) { ?>

                                                        <div class="col s2">
                                                            <!-- type dropdown field -->
                                                            <?= $form->field($equipment, "[{$i}]riskSelected")->widget(Select2::classname(), [
                                                                'data' => array_map(function ($risk) {
                                                                    return $risk->title;
                                                                }, $risksData),
                                                                'options' => ['value' => 0],
                                                                'pluginLoading' => false,
                                                                'pluginOptions' => [],
                                                            ])->label("Incertitude"); ?>
                                                        </div>
                                                    <?php } else { ?>

                                                        <div class="col s0">
                                                            <?= $form->field($equipment, "[{$i}]riskSelected")->hiddeninput(['value' => 0])->label(''); ?>

                                                        </div>
                                                    <?php }
                                                    ?>
                                                    <div class="col s2">
                                                        <?= $form->field($equipment, "[{$i}]timeRiskStringify")->textInput(['readonly' => true])->label("Temps incertitude") ?>
                                                    </div>
                                                    <div class="col 1">
                                                        <button type="button" class="add-item btn-floating waves-effect waves-light btn-grey"><i class="glyphicon glyphicon-plus"></i></button>
                                                    </div>
                                                    <div class="col 1">
                                                        <button type="button" class="remove-item btn-floating waves-effect waves-light btn-grey"><i class="glyphicon glyphicon-minus"></i></button>
                                                    </div>
                                                </div><!-- .row -->
                                            </div>
                                        <?php endforeach; ?>
                                    </div>

                                    <?php DynamicFormWidget::end(); ?>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-action">
                        <!-- Gestion temps humain - reversement labo -->
                        <label id="labocontributor-management-label" class='blue-text control-label typeLabel'>Temps humain</label>
                        <div id="labocontributor-management-body" class="col s12">
                            <div class="row">
                                <div class="input-field col s12">

                                    <?php DynamicFormWidget::begin([
                                        'widgetContainer' => 'dynamicform_wrapper_contributor', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                                        'widgetBody' => '.container-items-labocontributor', // required: css class selector
                                        'widgetItem' => '.item-labocontributor', // required: css class
                                        'limit' => 10, // the maximum times, an element can be cloned (default 999)
                                        'min' => 1, // 0 or 1 (default 1)
                                        'insertButton' => '.add-item', // css class
                                        'deleteButton' => '.remove-item', // css class
                                        'model' => $contributors[0],
                                        'formId' => 'dynamic-form',
                                        'formFields' => ['type', 'nb_days', 'nb_hours', 'price', 'riskSelected', 'timeRiskStringify'],
                                    ]); ?>

                                    <div class="container-items-labocontributor">
                                        <!-- widgetContainer -->
                                        <?php foreach ($contributors as $i => $contributor) : ?>
                                            <div class="item-labocontributor">
                                                <?php
                                                // necessary for update action.
                                                if (!$contributor->isNewRecord) {
                                                    echo Html::activeHiddenInput($lot, "[{$i}]id");
                                                }
                                                ?>
                                                <div class="row">
                                                    <div class="col s2">
                                                        <!-- type dropdown field -->
                                                        <?= $form->field($contributor, "[{$i}]type")->widget(Select2::classname(), [
                                                            'data' => LaboratoryContributor::TYPES,
                                                            'options' => ['value' => 0],
                                                            'pluginLoading' => false,
                                                            'pluginOptions' => [],
                                                        ])->label("Intervenant "); ?>
                                                    </div>
                                                    <div class="col s1">
                                                        <?= $form->field($contributor, "[{$i}]price")->input('number', ['min' => 0, 'max' => 10000, 'step' => 1, 'readonly' => true])->label("Coût") ?>
                                                    </div>
                                                    <div class="col s1">
                                                        <?= $form->field($contributor, "[{$i}]nb_days")->input('number', ['min' => 0, 'max' => 10000, 'step' => 1])->label("Jour(s)") ?>
                                                    </div>
                                                    <div class="col s1">
                                                        <?= $form->field($contributor, "[{$i}]nb_hours")->input('number', ['min' => 0, 'max' => 10000, 'step' => 1])->label("Heure(s)") ?>
                                                    </div>

                                                    <?php
                                                    if ($number != 0) { ?>
                                                        <div class="col s2">
                                                            <!-- type dropdown field -->
                                                            <?= $form->field($contributor, "[{$i}]riskSelected")->widget(Select2::classname(), [
                                                                'data' => array_map(function ($risk) {
                                                                    return $risk->title;
                                                                }, $risksData),
                                                                'options' => ['value' => 0],
                                                                'pluginLoading' => false,
                                                                'pluginOptions' => [
                                                                    'allowClear' => true
                                                                ],
                                                            ])->label("Incertitude"); ?>
                                                        </div>
                                                    <?php } else { ?>

                                                        <div class="col s0">
                                                            <?= $form->field($contributor, "[{$i}]riskSelected")->hiddeninput(['value' => 0])->label(''); ?>

                                                        </div>
                                                    <?php }
                                                    ?>
                                                    <div class="col s2">
                                                        <?= $form->field($contributor, "[{$i}]timeRiskStringify")->textInput(['readonly' => true])->label("Temps incertitude") ?>
                                                    </div>
                                                    <div class="col 1">
                                                        <button type="button" class="add-item btn-floating waves-effect waves-light btn-grey"><i class="glyphicon glyphicon-plus"></i></button>
                                                    </div>
                                                    <div class="col 1">
                                                        <button type="button" class="remove-item btn-floating waves-effect waves-light btn-grey"><i class="glyphicon glyphicon-minus"></i></button>
                                                    </div>
                                                </div><!-- .row -->
                                            </div>
                                        <?php endforeach; ?>
                                    </div>

                                    <?php DynamicFormWidget::end(); ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-action">
                        <!-- Buttons -->
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



<!-- Utilisation : envoi de données concernant les laboratoires. -->
<div id="laboratories-data-target" style="display: none;">
    <?php
    // Transformation des données sous format JSON.
    $ld = array_map(function ($data) {
        return $data->jsonSerialize();
    }, $laboratoriesData);
    // Envoi de données.
    echo json_encode($ld);
    ?>
</div>

<!-- Utilisation : envoi de données concernant les équipements/matériel. -->
<div id="equipments-data-target" style="display: none;">
    <?php
    // Transformation des données sous format JSON.
    $ed = array_map(function ($data) {
        return $data->jsonSerialize();
    }, $equipmentsData);
    // Envoi de données.
    echo json_encode($ed);
    ?>
</div>

<!-- Utilisation : envoi de données concernant les incertitudes/risques. -->
<div id="risks-data-target" style="display: none;">
    <?php
    // Transformation des données sous format JSON.
    $rd = array_map(function ($data) {
        return $data->jsonSerialize();
    }, $risksData);
    // Envoi de données.
    echo json_encode($rd);
    ?>
</div>

<!-- Informations relatives aux données présentes. -->
<div id="info-data-target" style="display: none;">
    <?php

    // Transformation des données sous format JSON.
    $ided = array_map(function ($data) {
        return $data->jsonSerialize();
    }, $equipments);

    // Transformation des données sous format JSON.
    $idcd = array_map(function ($data) {
        return $data->jsonSerialize();
    }, $contributors);

    // Envoi de données.
    echo json_encode([
        'laboratorySelected' => $repayment->laboratory_id,
        'equipments' => $ided,
        'contributors' => $idcd,
    ]);
    ?>
</div>