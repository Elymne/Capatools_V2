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
                <img src="https://admin.preprod.capatools.fr/web/images/logo.png" alt="" />
            </p>

            <div class="card-action">
                <span class="card-title">Réinitialisation du mot de passe</span>

                <?php $form = ActiveForm::begin([
                    'id' => 'login-form',
                    'layout' => 'horizontal',
                    'fieldConfig' => [
                        'template' => "{label}\n<div class=\"input-field col s12\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
                        'labelOptions' => ['class' => 'blue-text control-label'],
                    ],
                ]); ?>

                <?= $form->field($model, 'email')->textInput(['autofocus' => true])->label('Email') ?>

                <div class="form-group">
                    <div class="col s12">
                        <p class="center-align">
                            <?= Html::submitButton('Envoyer <i class="material-icons right">mail_outline</i>', ['class' => 'btn waves-effect waves-light', 'name' => 'login-button']) ?>
                        </p>
                    </div>
                </div>
                <?php ActiveForm::end(); ?>
            </div>

        </div>
    </div>
</div>