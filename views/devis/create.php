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
        <?php $form = ActiveForm::begin(['id' => 'dynamic-form', 'options' => ['enctype' => 'multipart/form-data']]); ?>
        <div class="row">

            <div id="stepform" class="col s8 offset-s2">

                <h3>Informations générales</h3>
                <section>
                    <?= $form->field($model, 'internal_name')
                        ->textInput(['maxlength' => true], ['autocomplete' => 'off'])
                        ->label("Nom du projet")
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

                    <?= $form->field($model, 'task_description')
                        ->textarea(['maxlength' => true, 'rows' => 6])
                        ->label("Description des tâches")
                    ?>

                    <?php if (UserRoleManager::hasRoles([UserRoleEnum::PROJECT_MANAGER_DEVIS, UserRoleEnum::ADMINISTRATOR, UserRoleEnum::SUPER_ADMINISTRATOR])) { ?>
                        <?= Html::a('Créer un client', ['administration/add-company'], ['class' => '']) ?>
                    <?php } ?>

                </section>

                <h3>Informations sur la prestation</h3>
                <section>
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

                    <div class="row">
                        <div class="col s12">

                            <div class="row">
                                <div class="input-field col s6">
                                    <?= $form->field($model, 'service_duration')
                                        ->input('number', ['min' => 0, 'max' => 23, 'step' => 1, 'autocomplete' => 'off'])
                                        ->label("Durée de la prestation (heures)")
                                    ?>
                                </div>
                                <div class="input-field col s6">
                                    <?= $form->field($model, 'service_duration_day')
                                        ->input('number', ['min' => 0, 'max' => 10000, 'step' => 1, 'autocomplete' => 'off'])
                                        ->label("Durée de la prestation (jours)")
                                    ?>
                                </div>
                            </div>

                        </div>
                    </div>

                    <?= $form->field($model, 'quantity')
                        ->input('number', ['min' => 0, 'max' => 1000000000, 'step' => 1, 'autocomplete' => 'off'])
                        ->label("Quantité")
                    ?>

                    <?= $form->field($model, 'unit_price')
                        ->input('number', ['min' => 0, 'max' => 1000000000, 'step' => 1, 'autocomplete' => 'off'])
                        ->label("Prix unitaire")
                    ?>

                </section>

                <?php if (UserRoleManager::hasRoles([UserRoleEnum::PROJECT_MANAGER_DEVIS, UserRoleEnum::OPERATIONAL_MANAGER_DEVIS])) { ?>
                    <h3>Importation de fichier</h3>
                    <section>
                        <?= $form->field($fileModel, 'file')
                            ->label('Ajouter un document annexe (descriptif technique, cahier des charges)', [])
                            ->fileInput([])
                        ?>
                    </section>
                <?php } ?>

                <h3>Finalisation du devis</h3>
                <section>
                    <br />
                    <div class="form-group centrage">
                        <?= Html::submitButton('Enregistrer', ['class' => 'waves-effect waves-light btn btn-blue ']) ?>
                        <?= Html::a('Annuler', ['index'], ['class' => 'waves-effect waves-light btn btn-grey']) ?>
                    </div>
                </section>
            </div>

        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>