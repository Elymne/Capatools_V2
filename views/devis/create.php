<?php

use yii\helpers\Html;

use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\devis\Devis */

$this->title = 'Création d\'un devis';
$this->params['breadcrumbs'][] = ['label' => 'Devis', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

var_dump($companies);
?>
<div class="devis-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'internal_name')->textInput(['maxlength' => true, 'autocomplete' => 'off'])->label("Nom du projet") ?>
    <?= $form->field($model, 'delivery_type_id')->dropDownList(ArrayHelper::map($delivery_type, 'id', 'label'), ['text' => 'Please select'])->label('');   ?>
    <?=
        $form
            ->field($model, 'company_name')
            ->textInput(['autocomplete' => 'off'])
            ->widget(\yii\jui\AutoComplete::classname(), [
                'clientOptions' => [
                    'source' => [$companies],
                    'autoFill' => false,
                ],
            ])
            ->label("Nom du client")
    ?>
    <?= $form->field($model, 'company_tva')->textInput(['autocomplete' => 'off'])->label("TVA") ?>


    <div class="form-group">
        <?= Html::submitButton('Enregistrer', ['class' => 'btn btn-success']) ?>
        <?= Html::a(Yii::t('app', 'Annuler'), ['index'], ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>