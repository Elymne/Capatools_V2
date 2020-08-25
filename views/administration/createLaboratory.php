<?php

use app\widgets\TopTitle;
use app\assets\AppAsset;
use app\assets\administration\LaboratoryCreateAsset;
use kartik\select2\Select2;
use yii\widgets\ActiveForm;
use yii\helpers\Html;

$this->title = 'Création d\'un laboratoire';

AppAsset::register($this);
LaboratoryCreateAsset::register($this);

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

                    <!-- name field -->
                    <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'placeholder' => 'Nom'])->label('Nom du laboratoire :') ?>

                    <!-- ht_price field -->
                    <?= $form->field($model, 'price_contributor_day')->input('number', ['maxlength' => true, 'placeholder' => 'Prix hors taxes'])->label('Prix journalier du laboratoire :') ?>

                    <!-- ht_price field -->
                    <?= $form->field($model, 'price_contributor_hour')->input('number', ['maxlength' => true, 'placeholder' => 'Prix hors taxes'])->label('Prix journalier du laboratoire :') ?>

                    <!-- ht_price field -->
                    <?= $form->field($model, 'price_ec_day')->input('number', ['maxlength' => true, 'placeholder' => 'Prix hors taxes'])->label('Prix journalier du matériel (EC) :') ?>

                    <!-- ht_price field -->
                    <?= $form->field($model, 'price_ec_hour')->input('number', ['maxlength' => true, 'placeholder' => 'Prix hors taxes'])->label('Prix journalier du matériel (EC) :') ?>

                    <?= $form->field($model, "celluleSelect")->widget(Select2::class, [
                        'data' => $cellulesName,
                        'pluginLoading' => false,
                        'pluginOptions' => [
                            'allowClear' => false
                        ],
                    ])->label(
                        "Cellule"
                    ); ?>

                    <div class="form-group">
                        <?= Html::submitButton('Enregistrer <i class="material-icons right">save</i>', ['class' => 'waves-effect waves-light btn btn-blue']) ?>

                        <?= Html::a(Yii::t('app', 'Annuler'), ['index-equipments'], ['class' => 'waves-effect waves-light btn btn-grey']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>

                </div>
            </div>
        </div>
    </div>
</div>