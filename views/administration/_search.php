<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<div class="capa_user-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'username') ?>

    <?= $form->field($model, 'email') ?>
    <?= $form->field($model, 'celulle.name') ?>


    <?php // echo $form->field($model, 'Celluleid') 
    ?>

    <?php // echo $form->field($model, 'flag_password') 
    ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>