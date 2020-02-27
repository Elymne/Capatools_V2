<?php

use app\helper\DateHelper;
use yii\helpers\Html;
use yii\jui\DatePicker;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $model app\models\devis\Devis */

$this->title = 'Mise à jour du devis :' . $model->id_capa;
$this->params['breadcrumbs'][] = ['label' => 'Devis', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Updateavcontrat';

?>
<div class="devis-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(['id' => 'dynamic-form', 'options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'internal_name')->textInput(['maxlength' => true, 'disabled' => true])->label("Nom du projet") ?>
    <?= $form->field($model, 'delivery_type_id')->dropDownList(ArrayHelper::map($prestationtypelist, 'id', 'label'), ['text' => 'Please select'])->label('');   ?>
    <?= $form->field($model, 'company[name]')->textInput()->label("Nom du client") ?>
    <?= $form->field($model, 'company[tva]')->textInput()->label("TVA") ?>
    <?= $form->field($model, 'service_duration')->textInput()->label("Durée de la prestation (j)") ?>



    <div class="panel panel-default">
        <div class="panel-heading">
            <h4><i class="glyphicon glyphicon-envelope"></i> Jalons</h4>
        </div>
        <div class="panel-body">

            <?php DynamicFormWidget::begin([
                'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                'widgetBody' => '.container-items', // required: css class selector
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
                    'comments',

                ],
            ]); ?>

            <div class="container-items">
                <!-- widgetContainer -->
                <?php foreach ($milestones as $i => $milestone) : ?>
                    <div class="item panel panel-default">
                        <!-- widgetBody -->
                        <div class="panel-heading">
                            <h3 class="panel-title pull-left">Jalon </h3>
                            <div class="pull-right">
                                <button type="button" class="add-item btn btn-success btn-xs"><i class="glyphicon glyphicon-plus"></i></button>
                                <button type="button" class="remove-item btn btn-danger btn-xs"><i class="glyphicon glyphicon-minus"></i></button>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="panel-body">
                            <?php
                            // necessary for update action.
                            if (!$milestone->isNewRecord) {
                                echo Html::activeHiddenInput($milestone, "[{$i}]id");
                            }
                            ?>

                            <div class="row">
                                <div class="col-sm-4">
                                    <?= $form->field($milestone, "[{$i}]label")->textInput(['maxlength' => true])->label('Label') ?>
                                    <?= $form->field($milestone, "[{$i}]price")->textInput(['maxlength' => true])->label('Prix') ?>
                                    <?= $form->field($milestone, "[{$i}]delivery_date")->widget(DatePicker::classname(), ['dateFormat' => 'dd-MM-yyyy', 'options' => ['class' => 'form-control picker']])->label('Date') ?>
                                    <?= $form->field($milestone, "[{$i}]comments")->textarea(['maxlength' => true])->label('Commentaires') ?>
                                </div>

                            </div><!-- .row -->
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <?php DynamicFormWidget::end(); ?>

        </div>

    </div>
    <?= $form->field($model, 'price')->textInput()->label("Prix de la prestation ") ?>


    <div class="form-group">
        <?= Html::submitButton('Enregistrer', ['class' => 'btn btn-success']) ?>
        <?= Html::a('Annuler', ['index'], ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end();

    ///Script js qui permet de réinitiliser le date picker lors de l'ajout d'un jalon
    $this->registerJs(' 
$(function () {
    $(".dynamicform_wrapper").on("afterInsert", function(e, item) {
         $( ".picker" ).each(function() {
            $( this ).datepicker({
            dateFormat: "dd-mm-yy",
          });
        });
    });
});
$(function () {
    $(".dynamicform_wrapper").on("afterDelete", function(e, item) {
        $( ".dob" ).each(function() {
           $( this ).removeClass("hasDatepicker").datepicker({
              dateFormat : "dd/mm/yy",
              yearRange : "1925:+0",
              maxDate : "-1D",
              changeMonth: true,
              changeYear: true
           });
      });          
    });
});
');


    ?>