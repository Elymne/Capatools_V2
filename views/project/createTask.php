<?php

use app\assets\AppAsset;
use app\assets\projects\ProjectCreateTaskAsset;
use app\widgets\TopTitle;
use kartik\select2\Select2;
use kidzen\dynamicform\DynamicFormWidget;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Alert;

AppAsset::register($this);
ProjectCreateTaskAsset::register($this);

// todo résoudre le problème de div (il en manque surement un quelques part)

$this->title = 'Tâches';
$lot = $model->GetCurrentLot();
$hide = false;
if ($lot->number != 0) {
    $this->title = $this->title  . " pour le lot " . $lot->title;
} else {
    $this->title = $this->title  . " d'avant projet";
    $hide = true;
}
?>

<?= TopTitle::widget(['title' => $this->title]) ?>
<?php if ($SaveSucess != null) : ?>
    <?php if ($SaveSucess) : ?>
        <?= Alert::widget(['options' => ['class' => 'alert-success',], 'body' => 'Enregistrement réussi ...']); ?>
    <?php else : ?>
        <?= Alert::widget(['options' => ['class' => 'alert-danger',], 'body' => 'Enregistrement échoué ...']); ?>
    <?php endif; ?>
<?php endif; ?>

<div class="container">
    <div class="project-create">
        <?php $form = ActiveForm::begin(['id' => 'dynamic-form', 'options' => ['enctype' => 'multipart/form-data']]); ?>
        <?= Html::activeHiddenInput($model, 'valid') ?>
        <div class="row">
            <div class="col s12">
                <!-- Card view basique -->
                <div class="card">
                    <div class="card-content">
                        <label> <?= $this->title ?></label>
                    </div>
                    <?php if ($lot->number != 0) : ?>
                        <div class="card-action">
                            <!-- Liste de tâche de gestion de projet du lot  -->
                            <label class='control-label dynamic-form-label'>Tâche de gestion du projet du lot</label>
                            <div id="taskGestion-management-body" class="col s12">
                                <div class="row">
                                    <div class="input-field col s12">
                                        <?php DynamicFormWidget::begin([
                                            'widgetContainer' => 'dynamicform_wrapperGest', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                                            'widgetBody' => '.container-items-taskGestion', // required: css class selector
                                            'widgetItem' => '.item-taskGestion', // required: css class
                                            'limit' => 10, // the maximum times, an element can be cloned (default 999)
                                            'min' => 0, // 0 or 1 (default 1)
                                            'insertButton' => '.add-item-taskGestion', // css class
                                            'deleteButton' => '.remove-item-taskGestion', // css class
                                            'model' => $tasksGestions[0],
                                            'formId' => 'dynamic-form',
                                            'formFields' => [
                                                'number',
                                                'title',
                                                'contributor',
                                                'price',
                                                'day_duration',
                                                'hour_duration',
                                                'risk',
                                                'risk_duration',
                                                'totalprice',
                                            ],
                                        ]); ?>
                                        <div class="container-items-taskGestion">

                                            <div id="taskGestion-label-block" class="row" style="display: none;">
                                                <div class="col s2">
                                                    <label>Description</label>
                                                </div>
                                                <div class="col s2">
                                                    <label>Intervenant</label>
                                                </div>
                                                <div class="col s1">
                                                    <label>Prix/jour</label>
                                                </div>
                                                <div class="col s1">
                                                    <label>Jour</label>
                                                </div>
                                                <div class="col s1">
                                                    <label>Heure</label>
                                                </div>
                                                <div class="col s2">
                                                    <label>Incertitude</label>
                                                </div>
                                                <div class="col s1">
                                                    <label>Temps total</label>
                                                </div>
                                                <div class="col s1">
                                                    <label>Prix total</label>
                                                </div>
                                            </div>
                                            <!-- widgetContainer -->
                                            <?php foreach ($tasksGestions as $i => $taskGestion) : ?>
                                                <div class="item-taskGestion">
                                                    <div class="card">
                                                        <div class="card-item">
                                                            <?= Html::activeHiddenInput($taskGestion, "[{$i}]number"); ?>
                                                            <div class="row">
                                                                <div class="col s2">
                                                                    <?= $form->field($taskGestion, "[{$i}]title")->textInput(['autocomplete' => 'off', 'maxlength' => true, 'placeholder' => 'Description'])->label(false) ?>
                                                                </div>
                                                                <div class="col s2">
                                                                    <?= $form->field($taskGestion, "[{$i}]capa_user_id")->widget(
                                                                        Select2::class,
                                                                        [
                                                                            'theme' => Select2::THEME_MATERIAL,
                                                                            'name' => 'GestionContributor',
                                                                            'data' => ArrayHelper::map($celluleUsers, 'id', 'fullName'),
                                                                            'pluginLoading' => false,
                                                                            "theme" => Select2::THEME_MATERIAL,
                                                                            'options' => [
                                                                                'placeholder' => 'Intervenant...',
                                                                            ],
                                                                            'pluginEvents' => [
                                                                                'select2:select' => 'function(e) { OnCalculIntervenantGest(0);}',
                                                                            ],
                                                                        ]
                                                                    )->label(false);
                                                                    ?>
                                                                </div>
                                                                <div class="col s1">
                                                                    <?= $form->field($taskGestion, "[{$i}]price")->textInput(['readonly' => true, 'autocomplete' => 'off', 'maxlength' => true, 'placeholder' => 'Prix/jour'])->label(false) ?>
                                                                </div>
                                                                <div class="col s1">
                                                                    <?= $form->field($taskGestion, "[{$i}]day_duration")->textInput(['type' => 'number', 'min' => 0, 'autocomplete' => 'off', 'maxlength' => true, 'placeholder' => 'Jour'])->label(false) ?>
                                                                </div>
                                                                <div class="col s1">
                                                                    <?= $form->field($taskGestion, "[{$i}]hour_duration")->textInput(['type' => 'number', 'min' => 0, 'autocomplete' => 'off', 'maxlength' => true, 'placeholder' => 'Heure'])->label(false) ?>
                                                                </div>
                                                                <div class="col s2">
                                                                    <?= $form->field($taskGestion, "[{$i}]risk")->widget(
                                                                        Select2::class,
                                                                        [
                                                                            //'theme' => Select2::THEME_MATERIAL,
                                                                            'name' => 'GestionRisk',
                                                                            'data' => ArrayHelper::map($risk, 'id', 'title'),
                                                                            'value' => $tasksGestions[$i]->risk,
                                                                            'pluginLoading' => false,
                                                                            "theme" => Select2::THEME_MATERIAL,
                                                                            'pluginEvents' => [
                                                                                'select2:select' => 'function(e) {OnCalculIncertitudeGest(0);}',
                                                                            ],
                                                                        ]
                                                                    )->label(false);
                                                                    ?>
                                                                </div>
                                                                <div class="col s1">
                                                                    <?= $form->field($taskGestion, "[{$i}]risk_duration")->textInput(['readonly' => true, 'autocomplete' => 'off', 'maxlength' => true, 'placeholder' => 'Temps total'])->label(false) ?>
                                                                </div>
                                                                <div class="col s1">
                                                                    <?= $form->field($taskGestion, "[{$i}]totalprice")->textInput(['readonly' => true, 'autocomplete' => 'off', 'maxlength' => true, 'placeholder' => 'Prix total'])->label(false) ?>
                                                                </div>
                                                                <div class="col 1">
                                                                    <button type="button" class="remove-item-taskGestion btn-flat remove-item-button-type"><i class="glyphicon glyphicon-trash"></i></button>
                                                                </div>
                                                            </div><!-- .row -->
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                        <div class="col s12">
                                            <p class="add-item-taskGestion add-item-link-type">Ajouter une nouvelle tâche de gestion</p>
                                        </div>
                                        <?php DynamicFormWidget::end(); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="card-action">
                        <?php if ($lot->number != 0) : ?>
                            <label class='control-label dynamic-form-label'>Tâche du lot</label>
                        <?php else : ?>
                            <label class='control-label dynamic-form-label'>Tâche d'avant projet</label>
                        <?php endif; ?>
                        <div id="lot-management-body" class="col s12">
                            <div class="row">
                                <div class="input-field col s12">
                                    <?php DynamicFormWidget::begin([
                                        'widgetContainer' => 'dynamicform_wrapperLot', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                                        'widgetBody' => '.container-items-taskLot', // required: css class selector
                                        'widgetItem' => '.item-taskLot', // required: css class
                                        'limit' => 10, // the maximum times, an element can be cloned (default 999)
                                        'min' => 1, // 0 or 1 (default 1)
                                        'insertButton' => '.add-item-taskLot', // css class
                                        'deleteButton' => '.remove-item-taskLot', // css class
                                        'model' => $tasksOperational[0],
                                        'formId' => 'dynamic-form',
                                        'formFields' => [
                                            'id',
                                            'number',
                                            'title',
                                            'contributor',
                                            'price',
                                            'day_duration',
                                            'hour_duration',
                                            'risk',
                                            'risk_duration_hour',
                                            'totalprice',
                                        ],
                                    ]); ?>
                                    <div class="container-items-taskLot">
                                        <div id="taskLot-label-block" class="row">
                                            <div class=" col s2">
                                                <label>Description</label>
                                            </div>
                                            <div class="col s2">
                                                <label>Intervenant</label>
                                            </div>
                                            <div class="col s1">
                                                <label>Prix journalier</label>
                                            </div>
                                            <div class="col s1">
                                                <label>Jour(s)</label>
                                            </div>
                                            <div class="col s1">
                                                <label>Heure(s)</label>
                                            </div>
                                            <?php if (!$hide) : ?>
                                                <div class="col s2">
                                                    <label>Incertitude</label>
                                                </div>
                                            <?php endif; ?>
                                            <div class="col s1">
                                                <label>Temps total</label>
                                            </div>
                                            <div class="col s1">
                                                <label>Prix total</label>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- widgetContainer -->
                                    <?php foreach ($tasksOperational as $i => $taskOperational) : ?>
                                        <div class=" item-taskLot">
                                            <div class="card">
                                                <div class="card-item">
                                                    <?= Html::activeHiddenInput($taskOperational, "[{$i}]id"); ?>
                                                    <?= Html::activeHiddenInput($taskOperational, "[{$i}]number"); ?>
                                                    <div class="row">
                                                        <div class="col s2">
                                                            <?= $form->field($taskOperational, "[{$i}]title")->textInput(['autocomplete' => 'off', 'maxlength' => true])->label(false) ?>
                                                        </div>
                                                        <div class="col s2">
                                                            <?= $form->field($taskOperational, "[{$i}]capa_user_id")->widget(
                                                                Select2::class,
                                                                [
                                                                    'theme' => Select2::THEME_MATERIAL,
                                                                    'name' => 'TaskContributor',
                                                                    'data' => ArrayHelper::map($celluleUsers, 'id', 'fullName'),
                                                                    'pluginLoading' => false,
                                                                    "theme" => Select2::THEME_MATERIAL,
                                                                    'options' => [
                                                                        'placeholder' => 'Intervenant...',
                                                                    ],
                                                                    'pluginEvents' => [
                                                                        'select2:select' => 'function(e) { OnCalculIntervenantlot(0);}',
                                                                    ],
                                                                ]
                                                            )->label(false); ?>
                                                        </div>
                                                        <div class="col s1">
                                                            <?= $form->field($taskOperational, "[{$i}]price")->textInput(['type' => 'number', 'autocomplete' => 'off', 'maxlength' => true, 'readonly' => true, 'autocomplete' => 'off', 'maxlength' => true])->label(false) ?>
                                                        </div>
                                                        <div class="col s1">
                                                            <?= $form->field($taskOperational, "[{$i}]day_duration")->textInput(['type' => 'number', 'min' => 0, 'autocomplete' => 'off', 'maxlength' => true])->label(false) ?>
                                                        </div>
                                                        <div class="col s1">
                                                            <?= $form->field($taskOperational, "[{$i}]hour_duration")->textInput(['type' => 'number', 'min' => 0, 'autocomplete' => 'off', 'maxlength' => true])->label(false) ?>
                                                        </div>
                                                        <?php if ($hide) : ?>
                                                            <div class="col s0">
                                                                <?= $form->field($taskOperational, "[{$i}]risk")->hiddeninput(['value' => 1])->label(''); ?>
                                                            </div>
                                                        <?php else : ?>
                                                            <div class="col s2">
                                                                <?= $form->field($taskOperational, "[{$i}]risk")->widget(
                                                                    Select2::class,
                                                                    [
                                                                        'theme' => Select2::THEME_MATERIAL,
                                                                        'name' => 'TaskRisk[{$i}]',
                                                                        'data' => ArrayHelper::map($risk, 'id', 'title'),
                                                                        'pluginLoading' => false,
                                                                        "theme" => Select2::THEME_MATERIAL,
                                                                        'pluginEvents' => [
                                                                            'select2:select' => 'function(e) { 
                                                                        OnCalculIncertitudelot(0);
                                                                    }',
                                                                        ],
                                                                    ]
                                                                )->label(false); ?>
                                                            </div>
                                                        <?php endif; ?>
                                                        <div class="col s1">
                                                            <?= $form->field($taskOperational, "[{$i}]risk_duration")->textInput(['readonly' => true, 'autocomplete' => 'off', 'maxlength' => true])->label(false) ?>
                                                            <?php echo Html::activeHiddenInput($taskOperational, "[{$i}]risk_duration_hour"); ?>
                                                        </div>
                                                        <div class="col s1">
                                                            <?= $form->field($taskOperational, "[{$i}]totalprice")->textInput(['readonly' => true, 'autocomplete' => 'off', 'maxlength' => true])->label(false) ?>
                                                        </div>
                                                        <div class="col s1">
                                                            <button type="button" class="remove-item-taskLot btn-flat remove-item-button-type"><i class="glyphicon glyphicon-trash"></i></button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                    <div class="col s12">
                                        <p class="add-item-taskLot add-item-link-type">Ajouter une tâche de lot</p>
                                    </div>
                                    <?php DynamicFormWidget::end(); ?>
                                </div>
                            </div>
                        </div>
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



<!-- Utilisation : envoi de données concernant les risques. -->
<div id="coefficient-data-target" style="display: none;">
    <?php
    // Envoi de données.

    echo json_encode(ArrayHelper::map($risk, 'id', 'coefficient'));
    ?>
</div>

<!-- Utilisation : envoi de données concernant les utilisateurs attribués aux tâches (pour procéder à l'affichage du coût). -->
<div id="capauser-data-target" style="display: none;">
    <?php
    // Envoi de données.
    echo json_encode(ArrayHelper::map($celluleUsers, 'id', 'price'));
    ?>
</div>