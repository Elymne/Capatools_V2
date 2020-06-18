<?php

use app\assets\AppAsset;
use app\helper\_clazz\UserRoleManager;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

//AppAsset::register($this);

/* @var $this yii\web\View */
/* @var $model app\models\users\CapaUser */
/* @var $form yii\widgets\ActiveForm */

// Get user roles.
$userRoles = [];
if ($model->id != null) $userRoles = UserRoleManager::getUserRoles($model->id);
AppAsset::register($this);

?>

<div class="capa_user-form">

    <?php $form = ActiveForm::begin([
        'fieldConfig' => [
            'labelOptions' => ['class' => 'blue-text control-label'],
        ],
    ]); ?>

    <!-- username field -->
    <?= $form->field($model, 'surname')->textInput(['maxlength' => true, 'placeholder' => 'Nom et prénom'])->label('Nom de l\'utilisateur :') ?>
    <?= $form->field($model, 'firstname')->textInput(['maxlength' => true, 'placeholder' => 'Nom et prénom'])->label('Prénom de l\'utilisateur :') ?>

    <!-- email field -->
    <?= $form->field($model, 'email')->textInput(['maxlength' => true, 'placeholder' => 'Email capacités'])->label('Email :') ?>

    <!-- cellule dropdown field -->
    <?= $form->field($model, 'cellule_id')->widget(Select2::classname(), [
        'data' => $cellules,
        'options' => ['value' => 0],
        'pluginLoading' => false,
        'pluginOptions' => [
            'allowClear' => true
        ],
    ])->label(
        "Cellule"
    ); ?>

    <!-- email field -->
    <?= $form->field($model, 'price')->input('number', ['maxlength' => true, 'placeholder' => 'Prix'])->label('Prix d\'intervention :') ?>

    <?= Html::checkbox('lol', false, ['label' => 'alors']) ?>

    <div class="form-group">
        <?= Html::submitButton('Enregistrer <i class="material-icons right">save</i>', ['class' => 'waves-effect waves-light btn btn-blue']) ?>

        <?= Html::a(Yii::t('app', 'Annuler'), ['index'], ['class' => 'waves-effect waves-light btn btn-grey']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>