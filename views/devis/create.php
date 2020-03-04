<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use app\assets\AppAsset;
use yiiui\yii2materializeselect2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\devis\Devis */

$this->title = 'Création d\'un devis';
$this->params['breadcrumbs'][] = ['label' => 'Devis', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

AppAsset::register($this);

?>
<div class="devis-create">

    <div class="row">
        <div class="col s6 offset-s3">
            <div class="card">

                <div class="card-content">
                    <span class="card-title"><?= Html::encode($this->title) ?></span>
                </div>

                <div class="card-action">
                    <?php $form = ActiveForm::begin(); ?>

                    <?= $form->field($model, 'internal_name')
                        ->textInput(
                            ['maxlength' => true, 'autocomplete' => 'off', 'id' => 'internal_name', 'type' => "text"]
                        )
                        ->label(
                            "Nom du projet",
                            ['for' => 'internal_name']
                        )
                    ?>

                    <?= $form->field($model, 'delivery_type_id')->widget(Select2::class, [
                        'items' => ArrayHelper::map($delivery_type, 'id', 'label'),
                        'clientOptions' => [
                            'allowClear' => true
                        ],
                    ]);
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
                                'class' => 'waves-effect waves-light btn',
                                'data' => [
                                    'confirm' => 'Créer ce devis ?'
                                ]
                            ]
                        ) ?>

                        <?= Html::a(
                            Yii::t('app', 'Annuler'),
                            ['index'],
                            ['class' => 'waves-effect waves-light btn']
                        ) ?>

                    </div>
                    <?php ActiveForm::end(); ?>
                </div>

            </div>
        </div>
    </div>

</div>