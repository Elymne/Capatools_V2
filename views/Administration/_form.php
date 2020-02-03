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

/* @var $this yii\web\View */
/* @var $model app\models\User\Capaidentity */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="capaidentity-form">

    <?php $form = ActiveForm::begin(); ?>

   
    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model->cellule, 'name')->dropDownList($celle,['prompt'=>$model->cellule->name])->label('Nom de la cellule')?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
