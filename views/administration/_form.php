<?php

use app\assets\AppAsset;
use app\helper\_enum\UserRoleEnum;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

//AppAsset::register($this);

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
        'data' => $cellules,
        'value' => 2
    ])->label(
        "Cellules",
        ['for' => 'cellule_id']
    );
    ?>

    <?php

    // Get user roles.
    $userRoles = null;
    if ($model->id != null)
        $userRoles = Yii::$app->authManager->getRolesByUser($model->id);
    else
        $userRoles = [];

    // Check if user has a devis role and store it for selector.

    $devisRoleTranslated;
    foreach (UserRoleEnum::DEVIS_ROLE as $role) {
        $selectorDevis = 'none';

        $key = array_search($role, $userRoles);
        if (is_bool($key)) {
            $selectorDevis = $role;
        }
    }

    // Create dropdown devis.
    echo $form->field($model, 'stored_role_devis')->widget(Select2::classname(), [
        'data' => UserRoleEnum::DEVIS_ROLE_STRING,
        'options' => ['placeholder' => 'Select a state ...'],
        'pluginOptions' => [
            'allowClear' => true
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