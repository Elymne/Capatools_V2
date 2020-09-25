<?php

use app\widgets\TopTitle;
use app\assets\AppAsset;
use app\assets\administration\DocumentCreateAsset;
use kartik\select2\Select2;
use yii\widgets\ActiveForm;
use yii\helpers\Html;

if ($update) {
    $this->title = 'Mise à jour d\'un document';
} else {
    $this->title = 'Création d\'un document';
}

AppAsset::register($this);
DocumentCreateAsset::register($this);

?>

<?= TopTitle::widget(['title' => $this->title]) ?>

<div class="company-create">

    <div class="row">
        <div class="col s6 offset-s3">
            <div class="card">

                <div class="card-action">

                    <?php $form = ActiveForm::begin([
                        'fieldConfig' => [
                            'labelOptions' => ['class' => 'blue-text control-label'],
                        ],
                    ]); ?>
                    <div class="col s12">
                        <div class="row">
                            <div class="input-field col s12">


                                <?= Html::activeHiddenInput($model, "id"); ?>
                                <?= $form->field($model, 'title')->textInput(['maxlength' => true, 'placeholder' => 'Titre'])->label('Nom du document :') ?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="input-field col s6">

                                <?= $form->field($model, 'type')->textInput(['maxlength' => true, 'placeholder' => 'type'])->label('Type du document :') ?>


                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s6">
                                <!-- file field -->
                                <?= $form
                                    ->field($model, 'File')
                                    ->fileInput(['accept' => '*'])
                                    ->label('Document :', []) ?>

                            </div>
                            <div class="input-field col s6">
                                <?php if ($update) { ?>
                                    <?= $form->field($model, 'internal_link')->textInput(['maxlength' => true, 'placeholder' => 'Titre', 'readonly' => true])->label('') ?>
                                <?php } ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <?= Html::submitButton('Enregistrer <i class="material-icons right">save</i>', ['class' => 'waves-effect waves-light btn btn-blue']) ?>

                            <?= Html::a(Yii::t('app', 'Annuler'), ['index-document'], ['class' => 'waves-effect waves-light btn btn-grey']) ?>
                        </div>

                        <?php ActiveForm::end(); ?>



                    </div>
                </div>
            </div>