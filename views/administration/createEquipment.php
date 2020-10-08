<?php

use app\widgets\TopTitle;
use app\assets\AppAsset;
use app\assets\administration\EquipmentCreateAsset;
use kartik\select2\Select2;
use yii\widgets\ActiveForm;
use yii\helpers\Html;

$this->title = 'Création d\'un matériel';

AppAsset::register($this);
EquipmentCreateAsset::register($this);

?>

<?= TopTitle::widget(['title' => $this->title]) ?>

<div class="company-create">

    <div class="row">
        <div class="col s6 offset-s3">

            <?php $form = ActiveForm::begin([
                'fieldConfig' => [
                    'labelOptions' => ['class' => 'blue-text control-label'],
                ],
            ]); ?>

            <div class="card">

                <div class="card-action">

                    <!-- name field -->
                    <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'placeholder' => 'Nom'])->label('Nom du matériel :') ?>

                    <!-- ht_price field -->
                    <?= $form->field($model, 'price_day')->input('number', ['maxlength' => true, 'placeholder' => 'Prix hors taxes'])->label('Prix journalier hors taxes du matériel :') ?>

                    <!-- ht_price field -->
                    <?= $form->field($model, 'price_hour')->input('number', ['maxlength' => true, 'placeholder' => 'Prix hors taxes'])->label('Prix journalier hors taxes du matériel :') ?>

                    <!-- type field -->
                    <?= $form->field($model, 'type')->textInput(['maxlength' => true, 'placeholder' => 'Type'])->label('Type de matériel :') ?>

                    <?= $form->field($model, "laboratory")->widget(Select2::class, [
                        'data' => $laboratoriesName,
                        'pluginLoading' => false,
                        'pluginOptions' => [
                            'allowClear' => false
                        ],
                    ])->label(
                        "Laboratoire"
                    ); ?>

                </div>

            </div>

            <div class="form-group to-the-right">
                <?= Html::submitButton('Enregistrer <i class="material-icons right">save</i>', ['class' => 'waves-effect waves-light btn btn-blue']) ?>
                <?= Html::a(Yii::t('app', 'Annuler'), ['index-equipments'], ['class' => 'waves-effect waves-light btn btn-grey']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>