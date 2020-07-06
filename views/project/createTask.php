<?php

use app\assets\AppAsset;
use app\widgets\TopTitle;
use kartik\select2\Select2;
use yii\helpers\Html;
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


?>
<?= TopTitle::widget(['title' => $this->title]) ?>
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
                            <?php

                            DynamicFormWidget::begin([
                                'widgetContainer' => 'dynamicform_wrapper1', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                                'widgetBody' => '.container-items-taskGestion', // required: css class selector
                                'widgetItem' => '.item-taskGestion', // required: css class
                                'limit' => 10, // the maximum times, an element can be cloned (default 999)
                                'min' => 1, // 0 or 1 (default 1)
                                'insertButton' => '.add-item-taskGestion', // css class
                                'deleteButton' => '.remove-item-taskGestion', // css class
                                'model' => $tasksGestions[0],
                                'formId' => 'dynamic-form',
                                'formFields' => [
                                    'title',
                                    'contributor',
                                    'price',
                                    'day_duration',
                                    'hour_duration',
                                    'risk',
                                    'risk_duration',
                                ],
                            ]); ?>
                            <div class="container-items-taskGestion">
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
                                            <div class="col s2">
                                                <?= $form->field($taskGestion, "[{$i}]title")->textInput(['autocomplete' => 'off', 'maxlength' => true])->label("Description") ?>
                                            </div>
                                            <div class="col s2">
                                                <?= $form->field($taskGestion, "[{$i}]capa_user_id")->widget(
                                                    Select2::classname(),
                                                    [

                                                        'theme' => Select2::THEME_MATERIAL,
                                                        'name' => 'GestionContributor',
                                                        'data' => ArrayHelper::map($celluleUsers, 'id', 'fullName'),
                                                        'pluginLoading' => false,
                                                        'options' => [
                                                            'placeholder' => 'Intervenant...',
                                                        ],
                                                        'pluginEvents' => [
                                                            'select2:select' => 'function(e) { console.log(e);alert(e.currentTarget.value); }',
                                                        ],
                                                    ]
                                                )->label("Intervenant");
                                                ?>
                                            </div>
                                            <div class="col s1">
                                                <?= $form->field($taskGestion, "[{$i}]price")->textInput(['readonly' => true, 'autocomplete' => 'off', 'maxlength' => true])->label("Coût") ?>
                                            </div>
                                            <div class="col s1">
                                                <?= $form->field($taskGestion, "[{$i}]day_duration")->textInput(['type' => 'number', 'autocomplete' => 'off', 'maxlength' => true])->label("Jour") ?>
                                            </div>
                                            <div class="col s1">
                                                <?= $form->field($taskGestion, "[{$i}]hour_duration")->textInput(['type' => 'number', 'autocomplete' => 'off', 'maxlength' => true])->label("heure") ?>

                                            </div>
                                            <div class="col s2">
                                                <?= $form->field($taskGestion, "[{$i}]risk")->widget(
                                                    Select2::classname(),
                                                    [
                                                        'theme' => Select2::THEME_MATERIAL,
                                                        'name' => 'GestionRisk',
                                                        'data' => ArrayHelper::map($risk, 'title', 'title'),
                                                        'pluginLoading' => false,
                                                        'options' => [
                                                            'placeholder' => 'Incetitude...',
                                                        ],
                                                        'pluginEvents' => [
                                                            'select2:select' => 'function(e) { console.log(e);alert(e.currentTarget.value); }',
                                                        ],
                                                    ]
                                                )->label("Incertitude");
                                                ?>
                                            </div>
                                            <div class="col s1">
                                                <?= $form->field($taskGestion, "[{$i}]risk_duration")->textInput(['readonly' => true, 'autocomplete' => 'off', 'maxlength' => true])->label("Total") ?>
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
                        <div id="lot-management-body" class="col s12">
                            <div class="row">
                                <div class="input-field col s12">

                                    <?php
                                    DynamicFormWidget::begin([
                                        'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                                        'widgetBody' => '.container-items-taskLot', // required: css class selector
                                        'widgetItem' => '.item-taskLot', // required: css class
                                        'limit' => 10, // the maximum times, an element can be cloned (default 999)
                                        'min' => 1, // 0 or 1 (default 1)
                                        'insertButton' => '.add-item-taskLot', // css class
                                        'deleteButton' => '.remove-item-taskLot', // css class
                                        'model' => $tasksOperational[0],
                                        'formId' => 'dynamic-form',
                                        'formFields' => [
                                            'title',
                                            'contributor',
                                            'price',
                                            'day_duration',
                                            'hour_duration',
                                            'risk',
                                            'risk_duration',
                                        ],
                                    ]); ?>
                                    <div class="container-items-taskLot">
                                        <!-- widgetContainer -->
                                        <?php foreach ($tasksOperational as $i => $taskOperational) : ?>
                                            <div class="item-taskLot">

                                                <?php
                                                // necessary for update action.
                                                if (!$taskOperational->isNewRecord) {
                                                    echo Html::activeHiddenInput($taskOperational, "[{$i}]id");
                                                }
                                                ?>

                                                <div class="row">
                                                    <div class="col s2">
                                                        <?= $form->field($taskOperational, "[{$i}]title")->textInput(['autocomplete' => 'off', 'maxlength' => true])->label("Description") ?>
                                                    </div>
                                                    <div class="col s2">
                                                        <?= $form->field($taskOperational, "[{$i}]capa_user_id")->widget(
                                                            Select2::classname(),
                                                            [
                                                                'theme' => Select2::THEME_MATERIAL,
                                                                'name' => 'TaskContributor',
                                                                'data' => ArrayHelper::map($celluleUsers, 'id', 'fullName'),
                                                                'pluginLoading' => false,
                                                                'options' => [
                                                                    'placeholder' => 'Intervenant...',
                                                                ],
                                                                'pluginEvents' => [
                                                                    'select2:select' => 'function(e) { console.log(e);alert(e.currentTarget.value); }',
                                                                ],
                                                            ]
                                                        )->label("Intervenant");
                                                        ?>
                                                    </div>
                                                    <div class="col s1">
                                                        <?= $form->field($taskOperational, "[{$i}]price")->textInput(['readonly' => true, 'autocomplete' => 'off', 'maxlength' => true])->label("Coût") ?>
                                                    </div>
                                                    <div class="col s1">
                                                        <?= $form->field($taskOperational, "[{$i}]day_duration")->textInput(['type' => 'number', 'autocomplete' => 'off', 'maxlength' => true])->label("Jour") ?>
                                                    </div>
                                                    <div class="col s1">
                                                        <?= $form->field($taskOperational, "[{$i}]hour_duration")->textInput(['type' => 'number', 'autocomplete' => 'off', 'maxlength' => true])->label("heure") ?>

                                                    </div>
                                                    <div class="col s2">
                                                        <?= $form->field($taskOperational, "[{$i}]risk")->widget(
                                                            Select2::classname(),
                                                            [

                                                                'theme' => Select2::THEME_MATERIAL,
                                                                'name' => 'TaskRisk[{$i}]',
                                                                'data' => ArrayHelper::map($risk, 'title', 'title'),
                                                                'pluginLoading' => false,
                                                                'options' => [
                                                                    'placeholder' => 'Incetitude...',
                                                                ],
                                                                'pluginEvents' => [
                                                                    'select2:select' => 'function(e) { console.log(e);alert(e.currentTarget.value); }',
                                                                ],

                                                            ]
                                                        )->label("Incertitude");
                                                        ?>
                                                    </div>
                                                    <div class="col s1">
                                                        <?= $form->field($taskOperational, "[{$i}]risk_duration")->textInput(['readonly' => true, 'autocomplete' => 'off', 'maxlength' => true])->label("Total") ?>
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

