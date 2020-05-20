<?php

use yii\helpers\Html;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use app\assets\AppAsset;
use app\assets\devis\DevisUpdateAsset;
use app\helper\_clazz\UserRoleManager;
use app\helper\_enum\UserRoleEnum;
use app\models\devis\UploadFile;
use app\widgets\TopTitle;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\devis\Devis */

$this->title = 'Modification : ' . $model->id_capa;
$this->params['breadcrumbs'][] = ['label' => 'Devis', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';

AppAsset::register($this);
DevisUpdateAsset::register($this);

?>

<?= TopTitle::widget(['title' => $this->title]) ?>

<div class="container">
    <div class="devis-update">

        <div class="row">
            <div class="col s6 offset-s3">

                <?php $form = ActiveForm::begin(['id' => 'dynamic-form', 'options' => ['enctype' => 'multipart/form-data']]); ?>

                <!-- Informations générales -->
                <div class="card">

                    <div class="card-content">
                        <label>Informations générales</label>
                    </div>

                    <div class="card-action">

                        <?= $form->field($model, 'internal_name')
                            ->textInput(['maxlength' => true], ['autocomplete' => 'off'])
                            ->label("Nom du projet")
                        ?>

                        <?= $form->field($model, 'task_description')
                            ->textarea(['maxlength' => true, 'rows' => 6])
                            ->label("Description des tâches")
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

                <!-- Informations prestation -->
                <div class="card">

                    <div class="card-content">
                        <label>Informations de la prestation</label>
                    </div>

                    <div class="card-action">

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
                                            ->input('number', ['min' => 0, 'max' => 10000, 'step' => 1, 'autocomplete' => 'off'])
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

                        <?= $form->field($model, 'validity_duration')
                            ->input('number', ['min' => 0, 'max' => 100000, 'step' => 1, 'autocomplete' => 'off'])
                            ->label("Validité du devis (j)")
                        ?>

                        <?= $form->field($model, 'payment_conditions')
                            ->textarea(['maxlength' => true, 'rows' => 6])
                            ->label("Conditions de paiement")
                        ?>

                        <?= $form->field($model, 'quantity')
                            ->input('number', ['min' => 0, 'max' => 1000000000, 'step' => 1, 'autocomplete' => 'off'])
                            ->label("Quantité")
                        ?>

                        <?= $form->field($model, 'unit_price')
                            ->input('number', ['min' => 0, 'max' => 1000000000, 'step' => 1, 'autocomplete' => 'off'])
                            ->label("Prix")
                        ?>

                        <?= $form->field($model, 'payment_details')
                            ->textarea(['maxlength' => true, 'rows' => 6])
                            ->label("Détails de paiement")
                        ?>

                    </div>

                </div>

                <!-- Gestion fichier index -->
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

                <!-- Gestion des jalons -->
                <?php if (UserRoleManager::hasRoles([UserRoleEnum::PROJECT_MANAGER_DEVIS, UserRoleEnum::OPERATIONAL_MANAGER_DEVIS])) { ?>
                    <div class="card">

                        <div class="card-content">
                            <label>Echéancier de paiement</label>
                        </div>

                        <div class="card-action">
                            <?php DynamicFormWidget::begin([
                                'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                                'widgetBody' => '.container-items', // required: css class selector
                                'widgetItem' => '.item', // required: css class
                                'limit' => 4, // the maximum times, an element can be cloned (default 999)
                                'min' => 1, // 0 or 1 (default 1)
                                'insertButton' => '.add-item', // css class
                                'deleteButton' => '.remove-item', // css class
                                'model' => $milestones[0],
                                'formId' => 'dynamic-form',
                                'formFields' => [
                                    'id',
                                    'prix_jalon',
                                    'price',
                                    'delivery_date',
                                    'comments'
                                ],
                            ]); ?>

                            <div class="container-items">
                                <!-- widgetContainer -->
                                <?php foreach ($milestones as $i => $milestone) : ?>
                                    <div class="item panel panel-default">
                                        <!-- widgetBody -->
                                        <div class="panel-heading">
                                            <h3 class="panel-title pull-left">Jalon </h3>
                                            <div class="pull-right">
                                                <button type="button" class="add-item waves-effect waves-light btn btn-grey"><i class="glyphicon glyphicon-plus"></i></button>
                                                <button type="button" class="remove-item waves-effect waves-light btn btn-grey"><i class="glyphicon glyphicon-minus"></i></button>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="panel-body">
                                            <?php
                                            // necessary for update action.
                                            if (!$milestone->isNewRecord) {
                                                echo Html::activeHiddenInput($milestone, "[{$i}]id");
                                            }
                                            ?>

                                            <div class="row">
                                                <div>
                                                    <?= $form->field($milestone, "[{$i}]label")->textInput(['autocomplete' => 'off', 'maxlength' => true])->label('Nom du jalon') ?>
                                                    <?= $form->field($milestone, "[{$i}]price")->textInput(['class' => 'priceHt', 'autocomplete' => 'off', 'maxlength' => true])->label('Prix HT') ?>
                                                    <?= $form->field($milestone, "[{$i}]comments")->textarea(['autocomplete' => 'off', 'maxlength' => true])->label('Commentaire') ?>
                                                </div>
                                            </div><!-- .row -->

                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>

                            <?php DynamicFormWidget::end(); ?>
                        </div>
                    </div>
                <?php } ?>

                <!-- Gestion des intervenants projets -->
                <?php if (UserRoleManager::hasRoles([UserRoleEnum::PROJECT_MANAGER_DEVIS, UserRoleEnum::OPERATIONAL_MANAGER_DEVIS])) { ?>
                    <div class="card">

                        <div class="card-content">
                            <label>Ajouter des Intervenants</label>
                        </div>

                        <div class="card-action">
                            <?php DynamicFormWidget::begin([
                                'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                                'widgetBody' => '.container-items-two', // required: css class selector
                                'widgetItem' => '.item', // required: css class
                                'limit' => 5, // the maximum times, an element can be cloned (default 999)
                                'min' => 1, // 0 or 1 (default 1)
                                'insertButton' => '.add-item', // css class
                                'deleteButton' => '.remove-item', // css class
                                'model' => $contributors[0],
                                'formId' => 'dynamic-form',
                                'formFields' => [
                                    'id',
                                    'username',
                                    'nb_day',
                                ],
                            ]); ?>

                            <div class="container-items-two">
                                <!-- widgetContainer -->
                                <?php foreach ($contributors as $i => $contributor) : ?>
                                    <div class="item panel panel-default">
                                        <!-- widgetBody -->
                                        <div class="panel-heading">
                                            <h3 class="panel-title pull-left">Intervenant</h3>
                                            <div class="pull-right">
                                                <button type="button" class="add-item waves-effect waves-light btn btn-grey"><i class="glyphicon glyphicon-plus"></i></button>
                                                <button type="button" class="remove-item waves-effect waves-light btn btn-grey"><i class="glyphicon glyphicon-minus"></i></button>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="panel-body">
                                            <?php
                                            // necessary for update action.
                                            if (!$contributor->isNewRecord) {
                                                echo Html::activeHiddenInput($contributor, "[{$i}]id");
                                            }
                                            ?>

                                            <div class="row">
                                                <div>
                                                    <?= $form->field($contributor, "[{$i}]username")->widget(\yii\jui\AutoComplete::classname(), ['clientOptions' => ['source' => $usersNames,]])->label('Nom de l\'utilisateur'); ?>
                                                    <?= $form->field($contributor, "[{$i}]nb_day")->textInput(['autocomplete' => 'off', 'maxlength' => true])->label('Nombre de jours') ?>
                                                </div>
                                            </div><!-- .row -->

                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>

                            <?php DynamicFormWidget::end(); ?>
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

<?php

/**
 * Get filename if it exists, else return "none" value.
 */
function getFileName(int $id): string
{

    $file = UploadFile::getByDevis($id);

    if ($file == null) {
        return 'aucun';
    } else {
        return $file->getFullFilename();
    }
}
