<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
$this->title = Yii::$app->name;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dashboard-login">
    <img src= "<?= Html::encode(Yii::$app->homeUrl) ?>images/logo.png" alt="" />
    <?php $form = ActiveForm::begin([
        'id' => 'login-form',
        'layout' => 'horizontal',
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-1 control-label'],
        ],
    ]); ?>

        <?= $form->field($model, 'password')->passwordInput()->label('Ancien mot de passe')  ?>
        <?= $form->field($model, 'newpassword')->passwordInput()->label('Nouveau mot de passe')  ?>
        <?= $form->field($model, 'confirmationpassword')->passwordInput()->label('Confirmer le mot de passe')  ?>
        <div class="form-group">
            <div class="col-lg-offset-1 col-lg-11">
                <?= Html::submitButton('Envoyer', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
            </div>
        </div>

    <?php ActiveForm::end(); ?>


</div>
