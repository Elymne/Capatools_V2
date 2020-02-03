<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use app\models\User\Cellule;
use yii\helpers\ArrayHelper;
$value = Cellule::find()->all();
$listData=ArrayHelper::map($value,'identifiant','name');

asort($listData);
if($model->cellule != null)
{
    $comboxselect = $model->cellule->name;
}
else
{
    $comboxselect = 'Choisir la cellule ...' ;
}
/* @var $this yii\web\View */
/* @var $model app\models\User\Capaidentity */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="capaidentity-form">

    <?php $form = ActiveForm::begin(); ?>

   
    <?= $form->field($model, 'username')->textInput(['maxlength' => true])->label('Nom de l\'utilisateur :') ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true])->label('Email :') ?>

    <?=  $form->field($model, 'celname')->dropDownList($listData,['prompt'=>$comboxselect ])->label('Nom de la cellule :');   ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
