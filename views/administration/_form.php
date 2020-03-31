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

echo $model->id;

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
        'options' => ['value' => getSelectedAdminRoleKey($userRoles)],
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

        $value = array_search($role, $userRoles);
        if ($value != null) {
            return $key;
        }

        return 0;
    }
}

function getSelectedAdminRoleKey($userRoles): int
{
    foreach (UserRoleEnum::ADMINISTRATION_ROLE as $key => $role) {

        $value = array_search($role, $userRoles);
        if ($value != null) {
            return $key;
        }

        return 0;
    }
}
