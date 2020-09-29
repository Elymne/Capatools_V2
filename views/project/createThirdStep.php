<?php

use app\assets\AppAsset;
use app\assets\projects\ProjectCreateThirdStepAsset;
use app\models\projects\Consumable;
use yii\helpers\ArrayHelper;
use app\widgets\TopTitle;
use kartik\select2\Select2;
use kidzen\dynamicform\DynamicFormWidget;
use yii\bootstrap\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap\Alert;

AppAsset::register($this);
ProjectCreateThirdStepAsset::register($this);

// Si le numéro de lot correspondant est le 0, on a affaire à un lot d'avant-projet.
if ($number == 0) $this->title = 'Dépenses et reversements : Avant-projet';
else $this->title = 'Dépenses et reversements : Lot n°' . $number;

// On map les noms des risques sur dans une table utilisable dans la vue.
$risksName = array_map(function ($risk) {
    return $risk->title;
}, $risksData);
?>

<?= TopTitle::widget(['title' => $this->title]) ?>

<?php if ($sucess != null) : ?>
    <?php if ($sucess) :  ?>
        <?= Alert::widget(['options' => ['class' => 'alert-success',], 'body' => 'Enregistrement réussi ...',]) ?>
    <?php else : ?>
        <?= Alert::widget(['options' => ['class' => 'alert-danger',], 'body' => 'Enregistrement échoué ...',]); ?>
    <?php endif; ?>
