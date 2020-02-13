<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
$this->title = Yii::$app->name;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col s6 m6">
        <div class="card">
            <p class="center-align">
                <img src= "<?= Html::encode(Yii::$app->homeUrl) ?>images/logo.png" alt="" />
            </p>
            <div class="card-content">
                <?php $form = ActiveForm::begin([
                    'id' => 'login-form',
                    'layout' => 'horizontal',
                    'fieldConfig' => [
                        'template' => "{label}\n<div class=\"input-field col s12\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
                        'labelOptions' => ['class' => 'blue-text control-label'],
                    ],
                ]); ?>

                    <?= $form->field($model, 'password')->passwordInput(['placeholder'=>'Ancien mot de passe'])->label('Ancien mot de passe')  ?>
                    <?= $form->field($model, 'newpassword')->passwordInput(['placeholder'=>'Nouveau mot de passe'])->label('Nouveau mot de passe')  ?>
                    <?= $form->field($model, 'confirmationpassword')->passwordInput(['placeholder'=>'Confirmation mot de passe'])->label('Confirmer le mot de passe')  ?>
                    <div class="form-group">
                        <div class="col s12">
                        <p class="center-align">
                            <?= Html::submitButton('Réinitialiser <i class="material-icons right">autorenew</i>', ['class' => 'btn waves-effect waves-light', 'name' => 'login-button']) ?>
                        </p>
                    </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
