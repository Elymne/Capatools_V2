<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\devis\DevisSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="devis-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'id_capa') ?>

    <?= $form->field($model, 'internal_name') ?>

    <?= $form->field($model, 'service_duration') ?>

    <?= $form->field($model, 'version') ?>

    <?php // echo $form->field($model, 'filename') ?>

    <?php // echo $form->field($model, 'filename_first_upload') ?>

    <?php // echo $form->field($model, 'filename_last_upload') ?>

    <?php // echo $form->field($model, 'cellule_id') ?>

    <?php // echo $form->field($model, 'company_id') ?>

    <?php // echo $form->field($model, 'capaidentity_id') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
