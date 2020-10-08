<?php

use app\widgets\TopTitle;
use app\assets\AppAsset;
use app\assets\companies\ContactCreateAsset;
use yii\widgets\ActiveForm;
use yii\helpers\Html;

$this->title = 'Création d\'un contact';

AppAsset::register($this);
ContactCreateAsset::register($this);

?>

<?= TopTitle::widget(['title' => $this->title]) ?>

<div class="contact-create">

    <div class="row">
        <div class="col s6 offset-s3">

            <?php $form = ActiveForm::begin([
                'fieldConfig' => [
                    'labelOptions' => ['class' => 'blue-text control-label'],
                ],
            ]); ?>

            <div class="card">
                <div class="card-action">

                    <!-- firstname field -->
                    <?= $form->field($model, 'firstname')->textInput(['maxlength' => true, 'placeholder' => 'Prénom'])->label('Prénom du contact :') ?>

                    <!-- surname field -->
                    <?= $form->field($model, 'surname')->textInput(['maxlength' => true, 'placeholder' => 'Nom'])->label('Nom du contact :') ?>

                    <!-- phone_number field -->
                    <?= $form->field($model, 'phone_number')->textInput(['maxlength' => true, 'placeholder' => 'Téléphone'])->label('Téléphone du contact :') ?>

                    <!-- email field -->
                    <?= $form->field($model, 'email')->textInput(['maxlength' => true, 'placeholder' => 'Email'])->label('Email du contact :') ?>

                </div>
            </div>

            <div class="form-group to-the-right">
                <?= Html::submitButton('Enregistrer <i class="material-icons right">save</i>', ['class' => 'waves-effect waves-light btn btn-blue']) ?>
                <?= Html::a(Yii::t('app', 'Annuler'), ['view-contacts'], ['class' => 'waves-effect waves-light btn btn-grey']) ?>
            </div>

            <?php ActiveForm::end(); ?>

        </div>
    </div>
</div>