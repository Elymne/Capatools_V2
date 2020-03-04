<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use app\assets\AppAsset;

$this->title = 'Ajout d\'un client';
$this->params['breadcrumbs'][] = ['label' => 'Devis', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

AppAsset::register($this);

?>

<div class="company-create">
    <div class="devis-create">

        <h1><?= Html::encode($this->title) ?></h1>

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'name')
            ->textInput(['maxlength' => true, 'autocomplete' => 'off'])
            ->label("Nom du client") ?>

        <?= $form->field($model, 'tva')
            ->textInput(['maxlength' => true, 'autocomplete' => 'off'])
            ->label("TVA") ?>

        <?= $form->field($model, 'description')
            ->textInput(['maxlength' => true, 'autocomplete' => 'off'])
            ->label("Description du projet") ?>

        <br /><br /><br />

        <div class="form-group">

            <?= Html::submitButton(
                'Enregistrer',
                [
                    'class' => 'btn btn-success',
                    'data' => [
                        'confirm' => 'Ajouter ce client ?'
                    ]
                ]
            ) ?>

            <?= Html::a(
                Yii::t('app', 'Annuler'),
                [
                    'index'
                ],
                [
                    'class' => 'btn btn-primary'
                ]
            ) ?>

        </div>

        <?php ActiveForm::end(); ?>
    </div>