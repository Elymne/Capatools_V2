<?php

use app\helper\_clazz\UserRoleManager;
use app\helper\_enum\UserRoleEnum;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

//AppAsset::register($this);

/* @var $this yii\web\View */
/* @var $model app\models\user\CapaUser */
/* @var $form yii\widgets\ActiveForm */

// Get user roles.
$userRoles = [];
if ($model->id != null) $userRoles = UserRoleManager::getUserRoles($model->id);

?>

<div class="capa_user-form">

    <?php $form = ActiveForm::begin([
        'fieldConfig' => [
            'labelOptions' => ['class' => 'blue-text control-label'],
        ],
    ]); ?>

    <!-- username field -->
    <?= $form->field($model, 'username')->textInput(['maxlength' => true, 'placeholder' => 'Nom et prénom'])->label('Nom de l\'utilisateur :') ?>

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

    <!-- devis role dropdown field -->
    <?= $form->field($model, 'stored_role_devis')->widget(Select2::classname(), [
        'data' => UserRoleEnum::DEVIS_ROLE_STRING,
        'options' => ['value' => UserRoleManager::getSelectedDevisRoleKey($userRoles)],
        'pluginLoading' => false,
        'pluginOptions' => [
            'allowClear' => false
        ],
    ])->label(
        "Permission pour les devis"
    ); ?>

    <!-- admin role dropdown field -->
    <?= $form->field($model, 'stored_role_admin')->widget(Select2::classname(), [
        'data' => UserRoleEnum::ADMINISTRATOR_ROLE_STRING,
        'options' => ['value' => UserRoleManager::getSelectedAdminRoleKey($userRoles)],
        'pluginLoading' => false,
        'pluginOptions' => [
            'allowClear' => false
        ],
    ])->label(
        "Permission d'administration"
    );; ?>

    <div class="form-group">
        <?= Html::submitButton('Enregistrer <i class="material-icons right">save</i>', ['class' => 'waves-effect waves-light btn btn-save ']) ?>

        <?= Html::a(Yii::t('app', 'Annuler'), ['index'], ['class' => 'waves-effect waves-light btn btn-delete']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>