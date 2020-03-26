<?php

use yii\helpers\Html;
use yii\jui\DatePicker;
use wbraganca\dynamicform\DynamicFormWidget;
use yiiui\yii2materializeselect2\Select2;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use app\assets\AppAsset;
use app\widgets\TopTitle;

/* @var $this yii\web\View */
/* @var $model app\models\devis\Devis */

$this->title = 'Modification : ' . $model->id_capa;
$this->params['breadcrumbs'][] = ['label' => 'Devis', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';

AppAsset::register($this);

?>

<?= TopTitle::widget(['title' => $this->title]) ?>

<div class="container">
    <div class="devis-update">

        <div class="row">
            <div class="col s6 offset-s3">

                <?php $form = ActiveForm::begin(['id' => 'dynamic-form', 'options' => ['enctype' => 'multipart/form-data']]); ?>

                <div class="card">

                    <div class="card-content">



                        <?= $form->field($model, 'internal_name')
                            ->textInput(['maxlength' => true, 'disabled' => true], ['autocomplete' => 'off'])
                            ->label("Nom du projet")
                        ?>

                        <?= $form->field($model, 'delivery_type_id')->widget(Select2::class, [
                            'items' => ArrayHelper::map($delivery_type, 'id', 'label'),
                            'clientOptions' => [
                                'allowClear' => true
                            ],
                        ]);
                        ?>

                        <?= $form->field($model, 'company_name')
                            ->widget(\yii\jui\AutoComplete::classname(), [
                                'clientOptions' => [
                                    'source' => $companiesNames,
                                ],
                            ])
                            ->label("Nom du client")
                        ?>

                        <?= $form->field($model, 'service_duration')
                            ->textInput(['autocomplete' => 'off'])
                            ->label("Durée de la prestation (j)")
                        ?>

                    </div>

                </div>

                <div class="card">

                    <div class="card-content">
                        <span>Jalons</span>
                    </div>

                    <div class="card-action">

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
                                'comments'
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
                                            <button type="button" class="add-item waves-effect waves-light btn blue"><i class="glyphicon glyphicon-plus"></i></button>
                                            <button type="button" class="remove-item waves-effect waves-light btn red"><i class="glyphicon glyphicon-minus"></i></button>
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
                                            <div>
                                                <?= $form->field($milestone, "[{$i}]label")->textInput(['autocomplete' => 'off', 'maxlength' => true])->label('Label') ?>
                                                <?= $form->field($milestone, "[{$i}]price")->textInput(['class' => 'priceHt', 'autocomplete' => 'off', 'maxlength' => true])->label('Prix HT') ?>
                                                <?= $form->field($milestone, "[{$i}]comments")->textarea(['autocomplete' => 'off', 'maxlength' => true])->label('Commentaire') ?>
                                            </div>
                                        </div><!-- .row -->

                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <?php DynamicFormWidget::end(); ?>
                    </div>

                </div>
                <div class="form-group">
                    <?= Html::submitButton('Enregistrer', ['class' => 'waves-effect waves-light btn blue']) ?>
                    <?= Html::a('Annuler', ['index'], ['class' => 'waves-effect waves-light btn orange']) ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>

    </div>
</div>

<?php

///Script js qui permet de réinitiliser le date picker lors de l'ajout d'un jalon
$this->registerJs(' 

$(function () {

    $(".dynamicform_wrapper").on("afterInsert", function(e, item) {
        $( ".picker" ).each(function() {
            $( this ).datepicker({ 
                dateFormat: "dd-mm-yy",
            });
        });

        var maxPriceHt = $(".priceHt").val();
        console.log(maxPriceHt);
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
'); ?>


<?php

/**
 * Keep safe.
 *  <?= $form->field($milestone, "[{$i}]delivery_date")->widget(DatePicker::classname(), ['dateFormat' => 'dd-MM-yyyy', 'options' => ['class' => 'form-control picker', 'autocomplete' => 'off']])->label('Date') ?>
 * 
 * 
 * 
 * 
 * <?= $form->field($model, 'price')->textInput()->label("Prix de la prestation ") ?>
 */
