<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\devis\Devis */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="devis-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id')->textInput() ?>

    <?= $form->field($model, 'id_capa')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'internal_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'service_duration')->textInput() ?>

    <?= $form->field($model, 'version')->textInput() ?>

    <?= $form->field($model, 'filename')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'filename_first_upload')->textInput() ?>

    <?= $form->field($model, 'filename_last_upload')->textInput() ?>

    <?= $form->field($model, 'cellule_id')->textInput() ?>

    <?= $form->field($model, 'company_id')->textInput() ?>

    <?= $form->field($model, 'capaidentity_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
