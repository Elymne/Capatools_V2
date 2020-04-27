<?php

use yii\helpers\Html;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use app\assets\AppAsset;
use app\assets\devis\DevisCreateAsset;
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

                        <?= $form->field($model, 'internal_name')
                            ->textInput(['maxlength' => true, 'disabled' => true], ['autocomplete' => 'off'])
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

                        <?= $form->field($model, 'company_name')
                            ->widget(\yii\jui\AutoComplete::classname(), [
                                'clientOptions' => [
                                    'source' => $companiesNames,
                                ],
                            ])->label(
                                "Client"
                            ); ?>

                        <?= $form->field($model, 'service_duration')
                            ->textInput(['autocomplete' => 'off'])
                            ->label("Durée de la prestation (j)")
                        ?>

                    </div>

                </div>

                <?php if (UserRoleManager::hasRoles([UserRoleEnum::PROJECT_MANAGER_DEVIS, UserRoleEnum::OPERATIONAL_MANAGER_DEVIS])) { ?>
                    <div class="card">

                        <div class="card-content">
                            <span>Uploader un fichier</span>
                            <p>Fichier actuellement stocké : <?php echo getFileName($model->id) ?></p>
                        </div>

                        <div class="card-action">
                            <?= $form->field($fileModel, 'file')
                                ->label('Upload un fichier', [])
                                ->fileInput([])
                            ?>
                        </div>

                    </div>
                <?php } ?>

                <?php if (UserRoleManager::hasRoles([UserRoleEnum::PROJECT_MANAGER_DEVIS, UserRoleEnum::OPERATIONAL_MANAGER_DEVIS])) { ?>
                    <div class="card">

                        <div class="card-content">
                            <span>Jalons</span>
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
                                                <button type="button" class="add-item waves-effect waves-light btn btn-green"><i class="glyphicon glyphicon-plus"></i></button>
                                                <button type="button" class="remove-item waves-effect waves-light btn red"><i class="glyphicon glyphicon-minus"></i></button>
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
                                                    <?= $form->field($milestone, "[{$i}]label")->textInput(['autocomplete' => 'off', 'maxlength' => true])->label('Label') ?>
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

                <div class="form-group">
                    <?= Html::submitButton('Enregistrer', ['class' => 'waves-effect waves-light btn btn-green ']) ?>
                    <?= Html::a('Annuler', ['index'], ['class' => 'waves-effect waves-light btn btn-red']) ?>
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
