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

$this->title = 'Liste des tâches';
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
        <?= Html::activeHiddenInput($model, 'valid') ?>

        <div class="row">
            <div class="col s12">

                <!-- Card view basique -->
                <div class="card">

                    <div class="card-content">
                        <label> <?= $this->title ?></label>
                    </div>

                    <!-- TODO Trouver un moyen de faire fonctionner ces combobox -->
                    <div class="card-action">
                        <?php

                        //Sauvegarde du lot en cours et de l'id du projet
                        if ($lot->number != 0) { ?>
                            <!-- Liste de tâche de gestion de projet du lot  -->
                            <label class='blue-text control-label typeLabel'>Tâche de gestion du projet du lot</label>

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
                                <div class="row">
                                    <div class="col s1 offset-s5">
                                        <button type="button" class="add-item-taskGestion btn waves-effect waves-light btn-grey"><i class="glyphicon glyphicon-plus"></i></button>
                                    </div>
                                </div>
                                <!-- widgetContainer -->
                                <?php foreach ($tasksGestions as $i => $taskGestion) : ?>
                                    <div class="item-taskGestion">

                                        <?php
                                        // necessary for update action.
                                        if (!$taskGestion->isNewRecord) {
                                            echo Html::activeHiddenInput($taskGestion, "[{$i}]id");
                                        }
                                        ?>

                                        <div class="row">
                                            <div class="col s0">
                                                <?= Html::activeHiddenInput($taskGestion, "[{$i}]number"); ?>
                                            </div>
                                            <div class="col s2">
                                                <?= $form->field($taskGestion, "[{$i}]title")->textInput(['autocomplete' => 'off', 'maxlength' => true])->label("Description") ?>
                                            </div>
                                            <div class="col s3">
                                                <?= $form->field($taskGestion, "[{$i}]capa_user_id")->widget(
                                                    Select2::class,
                                                    [
                                                        //'theme' => Select2::THEME_MATERIAL,
                                                        'name' => 'GestionContributor',
                                                        'data' => ArrayHelper::map($celluleUsers, 'id', 'fullName'),
                                                        'pluginLoading' => false,
                                                        'options' => [
                                                            'placeholder' => 'Intervenant...',
                                                        ],
                                                        'pluginEvents' => [
                                                            'select2:select' => 'function(e) { 
                                                                OnCalculIntervenantGest(0);
                                                             }',
                                                        ],
                                                    ]
                                                )->label("Intervenant");
                                                ?>
                                            </div>
                                            <div class="col s1">
                                                <?= $form->field($taskGestion, "[{$i}]price")->textInput(['readonly' => true, 'autocomplete' => 'off', 'maxlength' => true])->label("Coût") ?>
                                            </div>
                                            <div class="col s1">
                                                <?= $form->field($taskGestion, "[{$i}]day_duration")->textInput(['type' => 'number', 'min' => 0, 'autocomplete' => 'off', 'maxlength' => true])->label("Jour") ?>
                                            </div>
                                            <div class="col s1">
                                                <?= $form->field($taskGestion, "[{$i}]hour_duration")->textInput(['type' => 'number', 'min' => 0, 'autocomplete' => 'off', 'maxlength' => true])->label("heure") ?>
                                            </div>
                                            <div class="col s1">
                                                <?= $form->field($taskGestion, "[{$i}]risk")->widget(
                                                    Select2::class,
                                                    [
                                                        //'theme' => Select2::THEME_MATERIAL,
                                                        'name' => 'GestionRisk',
                                                        'data' => ArrayHelper::map($risk, 'id', 'title'),
                                                        'value' => $tasksGestions[$i]->risk,
                                                        'pluginLoading' => false,
                                                        'pluginEvents' => [
                                                            'select2:select' => 'function(e) {
                                                                OnCalculIncertitudeGest(0);
                                                             }',
                                                        ],
                                                    ]
                                                )->label("Incertitude");
                                                ?>
                                            </div>
                                            <div class="col s1">
                                                <?= $form->field($taskGestion, "[{$i}]risk_duration")->textInput(['readonly' => true, 'autocomplete' => 'off', 'maxlength' => true])->label("Durée total") ?>

                                                <?php echo Html::activeHiddenInput($taskGestion, "[{$i}]risk_duration_hour"); ?>
                                            </div>
                                            <div class="col s1">
                                                <?= $form->field($taskGestion, "[{$i}]totalprice")->textInput(['readonly' => true, 'autocomplete' => 'off', 'maxlength' => true])->label("Prix total") ?>
                                            </div>
                                            <div class="col 2">
                                                <button type="button" class="add-item-taskGestion btn-floating waves-effect waves-light btn-grey"><i class="glyphicon glyphicon-plus"></i></button>
                                            </div>
                                            <div class="col 2">
                                                <button type="button" class="remove-item-taskGestion btn-floating waves-effect waves-light btn-grey"><i class="glyphicon glyphicon-minus"></i></button>
                                            </div>
                                        </div><!-- .row -->

                                    </div>
                                <?php endforeach; ?>
                            </div>

                            <?php DynamicFormWidget::end(); ?>

                    </div>

                    <div class="card-action">

                        <label class='blue-text control-label typeLabel'>Tâche du lot</label>

                    <?php } else { ?> <label class='blue-text control-label typeLabel'>Tâche d'avant projet</label> <?php } ?>

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
                                    <!-- widgetContainer -->
                                    <?php foreach ($tasksOperational as $i => $taskOperational) : ?>
                                        <div class="item-taskLot">

                                            <?php echo Html::activeHiddenInput($taskOperational, "[{$i}]id"); ?>

                                            <div class="row">

                                                <div class="col s0">
                                                    <?= Html::activeHiddenInput($taskOperational, "[{$i}]number"); ?>
                                                </div>
                                                <div class="col s2">
                                                    <?= $form->field($taskOperational, "[{$i}]title")->textInput(['autocomplete' => 'off', 'maxlength' => true])->label("Description") ?>
                                                </div>
                                                <div class="col s3">
                                                    <?= $form->field($taskOperational, "[{$i}]capa_user_id")->widget(
                                                        Select2::class,
                                                        [
                                                            //'theme' => Select2::THEME_MATERIAL,
                                                            'name' => 'TaskContributor',
                                                            'data' => ArrayHelper::map($celluleUsers, 'id', 'fullName'),
                                                            'pluginLoading' => false,

                                                            'options' => [
                                                                'placeholder' => 'Intervenant...',
                                                            ],
                                                            'pluginEvents' => [
                                                                'select2:select' => 'function(e) {
                                                                        OnCalculIntervenantlot(0);
                                                                        }',
                                                            ],
                                                        ]
                                                    )->label("Intervenant");
                                                    ?>
                                                </div>
                                                <div class="col s1">
                                                    <?= $form->field($taskOperational, "[{$i}]price")->textInput(['type' => 'number', 'autocomplete' => 'off', 'maxlength' => true, 'readonly' => true, 'autocomplete' => 'off', 'maxlength' => true])->label("Coût") ?>
                                                </div>
                                                <div class="col s1">
                                                    <?= $form->field($taskOperational, "[{$i}]day_duration")->textInput(['type' => 'number', 'min' => 0, 'autocomplete' => 'off', 'maxlength' => true])->label("Jour") ?>
                                                </div>
                                                <div class="col s1">
                                                    <?= $form->field($taskOperational, "[{$i}]hour_duration")->textInput(['type' => 'number', 'min' => 0, 'autocomplete' => 'off', 'maxlength' => true])->label("heure") ?>
                                                </div>

                                                <?php
                                                if ($hide) {
                                                    echo "<div class=\"col s0\">";
                                                    echo  $form->field($taskOperational, "[{$i}]risk")->hiddeninput(['value' => 1])->label('');
                                                } else {

                                                    echo "<div class=\"col s1\">";

                                                    echo $form->field($taskOperational, "[{$i}]risk")->widget(
                                                        Select2::class,
                                                        [
                                                            //'theme' => Select2::THEME_MATERIAL,
                                                            'name' => 'TaskRisk[{$i}]',
                                                            'data' => ArrayHelper::map($risk, 'id', 'title'),
                                                            'pluginLoading' => false,
                                                            'pluginEvents' => [
                                                                'select2:select' => 'function(e) { 
                                                                        OnCalculIncertitudelot(0);
                                                                    }',
                                                            ],
                                                        ]
                                                    )->label("Incertitude");
                                                }
                                                ?>
                                            </div><!-- .row -->

                                            <div class="col s1">
                                                <?= $form->field($taskOperational, "[{$i}]risk_duration")->textInput(['readonly' => true, 'autocomplete' => 'off', 'maxlength' => true])->label("Durée total") ?>
                                                <?php echo Html::activeHiddenInput($taskOperational, "[{$i}]risk_duration_hour"); ?>
                                            </div>

                                            <div class="col s1">
                                                <?= $form->field($taskOperational, "[{$i}]totalprice")->textInput(['readonly' => true, 'autocomplete' => 'off', 'maxlength' => true])->label("Prix total") ?>

                                            </div>

                                            <div class="col 2">
                                                <button type="button" class="add-item-taskLot btn-floating waves-effect waves-light btn-grey"><i class="glyphicon glyphicon-plus"></i></button>
                                            </div>

                                            <div class="col 2">
                                                <button type="button" class="remove-item-taskLot btn-floating waves-effect waves-light btn-grey"><i class="glyphicon glyphicon-minus"></i></button>
                                            </div>

                                        </div>
                                </div>

                            <?php endforeach; ?>
                            </div>

                            <?php DynamicFormWidget::end(); ?>
                        </div>


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