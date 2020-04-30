<?php

use yii\helpers\Html;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use app\assets\AppAsset;
use app\assets\devis\DevisCreateAsset;
use app\helper\_clazz\UserRoleManager;
use app\helper\_enum\UserRoleEnum;
use app\widgets\TopTitle;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\devis\Devis */

$this->title = 'Création';
$this->params['breadcrumbs'][] = ['label' => 'Devis', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';

AppAsset::register($this);
DevisCreateAsset::register($this);

?>

<?= TopTitle::widget(['title' => $this->title]) ?>

<div class="container">
    <div class="devis-update">

        <div class="row">
            <div class="col s6 offset-s3">

                <?php $form = ActiveForm::begin(['id' => 'dynamic-form', 'options' => ['enctype' => 'multipart/form-data']]); ?>

                <div class="card">

                    <div class="card-content">
                        <label>Informations générales</label>
                    </div>

                    <div class="card-action">

                        <?= $form->field($model, 'internal_name')
                            ->textInput(['maxlength' => true], ['autocomplete' => 'off'])
                            ->label("Nom du projet")
                        ?>

                        <?= $form->field($model, 'delivery_type_id')->widget(Select2::class, [
                            'data' => ArrayHelper::map($delivery_types, 'id', 'label'),
                            'pluginLoading' => false,
                            'pluginOptions' => [
                                'allowClear' => false
                            ],
                        ])->label(
                            "Type de projet",
                            ['for' => 'delivery_type_id']
                        ); ?>

                        <?= $form->field($model, 'laboratory_proposal')
                            ->textarea(['maxlength' => true, 'rows' => 6])
                            ->label("Proposition du laboratoire")
                        ?>

                        <?= $form->field($model, 'company_name')
                            ->widget(\yii\jui\AutoComplete::classname(), [
                                'clientOptions' => [
                                    'source' => $companiesNames,
                                ],
                            ])->label(
                                "Client"
                            );
                        ?>

                    </div>

                </div>

                <div class="card">

                    <div class="card-content">
                        <label>Informations de la prestation</label>
                    </div>

                    <div class="card-action">

                        <div class="row">
                            <div class="col s12">

                                <div class="row">
                                    <div class="input-field col s6">
                                        <?= $form->field($model, 'service_duration')
                                            ->input('number', ['min' => 0, 'max' => 10000, 'step' => 1, 'autocomplete' => 'off', 'onkeyup' => 'prestaDurationCalcul()'])
                                            ->label("Durée de la prestation (h)")
                                        ?>
                                    </div>
                                    <div class="input-field col s6">
                                        <?= Html::input('text', 'textinput_service_duration_daytype', "", [
                                            'id' => 'service-duration-day',
                                            'maxlength' => 10,
                                            'placeholder' => 'Calcul en durée jour',
                                            'disabled' => true
                                        ]); ?>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <?= $form->field($model, 'validity_duration')
                            ->input('number', ['min' => 0, 'max' => 100000, 'step' => 1, 'autocomplete' => 'off'])
                            ->label("Validité du devis (j)")
                        ?>

                        <?= $form->field($model, 'payment_conditions')
                            ->textarea(['maxlength' => true, 'rows' => 6])
                            ->label("Conditions de paiement")
                        ?>

                        <?= $form->field($model, 'price')
                            ->input('number', ['min' => 0, 'max' => 1000000000, 'step' => 1, 'autocomplete' => 'off'])
                            ->label("Validité du devis (j)")
                        ?>

                        <?= $form->field($model, 'payment_details')
                            ->textarea(['maxlength' => true, 'rows' => 6])
                            ->label("Conditions de paiement")
                        ?>

                    </div>

                </div>

                <?php if (UserRoleManager::hasRoles([UserRoleEnum::PROJECT_MANAGER_DEVIS, UserRoleEnum::OPERATIONAL_MANAGER_DEVIS])) { ?>
                    <div class="card">

                        <div class="card-action">
                            <?= $form->field($fileModel, 'file')
                                ->label('Ajouter un document annexe', [])
                                ->fileInput([])
                            ?>
                        </div>

                    </div>
                <?php } ?>

                <div class="form-group">
                    <?= Html::submitButton('Enregistrer', ['class' => 'waves-effect waves-light btn btn-blue ']) ?>
                    <?= Html::a('Annuler', ['index'], ['class' => 'waves-effect waves-light btn btn-grey']) ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>

    </div>
</div>