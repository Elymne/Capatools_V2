<?php

use app\assets\AppAsset;

use app\models\projects\task;
use app\services\userRoleAccessServices\UserRoleEnum;
use app\services\userRoleAccessServices\UserRoleManager;
use app\widgets\TopTitle;
use GuzzleHttp\Psr7\AppendStream;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;

use wbraganca\dynamicform\DynamicFormWidget;
use yii\helpers\ArrayHelper;

AppAsset::register($this);
$this->title = 'Liste des tâches';
$lot = $model->GetCurrentLot();

if ($lot->number != 0) {
    $this->title = $this->title  . " pour le lot " . $lot->title;
} else {
    $this->title = $this->title  . " d'avant projet";
}
$task = new task()
?>
<?= TopTitle::widget(['title' => $this->title]) ?>
<div class="container">
    <div class="project-create">
        <?php $form = ActiveForm::begin(['id' => 'dynamic-form', 'options' => ['enctype' => 'multipart/form-data']]); ?>
        <div class="row">
            <div class="col s12">

                <!-- Card view basique -->
                <div class="card">

                    <div class="card-content">
                        <label> <?= $this->title ?></label>
                    </div>

                    <!-- TODO Trouver un moyen de faire fonctionner ces combobox -->
                    <div class="card-action">
                        <?php if ($lot->number != 0) { ?>
                            <!-- Liste de tâche de gestion de projet du lot  -->
                            <label class='blue-text control-label typeLabel'>Tâche de gestion du projet du lot</label>
                            <?php
                            $taskGestions = $lot->GetTasks()->where(['task_category' => task::CATEGORY_MANAGEMENT]);

                            $TaskArray = null;
                            foreach ($taskGestions->each() as $i => $task) {
                                $TaskArray[] = $task;
                            }
                            if ($TaskArray == null) {
                                $TaskArray = [new task];
                            }
                            DynamicFormWidget::begin([
                                'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                                'widgetBody' => '.container-items-taskGestion', // required: css class selector
                                'widgetItem' => '.item-taskGestion', // required: css class
                                'limit' => 10, // the maximum times, an element can be cloned (default 999)
                                'min' => 1, // 0 or 1 (default 1)
                                'insertButton' => '.add-item-taskGestion', // css class
                                'deleteButton' => '.remove-item-taskGestion', // css class
                                'model' => $TaskArray[0],
                                'formId' => 'dynamic-form',
                                'formFields' => [
                                    'id',
                                    'title',
                                    'contributor',
                                    'price',
                                    'duration',
                                    'kind_duration',
                                    'risk',
                                    'risk_duration',
                                ],
                            ]); ?>
                            <div class="container-items-taskGestion">
                                <!-- widgetContainer -->
                                <?php foreach ($TaskArray as $i => $task) : ?>
                                    <div class="item-taskGestion">

                                        <?php
                                        // necessary for update action.
                                        if (!$task->isNewRecord) {
                                            echo Html::activeHiddenInput($task, "[{$i}]id");
                                        }
                                        ?>

                                        <div class="row">
                                            <div class="col s2">
                                                <?= $form->field($task, "[{$i}]title")->textInput(['autocomplete' => 'off', 'maxlength' => true])->label("Description") ?>
                                            </div>
                                            <div class="col s2">
                                                <?= $form->field($task, "[{$i}]contributor")->widget(
                                                    Select2::classname(),
                                                    [

                                                        'theme' => Select2::THEME_MATERIAL,
                                                        'name' => 'GestionContributor',
                                                        'data' => ArrayHelper::map($CelluleUsers, 'id', 'fullName'),
                                                        'pluginLoading' => false,
                                                        'options' => [
                                                            'placeholder' => 'Intervenant...',
                                                        ]
                                                    ]
                                                )->label("Intervenant");
                                                ?>
                                            </div>
                                            <div class="col s1">
                                                <?= $form->field($task, "[{$i}]price")->textInput(['readonly' => true, 'autocomplete' => 'off', 'maxlength' => true])->label("Coût") ?>
                                            </div>
                                            <div class="col s1">
                                                <?= $form->field($task, "[{$i}]duration")->textInput(['autocomplete' => 'off', 'maxlength' => true])->label("Jour") ?>
                                            </div>
                                            <div class="col s2">

                                                <?= $form->field($task, "[{$i}]kind_duration")->widget(
                                                    Select2::classname(),
                                                    [
                                                        'theme' => Select2::THEME_MATERIAL,
                                                        'name' => 'GestionKindDuration',
                                                        'data' => $task::KINDDURATION,
                                                        'pluginLoading' => false,
                                                        'options' => [
                                                            'placeholder' => 'J/H',
                                                        ]
                                                    ]
                                                )->label("J/H");
                                                ?>
                                            </div>
                                            <div class="col s2">
                                                <?= $form->field($task, "[{$i}]risk")->widget(
                                                    Select2::classname(),
                                                    [
                                                        'theme' => Select2::THEME_MATERIAL,
                                                        'name' => 'GestionRisk',
                                                        'data' => $task::RISKS,
                                                        'pluginLoading' => false,
                                                        'options' => [
                                                            'placeholder' => 'Risque...',
                                                        ]
                                                    ]
                                                )->label("Incertitude");
                                                ?>
                                            </div>
                                            <div class="col s1">
                                                <?= $form->field($task, "[{$i}]risk_duration")->textInput(['readonly' => true, 'autocomplete' => 'off', 'maxlength' => true])->label("Total") ?>
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
                            <!-- lot ou pas ? -->
                            <label class='blue-text control-label typeLabel'>Tâche du lot</label>

                        <?php } else { ?>

                            <label class='blue-text control-label typeLabel'>Tâche d'avant projet</label>
                        <?php } ?>
                        <div class="container-items-task">
                            <!-- widgetContainer -->
                            <?php $tasklot = $lot->GetTasks()->where(['task_category' => task::CATEGORY_TASK]);
                            $TaskLotArray = null;
                            foreach ($tasklot->each() as $i => $task) {
                                $TaskLotArray[] = $task;
                            }

                            if ($TaskLotArray == null) {
                                $TaskLotArray = [new task];
                            }
                            DynamicFormWidget::begin([
                                'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                                'widgetBody' => '.container-items-taskLot', // required: css class selector
                                'widgetItem' => '.item-taskLot', // required: css class
                                'limit' => 10, // the maximum times, an element can be cloned (default 999)
                                'min' => 1, // 0 or 1 (default 1)
                                'insertButton' => '.add-item-taskLot', // css class
                                'deleteButton' => '.remove-item-taskLot', // css class
                                'model' => $TaskLotArray[0],
                                'formId' => 'dynamic-form',
                                'formFields' => [
                                    'id',
                                    'title',
                                    'contributor',
                                    'price',
                                    'duration',
                                    'kind_duration',
                                    'risk',
                                    'risk_duration',
                                ],
                            ]); ?>
                            <div class="container-items-taskLot">
                                <!-- widgetContainer -->
                                <?php foreach ($TaskLotArray as $i => $task) : ?>
                                    <div class="item-taskLot">

                                        <?php
                                        // necessary for update action.
                                        if (!$task->isNewRecord) {
                                            echo Html::activeHiddenInput($task, "[{$i}]id");
                                        }
                                        ?>

                                        <div class="row">
                                            <div class="col s2">
                                                <?= $form->field($task, "[{$i}]title")->textInput(['autocomplete' => 'off', 'maxlength' => true])->label("Description") ?>
                                            </div>
                                            <div class="col s2">
                                                <?= $form->field($task, "[{$i}]contributor")->widget(
                                                    Select2::classname(),
                                                    [

                                                        'theme' => Select2::THEME_MATERIAL,
                                                        'name' => 'TaskContributor',
                                                        'data' => ArrayHelper::map($CelluleUsers, 'id', 'fullName'),
                                                        'pluginLoading' => false,
                                                        'options' => [
                                                            'placeholder' => 'Intervenant...',
                                                        ]
                                                    ]
                                                )->label("Intervenant");
                                                ?>
                                            </div>
                                            <div class="col s1">
                                                <?= $form->field($task, "[{$i}]price")->textInput(['readonly' => true, 'autocomplete' => 'off', 'maxlength' => true])->label("Coût") ?>
                                            </div>
                                            <div class="col s1">
                                                <?= $form->field($task, "[{$i}]duration")->textInput(['autocomplete' => 'off', 'maxlength' => true])->label("Jour") ?>
                                            </div>
                                            <div class="col s2">

                                                <?= $form->field($task, "[{$i}]kind_duration")->widget(
                                                    Select2::classname(),
                                                    [
                                                        'theme' => 'material',
                                                        'name' => 'TaskKindDuration',
                                                        'data' => $task::KINDDURATION,
                                                        'pluginLoading' => false,
                                                        'options' => [
                                                            'placeholder' => 'J/H',
                                                        ]
                                                    ]
                                                )->label("J/H");
                                                ?>
                                            </div>
                                            <div class="col s2">
                                                <?= $form->field($task, "[{$i}]risk")->widget(
                                                    Select2::classname(),
                                                    [

                                                        'theme' => Select2::THEME_MATERIAL,
                                                        'name' => 'TaskRisk',
                                                        'data' => $task::RISKS,
                                                        'pluginLoading' => false,
                                                        'options' => [
                                                            'placeholder' => 'Risque...',
                                                        ]
                                                    ]
                                                )->label("Incertitude");
                                                ?>
                                            </div>
                                            <div class="col s1">
                                                <?= $form->field($task, "[{$i}]risk_duration")->textInput(['readonly' => true, 'autocomplete' => 'off', 'maxlength' => true])->label("Total") ?>
                                            </div>
                                            <div class="col 2">
                                                <button type="button" class="add-item-taskLot btn-floating waves-effect waves-light btn-grey"><i class="glyphicon glyphicon-plus"></i></button>
                                            </div>
                                            <div class="col 2">
                                                <button type="button" class="remove-item-taskLot btn-floating waves-effect waves-light btn-grey"><i class="glyphicon glyphicon-minus"></i></button>
                                            </div>
                                        </div><!-- .row -->

                                    </div>
                                <?php endforeach; ?>
                            </div>


                            <?php DynamicFormWidget::end(); ?>
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