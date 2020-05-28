<?php

use yii\widgets\ActiveForm;
use app\assets\AppAsset;
use app\assets\devis\RefactoringAsset;
use app\widgets\TopTitle;
use kartik\select2\Select2;
use yii\bootstrap\Html;

/* @var $this yii\web\View */
/* @var $model app\models\devis\Devis */

$this->title = 'Création';

AppAsset::register($this);
RefactoringAsset::register($this);

?>

<?= TopTitle::widget(['title' => $this->title]) ?>


<div class="container">
    <div class="devis-update">

        <?php $form = ActiveForm::begin(['id' => 'dynamic-form', 'options' => ['enctype' => 'multipart/form-data']]); ?>
        <div class="row">

            <div id="stepform" class="col s10 offset-s1">

                <!-- Informations générales -->
                <div class="card">

                    <div class="card-content">
                        <label>Informations générales</label>
                    </div>

                    <div class="card-action">

                        <div class="col s12">
                            <div class="row">

                                <div class="input-field col s6">
                                    <?= $form->field($model, 'internal_name')
                                        ->textInput(['maxlength' => true], ['autocomplete' => 'off'])
                                        ->label("Nom du projet")
                                    ?>
                                </div>
                                <div class="input-field col s6">
                                    <?= $form->field($model, 'ref_interne')
                                        ->textInput(['maxlength' => true], ['autocomplete' => 'off'])
                                        ->label("Référence interne du projet")
                                    ?>
                                </div>

                            </div>
                        </div>

                        <div class="col s12">
                            <div class="row">

                                <div class="input-field col s6">
                                    <?= $form->field($model, 'company_name')
                                        ->widget(\yii\jui\AutoComplete::classname(), [
                                            'clientOptions' => [
                                                'source' => ['10 %', '20 %', '30 %', '40 %', '50 %', '60 %', '70 %', '80 %'],
                                            ],
                                        ])->label(
                                            "Client"
                                        );
                                    ?>
                                </div>
                                <div class="input-field col s6">
                                    <?= $form->field($model, 'proba')->widget(Select2::classname(), [
                                        'data' => ['10 %', '20 %', '30 %', '40 %', '50 %', '60 %', '70 %', '80 %'],
                                        'language' => 'de',
                                        'options' => ['placeholder' => 'Select a state ...'],
                                        'pluginOptions' => [
                                            'allowClear' => true
                                        ],
                                    ]); ?>
                                </div>

                            </div>
                        </div>

                        <div class="col s12">
                            <div class="row">

                                <div class="input-field col s6">
                                    <?= Html::a('Créer un client', [''], ['class' => '']) ?>
                                </div>
                                <div class="input-field col s6">
                                    <?= Html::a('Créer un contact', [''], ['class' => '']) ?>
                                </div>

                            </div>
                        </div>

                        <div class="col s12">
                            <div class="row">

                                <div class="input-field col s1 offset-s11">
                                    <?= Html::a('Suivant', [''], ['class' => 'form-next-page']) ?>
                                </div>

                            </div>
                        </div>

                    </div>

                </div>

            </div>

        </div>
        <?php ActiveForm::end(); ?>

    </div>
</div>