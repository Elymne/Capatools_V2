<?php

use app\assets\AppAsset;

use app\models\projects\task;
use app\services\userRoleAccessServices\UserRoleEnum;
use app\services\userRoleAccessServices\UserRoleManager;
use app\widgets\TopTitle;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;

use yii\helpers\ArrayHelper;

$this->title = 'Liste des tâches';

// les 
if ($lot->number != 0){
    $this->title = $this->title  . " pour le lot " . $lot->title;
}
else
{
    $this->title = $this->title  . "d'avant projet";
}
$task = new task()
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

                    <!-- TODO Trouver un moyen de faire fonctionner ces combobox -->
                    <div class="card-action">

                        <!-- Liste de tâche de gestion de projet du lot  -->
                        <label class='blue-text control-label typeLabel'>Tâche de gestion du projet du lot</label>
                        <div class="container-items-task">
                                        <!-- widgetContainer -->
                                        <?php $taskGestions = $lot->GetTasks()->where(['task_category'=> task::CATEGORY_MANAGEMENT]);
                                         foreach ($taskGestions->each() as $i => $task) : ?>
                                            <div class="item">

                                                <?php
                                                var_dump($CelluleUsers);
                                                var_dump(ArrayHelper::map($CelluleUsers, 'id', 'firstname'));
                                                //$lot_rank = $i + 1;
                                                // necessary for update action.
                                               if (!$task->isNewRecord) {
                                                    echo Html::activeHiddenInput($task, "[{$i}]id");
                                                }
                                                ?>

                                                <div class="row">
                                                    <div class="col s6">
                                                        <?= $form->field($task, "[{$i}]title")->textInput(['autocomplete' => 'off', 'maxlength' => true])->label("Description") ?>
                                                    </div>
                                                    <div class="col s1">
                                                        <?= $form->field($task, "[{$i}]days_duration")->textInput(['autocomplete' => 'off', 'maxlength' => true])->label("Jour") ?>
                                                    </div>
                                                    <div class="col s1">
                                                        <?= $form->field($task, "[{$i}]days_duration")->widget(Select2::classname(), [
    'name' => 'kv-type-01',
    'data' => ArrayHelper::map($CelluleUsers, 'id', 'firstname') ,
    'pluginLoading' => false,
    'options' => [
        'placeholder' => 'Select a type ...',
        'options' => [
            3 => ['disabled' => true],
            4 => ['disabled' => true],
        ]
    ]
]); 



?>
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
                        <!-- lot ou pas ? -->
                        <label class='blue-text control-label typeLabel'>Tâche du lot</label>
                        <div class="container-items-task">
                                        <!-- widgetContainer -->
                                        <?php $taskGestions = $lot->GetTasks()->where(['task_category'=> task::CATEGORY_TASK]);
                                         foreach ($taskGestions->each() as $i => $task) : ?>
                                            <div class="item">

                                                <?php

                                                //$lot_rank = $i + 1;
                                                // necessary for update action.
                                               if (!$task->isNewRecord) {
                                                    echo Html::activeHiddenInput($task, "[{$i}]id");
                                                }
                                                ?>

                                                <div class="row">
                                                    <div class="col s6">
                                                        <?= $form->field($task, "[{$i}]title")->textInput(['autocomplete' => 'off', 'maxlength' => true])->label("Description") ?>
                                                    </div>
                                                </div><!-- .row -->

                                            </div>
                                        <?php endforeach; ?>
                                    </div>                      

                        <!-- Création de lot -->
                        <div id="lot-management-body" class="col s12">
                            <div class="row">
                                <div class="input-field col s12">

                                    <?php /*DynamicFormWidget::begin([
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
                                    ]);*/ ?>

                                    <div class="container-items-task">
                                        <!-- widgetContainer -->
                                        <?php /*foreach ($lots as $i => $lot) : ?>
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
                                        <?php endforeach;*/ ?>
                                    </div>

                                    <?php// DynamicFormWidget::end(); ?>

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