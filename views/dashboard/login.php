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
            <p class="center-align">
                <img src="<?= Html::encode(Yii::$app->homeUrl) ?>images/logo_capa.png" alt="" class="logo"/>
            </p>
            <p class="logo-text">
                FILIALE D'INGÉNIERIE ET DE VALORISATION DE LA RECHERCHE DE L'UNIVERSITÉ DE NANTES
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
                
                <div class="fields">

                    <?= $form->field($model, 'email')->textInput(['autofocus' => true, 'placeholder' => 'ADRESSE MAIL CAPACITÉS'])->label(false) ?>

                    <?= $form->field($model, 'password')->passwordInput(['placeholder' => 'MOT DE PASSE'])->label(false)  ?>
                
                </div>

                <div class="lighten-5 lostpassword">
                    <?= Html::a('Mot de passe oublié ?', ['resetpassword']) ?>
                </div>

                <div class="form-group submit">
                    <div class="col s12">
                        <p class="center-align">
                            <?= Html::submitButton('CONNEXION', ['class' => 'btn waves-effect waves-light ', 'name' => 'login-button']) ?>
                        </p>
                    </div>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
</div>