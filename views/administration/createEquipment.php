<?php

use app\widgets\TopTitle;
use app\assets\AppAsset;
use app\assets\administration\EquipmentCreateAsset;
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
            <div class="card">

                <div class="card-action">

                    <?php $form = ActiveForm::begin([
                        'fieldConfig' => [
                            'labelOptions' => ['class' => 'blue-text control-label'],
                        ],
                    ]); ?>

                    <!-- name field -->
                    <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'placeholder' => 'Nom'])->label('Nom du matériel :') ?>

                    <!-- ht_price field -->
                    <?= $form->field($model, 'ht_price')->input('number', ['maxlength' => true, 'placeholder' => 'Prix hors taxes'])->label('Prix journalier hors taxes du matériel :') ?>

                    <!-- type field -->
                    <?= $form->field($model, 'type')->textInput(['maxlength' => true, 'placeholder' => 'Type'])->label('Type de matériel :') ?>

                    <div class="form-group">
                        <?= Html::submitButton('Enregistrer <i class="material-icons right">save</i>', ['class' => 'waves-effect waves-light btn btn-blue']) ?>

                        <?= Html::a(Yii::t('app', 'Annuler'), ['view-equipments'], ['class' => 'waves-effect waves-light btn btn-grey']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>

                </div>
            </div>
        </div>
    </div>
</div>