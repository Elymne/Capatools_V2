<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\assets\AppAsset;
use app\assets\companies\CompanyCreateAsset;
use app\services\companyTypeServices\CompanyTypeEnum;
use app\widgets\TopTitle;
use kartik\select2\Select2;

$this->title = 'Créer un client';
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
                            ->textInput(['maxlength' => true, 'autocomplete' => 'off', 'id' => 'name-field'])
                            ->label("Nom du client") ?>

                        <?= $form->field($model, 'email')
                            ->textInput(['maxlength' => true, 'autocomplete' => 'off', 'id' => 'email-field'])
                            ->label("Email") ?>

                        <?= $form->field($model, 'type')->widget(Select2::class, [
                            'data' => CompanyTypeEnum::COMPANY_TYPE_STRING,
                            'pluginLoading' => false,
                            'pluginOptions' => [
                                'allowClear' => false
                            ],
                        ])->label("Type de client"); ?>

                        <br />

                        <?= $form->field($model, 'postal_code')
                            ->textInput(['maxlength' => true, 'autocomplete' => 'off', 'id' => 'postal_code-field'])
                            ->label("Code postal") ?>

                        <?= $form->field($model, 'country')
                            ->textInput(['maxlength' => true, 'autocomplete' => 'off', 'id' => 'country-field'])
                            ->label("Pays") ?>

                        <?= $form->field($model, 'city')
                            ->textInput(['maxlength' => true, 'autocomplete' => 'off', 'id' => 'city-field'])
                            ->label("Ville") ?>

                        <?= $form->field($model, 'tva')
                            ->textInput(['maxlength' => true, 'autocomplete' => 'off', 'id' => 'tva-field'])
                            ->label("TVA") ?>

                        <br />
                        <div class="form-group">

                            <?= Html::submitButton('Enregistrer', ['class' => 'waves-effect waves-light btn btn-blue', 'data' => ['confirm' => 'Créer ce client ?']]) ?>

                            <?= Html::a(Yii::t('app', 'Annuler'), ['index'], ['class' => 'waves-effect waves-light btn btn-grey']) ?>

                            <?php ActiveForm::end(); ?>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>