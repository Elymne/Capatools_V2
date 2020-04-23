<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\assets\AppAsset;
use app\widgets\TopTitle;

$this->title = 'Ajout d\'un client';
$this->params['breadcrumbs'][] = ['label' => 'User', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

AppAsset::register($this);

?>

<?= TopTitle::widget(['title' => $this->title]) ?>

<div class="container">
    <div class="company-create">

        <div class="row">
            <div class="col s6 offset-s3">
                <div class="card">

                    <div class="card-content">
                        <?php $form = ActiveForm::begin(); ?>

                        <?= $form->field($model, 'name')
                            ->textInput(['maxlength' => true, 'autocomplete' => 'off'])
                            ->label("Nom du client") ?>

                        <?= $form->field($model, 'tva')
                            ->textInput(['maxlength' => true, 'autocomplete' => 'off'])
                            ->label("TVA") ?>

                        <?= $form->field($model, 'description')
                            ->textInput(['maxlength' => true, 'autocomplete' => 'off'])
                            ->label("Description du client") ?>

                        <br /><br /><br />

                        <div class="form-group">

                            <?= Html::submitButton('Enregistrer', ['class' => 'waves-effect waves-light btn btn-green', 'data' => ['confirm' => 'Ajouter ce client ?']]) ?>

                            <?= Html::a(Yii::t('app', 'Annuler'), ['index'], ['class' => 'waves-effect waves-light btn btn-red']) ?>

                            <?php ActiveForm::end(); ?>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>