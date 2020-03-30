<?php

use app\assets\AppAsset;
use app\helper\_enum\UserRoleEnum;
use yii\grid\GridView;
use yii\data\ArrayDataProvider;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yiiui\yii2materializeselect2\Select2;

AppAsset::register($this);

/* @var $this yii\web\View */
/* @var $model app\models\user\CapaUser */
/* @var $form yii\widgets\ActiveForm */
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
    <?= $form->field($model, 'cellule_id')->widget(Select2::class, [
        'items' => $cellules,
        'value' => 2,
        'clientOptions' => [
            'allowClear' => true,
            'theme' => 'default'
        ]
    ])->label(
        "Cellules",
        ['for' => 'cellule_id']
    );
    ?>

    <?php


    $userRoles = null;
    if ($model->id != null)
        $userRoles = Yii::$app->authManager->getRolesByUser($model->id);
    else
        $userRoles = [];

    //var_dump($userRoles);

    foreach (UserRoleEnum::DEVIS_ROLE as $role) {

        $selectorDevis = 'none';

        $key = array_search($role, $userRoles);
        if (is_bool($key)) {
            $selectorDevis = $role;
        }
    }

    echo '<label class="control-label">Droit devis</label>';
    echo Select2::widget([
        'name' => 'state_10',
        'items' => UserRoleEnum::DEVIS_ROLE,
        'options' => [
            'placeholder' => 'Select provinces ...',
            'multiple' => true
        ],
    ]);

    foreach (UserRoleEnum::ADMINISTRATION_ROLE as $role) {

        $key = array_search($role, $userRoles);
    }


    ?>

    <div class="form-group">
        <?= Html::submitButton('Enregistrer <i class="material-icons right">save</i>', ['class' => 'btn waves-effect waves-light']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>