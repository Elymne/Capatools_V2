<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use app\models\User\Cellule;

$value = Cellule::find()->select('name')->all();
$celle =array();
foreach ($value as $val)
{
   
    array_unshift(  $celle, $val['name']);
}
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

    <?=  $form->field($model, 'celname')->dropDownList($celle,['prompt'=>$comboxselect ])->label('Nom de la cellule :');   ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
