<?php

use app\assets\AppAsset;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use app\widgets\TopTitle;
use Codeception\PHPUnit\ResultPrinter\HTML as ResultPrinterHTML;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\devis\Devis */

$this->title = 'Création d\'un devis';
$this->params['breadcrumbs'][] = ['label' => 'Devis', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

AppAsset::register($this);

?>

<?= TopTitle::widget(['title' => $this->title]) ?>

<div class="container">
    <div class="devis-create">

        <div class="row">
            <div class="col s6 offset-s3">
                <div class="card">

                    <div class="card-content">
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
                            'data' => ArrayHelper::map($delivery_types, 'id', 'label'),
                            'pluginLoading' => false,
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ])->label(
                            "Type de projet",
                            ['for' => 'delivery_type_id']
                        ); ?>

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
                                    'class' => 'waves-effect waves-light btn btn-green',
                                    'data' => [
                                        'confirm' => 'Créer ce devis ?'
                                    ]
                                ]
                            ) ?>

                            <?= Html::a(
                                Yii::t('app', 'Annuler'),
                                ['index'],
                                ['class' => 'waves-effect waves-light btn btn-red']
                            ) ?>

                        </div>
                        <?php ActiveForm::end(); ?>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>