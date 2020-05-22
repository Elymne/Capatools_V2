<?php

/* @var $this yii\web\View */
/* @var $model app\models\devis\Devis */

use app\assets\AppAsset;
use app\widgets\TopTitle;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;

$this->title = 'Modification des paramètres de devis';
$this->params['breadcrumbs'][] = ['label' => 'DevisParameters', 'url' => ['manage-devis-parameters']];
$this->params['breadcrumbs'][] = 'Update';

AppAsset::register($this);
?>

<?= TopTitle::widget(['title' => $this->title]) ?>

<div class="container">
    <div class="devis-update">

        <div class="row">
            <div class="col s6 offset-s3">

                <?php $form = ActiveForm::begin(['id' => 'dynamic-form', 'options' => ['enctype' => 'multipart/form-data']]); ?>

                <!-- Informations générales -->
                <div class="card">

                    <div class="card-content">
                        <label>Informations générales</label>
                    </div>

                    <div class="card-action">

                        <?= $form->field($model, 'iban')
                            ->textInput(['maxlength' => true], ['autocomplete' => 'off'])
                            ->label("Iban")
                        ?>

                        <?= $form->field($model, 'bic')
                            ->textInput(['maxlength' => true], ['autocomplete' => 'off'])
                            ->label("Bic")
                        ?>

                        <?= $form->field($model, 'banking_domiciliation')
                            ->textInput(['maxlength' => true], ['autocomplete' => 'off'])
                            ->label("Domiciliation bancaire")
                        ?>

                        <?= $form->field($fileCguFrModel, 'cguFrFile')
                            ->label('Ajouter un CGU Français (pdf)', [])
                            ->fileInput([])
                        ?>

                        <?= $form->field($fileCguEnModel, 'cguEnFile')
                            ->label('Ajouter un CGU Anglais (pdf)', [])
                            ->fileInput([])
                        ?>

                        <?= $form->field($model, 'address')
                            ->textInput(['maxlength' => true], ['autocomplete' => 'off'])
                            ->label("Adresse")
                        ?>

                        <?= $form->field($model, 'legal_status')
                            ->textInput(['maxlength' => true], ['autocomplete' => 'off'])
                            ->label("Status juridique")
                        ?>

                        <?= $form->field($model, 'devis_note')
                            ->textInput(['maxlength' => true], ['autocomplete' => 'off'])
                            ->label("Note de devis")
                        ?>

                        <div class="form-group">
                            <?= Html::submitButton('Enregistrer', ['class' => 'waves-effect waves-light btn btn-blue ']) ?>
                            <?= Html::a('Annuler', ['index'], ['class' => 'waves-effect waves-light btn btn-grey']) ?>
                        </div>

                        <?php ActiveForm::end(); ?>

                    </div>

                </div>

            </div>
        </div>

    </div>
</div>