<?php endif; ?>

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
                                        'widgetContainer' => 'dynamicform_wrapper_consumable', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                                        'widgetBody' => '.container-items-consummable', // required: css class selector
                                        'widgetItem' => '.item-consummable', // required: css class
                                        'limit' => 10, // the maximum times, an element can be cloned (default 999)
                                        'min' => 0, // 0 or 1 (default 1)
                                        'insertButton' => '.add-item', // css class
                                        'deleteButton' => '.remove-item', // css class
                                        'model' => $consumables[0],
                                        'formId' => 'dynamic-form',
                                        'formFields' => ['title', 'price', 'type'],
                                    ]); ?>

                                    <div class="container-items-consummable">

                                        <div class="row">
                                            <div class="col s1 offset-s5">
                                                <button id="button-consummable-first-add" type="button" class="add-item btn waves-effect waves-light btn-grey"><i class="glyphicon glyphicon-plus"></i></button>
                                            </div>
                                        </div>

                                        <!-- widgetContainer -->
                                        <?php foreach ($consumables as $i => $consumable) : ?>
                                            <div class="item-consummable">

                                                <?php if (!$consumable->isNewRecord) : ?>
                                                    <?= Html::activeHiddenInput($consumable, "[{$i}]id") ?>
                                                <?php endif; ?>

                                                <div class="row">
                                                    <div class="col s4">
                                                        <?= $form->field($consumable, "[{$i}]title")->textInput(['autocomplete' => 'off', 'maxlength' => true])->label("Description") ?>
                                                    </div>
                                                    <div class="col s2">
                                                        <?= $form->field($consumable, "[{$i}]price")->input('number', ['min' => 0, 'max' => 10000, 'step' => 1])->label("Prix HT") ?>
                                                    </div>
                                                    <div class="col s4">
                                                        <?= $form->field($consumable, "[{$i}]type")->widget(Select2::class, [
                                                            'data' => Consumable::TYPES,
                                                            'options' => ['value' => $consumable->getSelectedType()],
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

                    <?php if ($number != 0) : ?>
                        <div class="card-action" id="card-invest-plus">

                            <!-- Création dépense , d'investissements -->
                            <label id="invtest-management-label" class='blue-text control-label typeLabel'>Liste des achats d'investissement éventuels</label>
                            <div id="invtest-management-body" class="col s12">
                                <div class="row">
                                    <div class="input-field col s12">

                                        <?php DynamicFormWidget::begin([
                                            'widgetContainer' => 'dynamicform_wrapper_invtest', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                                            'widgetBody' => '.container-items-invtest', // required: css class selector
                                            'widgetItem' => '.item-invtest', // required: css class
                                            'limit' => 10, // the maximum times, an element can be cloned (default 999)
                                            'min' => 0, // 0 or 1 (default 1)
                                            'insertButton' => '.add-item', // css class
                                            'deleteButton' => '.remove-item', // css class
                                            'model' => $invests[0],
                                            'formId' => 'dynamic-form',
                                            'formFields' => ['title', 'price'],
                                        ]); ?>

                                        <div class="container-items-invtest">

                                            <div class="row">
                                                <div class="col s1 offset-s5">
                                                    <button id="button-invests-first-add" type="button" class="add-item btn waves-effect waves-light btn-grey"><i class="glyphicon glyphicon-plus"></i></button>
                                                </div>
                                            </div>

                                            <?php foreach ($invests as $i => $invtest) : ?>
                                                <div class="item-invtest">
                                                    <?php if (!$invtest->isNewRecord) : ?>
                                                        <?= Html::activeHiddenInput($invtest, "[{$i}]id") ?>
                                                    <?php endif; ?>
                                                    <div class="row">

                                                        <div class="col s4">
                                                            <?= $form->field($invtest, "[{$i}]name")->textInput(['autocomplete' => 'off', 'maxlength' => true])->label("Description") ?>
                                                        </div>
                                                        <div class="col s2">
                                                            <?= $form->field($invtest, "[{$i}]price")->input('number', ['min' => 0, 'max' => 10000, 'step' => 1])->label("Prix HT") ?>
                                                        </div>
                                                        <div class="col 1">
                                                            <button type="button" class="add-item btn-floating waves-effect waves-light btn-grey"><i class="glyphicon glyphicon-plus"></i></button>
                                                        </div>
                                                        <div class="col 1">
                                                            <button type="button" class="remove-item btn-floating waves-effect waves-light btn-grey"><i class="glyphicon glyphicon-minus"></i></button>
                                                        </div>

                                                    </div><!-- .row -->
                                                </div><!-- .item -->
                                            <?php endforeach; ?>
                                        </div><!-- .container -->

                                        <?php DynamicFormWidget::end(); ?>

                                    </div>
                                </div>
                            </div>

                        </div>
                    <?php endif; ?>

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
                                    <?= $form->field($model, "laboratoryselected")->widget(Select2::class, [
                                        'data' => ArrayHelper::map($laboratoriesData, 'id', 'name'),
                                        'options' => ['value' => $model->laboratoryselected],
                                        'pluginLoading' => false,
                                        'pluginOptions' => [],
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
                                        'min' => 0, // 0 or 1 (default 1)
                                        'insertButton' => '.add-item', // css class
                                        'deleteButton' => '.remove-item', // css class
                                        'model' => $equipments[0],
                                        'formId' => 'dynamic-form',
                                        'formFields' => ['equipmentSelected', 'nb_days', 'nb_hours', 'price', 'riskSelected', 'timeRiskStringify'],
                                    ]); ?>

                                    <div class="container-items-equipment">

                                        <div class="row">
                                            <div class="col s1 offset-s5">
                                                <button id="button-equipment-first-add" type="button" class="add-item btn waves-effect waves-light btn-grey"><i class="glyphicon glyphicon-plus"></i></button>
                                            </div>
                                        </div>

                                        <!-- widgetContainer -->
                                        <?php foreach ($equipments as $i => $equipment) : ?>
                                            <div class="item-equipment">
                                                <?php if (!$equipment->isNewRecord) : ?>
                                                    <?= Html::activeHiddenInput($equipment, "[{$i}]id"); ?>
                                                <?php endif; ?>
                                                <div class="row">
                                                    <div class="col s2">
                                                        <?= $form->field($equipment, "[{$i}]name")->textInput([])->label("Description") ?>
                                                    </div>
                                                    <div class="col s1">
                                                        <?= $form->field($equipment, "[{$i}]daily_price")->input('number', ['min' => 0, 'max' => 10000, 'step' => 1])->label("Prix") ?>
                                                    </div>
                                                    <div class="col s1">
                                                        <?= $form->field($equipment, "[{$i}]nb_days")->input('number', ['min' => 0, 'max' => 10000, 'step' => 1])->label("Jour(s)") ?>
                                                    </div>
                                                    <div class="col s1">
                                                        <?= $form->field($equipment, "[{$i}]nb_hours")->input('number', ['min' => 0, 'max' => 10000, 'step' => 1])->label("Heure(s)") ?>
                                                    </div>
                                                    <div class="col s2 equipment_risk">
                                                        <!-- type dropdown field -->
                                                        <?= $form->field($equipment, "[{$i}]riskSelected")->widget(Select2::class, [
                                                            'data' => array_map(function ($risk) {
                                                                return $risk->title;
                                                            }, $risksData),
                                                            'options' => ['value' => $equipment->riskSelected],
                                                            'pluginLoading' => false,
                                                            'pluginOptions' => [],
                                                        ])->label("Incertitude"); ?>
                                                    </div>
                                                    <div class="col s2">
                                                        <?= $form->field($equipment, "[{$i}]timeRiskStringify")->textInput(['readonly' => true])->label("Temps incertitude") ?>
                                                    </div>
                                                    <div class="col s1">
                                                        <?= $form->field($equipment, "[{$i}]price")->textInput(['readonly' => true])->label("Prix total") ?>
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
                                        'min' => 0, // 0 or 1 (default 1)
                                        'insertButton' => '.add-item', // css class
                                        'deleteButton' => '.remove-item', // css class
                                        'model' => $contributors[0],
                                        'formId' => 'dynamic-form',
                                        'formFields' => ['name', 'daily_price', 'nb_days', 'nb_hours', 'price', 'riskSelected', 'timeRiskStringify'],
                                    ]); ?>

                                    <div class="container-items-labocontributor">

                                        <div class="row">
                                            <div class="col s1 offset-s5">
                                                <button id="button-labocontributor-first-add" type="button" class="add-item btn waves-effect waves-light btn-grey"><i class="glyphicon glyphicon-plus"></i></button>
                                            </div>
                                        </div>

                                        <!-- widgetContainer -->
                                        <?php foreach ($contributors as $i => $contributor) : ?>
                                            <div class="item-labocontributor">
                                                <?php if (!$contributor->isNewRecord) : ?>
                                                    <?= Html::activeHiddenInput($contributor, "[{$i}]id"); ?>
                                                <?php endif; ?>
                                                <div class="row">
                                                    <div class="col s2">
                                                        <?= $form->field($contributor, "[{$i}]name")->textInput()->label("Desc. Intervenant") ?>
                                                    </div>
                                                    <div class="col s1">
                                                        <?= $form->field($contributor, "[{$i}]daily_price")->input('number', ['min' => 0, 'max' => 10000, 'step' => 1])->label("Prix") ?>
                                                    </div>
                                                    <div class="col s1">
                                                        <?= $form->field($contributor, "[{$i}]nb_days")->input('number', ['min' => 0, 'max' => 10000, 'step' => 1])->label("Jour(s)") ?>
                                                    </div>
                                                    <div class="col s1">
                                                        <?= $form->field($contributor, "[{$i}]nb_hours")->input('number', ['min' => 0, 'max' => 10000, 'step' => 1])->label("Heure(s)") ?>
                                                    </div>
                                                    <div class="col s2 contributor_risk">
                                                        <!-- type dropdown field -->
                                                        <?= $form->field($contributor, "[{$i}]riskSelected")->widget(Select2::class, [
                                                            'data' => $risksName,
                                                            'options' => ['value' => $contributor->riskSelected],
                                                            'pluginLoading' => false,
                                                            'pluginOptions' => [],
                                                        ])->label("Incertitude"); ?>
                                                    </div>
                                                    <div class="col s2">
                                                        <?= $form->field($contributor, "[{$i}]timeRiskStringify")->textInput(['readonly' => true])->label("Temps incertitude") ?>
                                                    </div>
                                                    <div class="col s1">
                                                        <?= $form->field($contributor, "[{$i}]price")->input('number', ['min' => 0, 'max' => 10000, 'step' => 1, 'readonly' => true])->label("Prix total") ?>
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

                <div class="form-group">
                    <div style="bottom: 50px; right: 25px;" class="fixed-action-btn direction-top">
                        <?= Html::a(
                            Yii::t('app', '<i class="material-icons right">arrow_back</i>'),
                            ['project/project-simulate?project_id=' . $project_id],
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

    // Transformation des données equipmentRepayment sous format JSON.
    $equipmentsToJson = [];
    if ($equipments != null)
        $equipmentsToJson = array_map(function ($data) {
            return $data->jsonSerialize();
        }, $equipments);

    // Transformation des données LaboratoryCOntributor sous format JSON.
    $contributorsToJson = [];
    if ($contributors != null)
        $contributorsToJson = array_map(function ($data) {
            return $data->jsonSerialize();
        }, $contributors);

    // Transformation des données consummables.
    $consummablesToJson = [];
    if ($consumables != null)
        $consummablesToJson = array_map(function ($data) {
            return $data->jsonSerialize();
        }, $consumables);

    // Transformation des données consummables.
    $investsToJson = [];
    if ($invests != null)
        $investsToJson = array_map(function ($data) {
            return $data->jsonSerialize();
        }, $invests);

    $lotnb = json_encode($number);

    // Envoi de données.
    echo json_encode([
        // Récupération du laboratoire sélectionné.
        'laboratorySelected' => $model->laboratoryselected,

        'equipments' => $equipmentsToJson,
        'contributors' => $contributorsToJson,
        'consummables' => $consummablesToJson,
        'invests' => $investsToJson,

        'number' => $lotnb,
    ]);
    ?>
</div>