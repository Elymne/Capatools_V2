<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\devis\Devis */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="devis-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'internal_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'service_duration')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
