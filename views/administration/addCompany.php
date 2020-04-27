<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\assets\AppAsset;
use app\assets\companies\CompanyCreateAsset;
use app\helper\_enum\CompanyTypeEnum;
use app\widgets\TopTitle;
use kartik\select2\Select2;

$this->title = 'Ajout d\'un client';
$this->params['breadcrumbs'][] = ['label' => 'User', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

AppAsset::register($this);
CompanyCreateAsset::register($this);

?>

<?= TopTitle::widget(['title' => $this->title]) ?>

<div class="container">
    <div class="company-create">

        <div class="row">
            <div class="col s6 offset-s3">
                <div class="card">

                    <div class="card-action">
                        <?php $form = ActiveForm::begin(); ?>

                        <?= $form->field($model, 'name')
                            ->textInput(['maxlength' => true, 'autocomplete' => 'off'])
                            ->label("Nom du client") ?>

                        <?= $form->field($model, 'type')->widget(Select2::classname(), [
                            'data' => CompanyTypeEnum::COMPANY_TYPE_STRING,
                            'pluginLoading' => false,
                            'pluginOptions' => [
                                'allowClear' => false
                            ],
                            'pluginEvents' => [
                                "select2:select" => "(data) => { console.log(data); }",
                            ]
                        ])->label("Type de client"); ?>

                        <?= $form->field($model, 'tva')
                            ->textInput(['maxlength' => true, 'autocomplete' => 'off'])
                            ->hiddenInput(['id' => 'tva-field'])
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