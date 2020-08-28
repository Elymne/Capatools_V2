<?php

use app\assets\administration\AdminFormAsset;
use app\services\userRoleAccessServices\UserRoleManager;
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

AdminFormAsset::register($this);

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
    <?= $form->field($model, 'cellule_id')->widget(Select2::class, [
        'data' => $cellules,
        'options' => ['value' => $model->cellule_id - 1],
        'pluginLoading' => false,
        'pluginOptions' => [
            'allowClear' => true
        ],
    ])->label(
        "Cellule"
    ); ?>

    <!-- email field -->
    <?= $form->field($model, 'price')->input('number', ['maxlength' => true, 'placeholder' => 'Prix'])->label('Prix d\'intervention :') ?>

    <label class='blue-text control-label roleLabel'>Gestion des rôles de l'utilisateur</label>

    <div class="col s12">
        <div class="row">
            <div class="col s3">
                <?php $checkboxLabel = '<span>salarié</span>'; ?>
                <?= $form->field($model, 'salary_role_checkbox', [])->checkbox([
                    'label' => $checkboxLabel
                ]) ?>
            </div>
            <div class="col s3">
                <?php $checkboxLabel = '<span>chef de projet</span>'; ?>
                <?= $form->field($model, 'project_manager_role_checkbox', [])->checkbox([
                    'label' => $checkboxLabel
                ]) ?>
            </div>
            <div class="col s3">
                <?php $checkboxLabel = '<span>resp. cellule</span>'; ?>
                <?= $form->field($model, 'cellule_manager_role_checkbox', [])->checkbox([
                    'label' => $checkboxLabel
                ]) ?>
            </div>
            <div class="col s3">
                <?php $checkboxLabel = '<span>support comptable</span>'; ?>
                <?= $form->field($model, 'support_role_checkbox', [])->checkbox([
                    'label' => $checkboxLabel
                ]) ?>
            </div>
            <div class="col s3">
                <?php $checkboxLabel = '<span>ressources humaine</span>'; ?>
                <?= $form->field($model, 'human_ressources_role_checkbox', [])->checkbox([
                    'label' => $checkboxLabel
                ]) ?>
            </div>
            <div class="col s3">
                <?php $checkboxLabel = '<span>admin</span>'; ?>
                <?= $form->field($model, 'admin_role_checkbox', [])->checkbox([
                    'label' => $checkboxLabel
                ]) ?>
            </div>
        </div>
    </div>






    <div class="form-group">
        <?= Html::submitButton('Enregistrer <i class="material-icons right">save</i>', ['class' => 'waves-effect waves-light btn btn-blue']) ?>

        <?= Html::a(Yii::t('app', 'Annuler'), ['index'], ['class' => 'waves-effect waves-light btn btn-grey']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>