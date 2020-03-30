<?php

use app\assets\AppAsset;
use app\helper\_enum\UserRoleEnum;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

AppAsset::register($this);

/* @var $this yii\web\View */
/* @var $model app\models\user\CapaUser */
/* @var $form yii\widgets\ActiveForm */

// Get user roles.
$userRoles = null;
if ($model->id != null) $userRoles = Yii::$app->authManager->getRolesByUser($model->id);
else $userRoles = [];

//Get user cellule if it exists.

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
        'theme' => Select2::THEME_MATERIAL,
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
        'options' => ['value' => getSelectedDevisRoleKey($userRoles)],
        'pluginLoading' => false,
        'pluginOptions' => [
            'allowClear' => false
        ],
    ])->label(
        "Rôle service devis"
    ); ?>

    <!-- admin role dropdown field -->
    <?= $form->field($model, 'stored_role_admin')->widget(Select2::classname(), [
        'data' => UserRoleEnum::ADMINISTRATOR_ROLE_STRING,
        'options' => ['value' => getSelectedDevisRoleKey($userRoles)],
        'pluginLoading' => false,
        'pluginOptions' => [
            'allowClear' => false
        ],
    ])->label(
        "Rôle service Administration"
    );; ?>

    <div class="form-group">
        <?= Html::submitButton('Enregistrer <i class="material-icons right">save</i>', ['class' => 'btn waves-effect waves-light']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php

function getSelectedDevisRoleKey($userRoles): int
{
    $selectedKey = 0;
    foreach (UserRoleEnum::DEVIS_ROLE as $key => $role) {

        $exists = array_search($role, $userRoles);
        if ($exists) {
            $selectedKey = $key;
        }
    }

    return $selectedKey;
}

function getSelectedAdminRoleKey($userRoles): int
{
    $selectedKey = 0;
    foreach (UserRoleEnum::ADMINISTRATION_ROLE as $key => $role) {

        $exists = array_search($role, $userRoles);
        if ($exists) {
            $selectedKey = $key;
        }
    }

    return $selectedKey;
}
