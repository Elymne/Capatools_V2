<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\devis\Devis */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="devis-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php
        if($type == 'update')
        {?>
           <?=     $form->field($model,'id_capa')->textInput(['maxlength' => true,'disabled'=>true])->label("CapaID");?>
       <?php }
         ?>
    <?= $form->field($model, 'internal_name')->textInput(['maxlength' => true,])->label("Nom du projet") ?>

    <?= $form->field($model, 'service_duration')->textInput()->label("Durée de la prestation (en jours ouvrables)") ?>
    <?= $form->field($model, 'company[name]')->textInput()->label("Nom du client") ?>
    <?= $form->field($model, 'company[tva]')->textInput()->label("TVA") ?>
    <?= $form->field($model, 'filename')->fileInput()->label("Document technique associé") ?>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
