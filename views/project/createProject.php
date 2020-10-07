<?php

use yii\widgets\ActiveForm;
use app\assets\AppAsset;
use app\assets\projects\RefactoringAsset as ProjectsRefactoringAsset;
use app\widgets\TopTitle;
use kartik\select2\Select2;
use yii\bootstrap\Html;

use yii\helpers\ArrayHelper;


/* @var $this yii\web\View */
/* @var $model app\models\devis\Devis */

$this->title = 'Création du projet à partir du devis';

AppAsset::register($this);
ProjectsRefactoringAsset::register($this);

?>

<?= TopTitle::widget(['title' => $this->title]) ?>


<div class="container">
    <div class="devis-update">

        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'], 'id' => 'dynamic-form']); ?>
        <div class="row">

            <div class="col s10 offset-s1">
                <!-- Informations générales -->
                <div id="first-form-card" class="card">

                    <div class="card-content">
                        <label>Informations générales</label>
                    </div>

                    <div class="card-action">

                        <div class="col s12">
                            <div class="row">

                                <div class="input-field col s6">
                                    <?= $form->field($model, 'internal_name')
                                        ->textInput(['maxlength' => true, 'readonly' => true], ['autocomplete' => 'off'])
                                        ->label("Nom du projet")
                                    ?>
                                </div>
                                <div class="input-field col s6">
                                    <?= $form->field($model, 'id_laboxy')
                                        ->textInput(['maxlength' => true, 'readonly' => true], ['autocomplete' => 'off'])
                                        ->label("Référence interne du projet")
                                    ?>
                                </div>

                            </div>
                        </div>

                        <div class="col s12">

                            <div class="row">
                                <div class="input-field col s6">

                                    <?= $form->field($model, 'projectManagerSelectedValue')->widget(
                                        Select2::class,
                                        [
                                            'data' =>  $celluleUsers,
                                            'options' => ['placeholder' => 'Selectionner le responsable du projet ...'],
                                        ]
                                    )->label("Responsable projet"); ?>
                                </div>
                            </div>

                            <div class="row">
                                <div class="input-field col s6">
                                    <?= $form
                                        ->field($model, 'pdfFile')
                                        ->fileInput(['accept' => 'pdf/*'])
                                        ->label('Document technique / Cahier des charges annexe (PDF)', []) ?>
                                </div>
                                <div class="input-field col s6">

                                    <?= $form->field($model, 'file_name')->textInput(['maxlength' => true, 'placeholder' => '', 'readonly' => true])->label('') ?>

                                </div>

                            </div>

                            <div class="col s12">
                                <div class="row">

                                    <div class="input-field col s6">
                                        <?= $form->field($model, 'thematique')
                                            ->textInput(['autocomplete' => 'off'])
                                            ->label("Thématique du projet")
                                        ?>
                                    </div>

                                    <div class="input-field col s6">
                                        <?= $form->field($model, 'signing_probability')->widget(
                                            Select2::class,
                                            [
                                                'theme' => Select2::THEME_MATERIAL,
                                                'name' => 'TaskContributor',
                                                'data' => ["20" => '20 %', "50" => '50 %', "80" => '80 %'],
                                                'options' => ['placeholder' => 'Selectionner un pourcentage ...'],
                                            ]
                                        )->label("Probabilité de signature"); ?>
                                    </div>

                                </div>
                            </div>

                            <div class="col s12">
                                <div class="row">


                                    <div class="input-field col s6">
                                        <?= $form->field($model, "SellingPrice", ['inputOptions' => ['readonly' => true, 'value' => Yii::$app->formatter->asCurrency($model->SellingPrice)]])->label('Prix de vente du projet (HT)') ?>

                                    </div>

                                    <div class="input-field col s6">
                                        <?= $form->field($model, "SellingPrice", ['inputOptions' => ['readonly' => true, 'value' => Yii::$app->formatter->asCurrency($model->SellingPrice * (1 - ($TVA / 100)))]])->label('Prix de vente du projet (TTC)') ?>

                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>

                </div>

                <div class="form-group to-the-right">
                    <?= Html::submitButton('Enregistrer <i class="material-icons right">save</i>', ['class' => 'waves-effect waves-light btn btn-blue']) ?>
                </div>

            </div>

        </div>
        <?php ActiveForm::end(); ?>

    </div>
</div>