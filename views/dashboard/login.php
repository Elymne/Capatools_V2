<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\assets\LoginAsset;

$this->title = Yii::$app->name;
$this->params['breadcrumbs'][] = $this->title;
LoginAsset::register($this);

?>
<div class="row">
    <div class="col s6 offset-s3">
        <div class="card">
            <p class="center-align">
                <img src="<?= Html::encode(Yii::$app->homeUrl) ?>images/logo.png" alt="" />
            </p>
            <div class="card-action">
                <?php $form = ActiveForm::begin([
                    'id' => 'login-form',
                    'layout' => 'horizontal',
                    'fieldConfig' => [
                        'template' => "{label}\n<div class=\"input-field col s12\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
                        'labelOptions' => ['class' => 'blue-text control-label'],
                    ],
                ]); ?>

                <?= $form->field($model, 'email')->textInput(['autofocus' => true, 'placeholder' => 'Adresse mail capacités'])->label('<i class="material-icons prefix">account_circle</i> Email') ?>

                <?= $form->field($model, 'password')->passwordInput(['placeholder' => 'Votre mot de passe'])->label('<i class="material-icons prefix">lock</i> Mot de passe')  ?>

                <div class="form-group">
                    <div class="col s12">
                        <p class="center-align">
                            <?= Html::submitButton('Connecter <i class="material-icons right">send</i>', ['class' => 'btn waves-effect waves-light ', 'name' => 'login-button']) ?>
                        </p>
                    </div>
                </div>

                <div class="lighten-5 lostpassword">
                    <?= Html::a('Mot de passe perdu ?', ['resetpassword']) ?>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>