<?php



$script = <<< JS


$(".dynamicform_wrapper").on("beforeInsert", function(e, item) {

    console.log("beforeInsert");

});


$(".dynamicform_wrapper").on('afterInsert', function(e, item) {
  
    var seletect = item.innerHTML;

    var regex = new RegExp("tasklotcreatetaskform-([0-9]*)-risk");
  
    var arr = regex.exec(seletect);
   
    console.log(arr);
    console.log(arr[1]);
    var index = parseInt(arr[1]);
    console.log(index);

    var SelectRisk = "#tasklotcreatetaskform-"+ index +"-risk";
    
    console.log(SelectRisk);

    $(SelectRisk).on('select2:select', function(e){
        console.log(e);alert(e.currentTarget.value); 

       
    })

    var SelectUser = "#tasklotcreatetaskform-"+ index +"-capa_user_id";
    $(SelectUser).on('select2:select', function(e){
        console.log(e);alert(e.currentTarget.value); 

       
    })

});

$(".dynamicform_wrapper").on("beforeDelete", function(e, item) {

    if (! confirm("Are you sure you want to delete this item?")) {

        return false;

    }

    return true;

});


$(".dynamicform_wrapper").on("afterDelete", function(e) {

    console.log("Deleted item!");

});


$(".dynamicform_wrapper").on("limitReached", function(e, item) {

    alert("Limit reached");

});


JS;

$this->registerJs($script);
