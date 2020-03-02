<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use app\assets\AppAsset;

/* @var $this yii\web\View */
/* @var $model app\models\devis\Devis */

$this->title = 'Création d\'un devis';
$this->params['breadcrumbs'][] = ['label' => 'Devis', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

AppAsset::register($this);

?>
<div class="devis-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'internal_name')
        ->textInput(['maxlength' => true, 'autocomplete' => 'off'])
        ->label("Nom du projet")
    ?>

    <?= $form->field($model, 'delivery_type_id')
        ->dropDownList(ArrayHelper::map($delivery_type, 'id', 'label'), ['text' => 'Please select'])
        ->label('Type de livraison');
    ?>

    <?= $form->field($model, 'company_name')
        ->widget(\yii\jui\AutoComplete::classname(), [
            'clientOptions' => [
                'source' => $companiesNames,
            ],
        ])
        ->label("Nom du client")
    ?>

    <?= Html::a('Ajouter un client', ['devis/add-company'], ['class' => 'profile-link']) ?>

    <br /><br /><br />

    <div class="form-group">

        <?= Html::submitButton(
            'Enregistrer',
            [
                'class' => 'btn btn-success',
                'data' => [
                    'confirm' => 'Créer ce devis ?'
                ]
            ]
        ) ?>

        <?= Html::a(
            Yii::t('app', 'Annuler'),
            [
                'create'
            ],
            [
                'class' => 'btn btn-primary'
            ]
        ) ?>

    </div>

    <?php ActiveForm::end(); ?>

</div>