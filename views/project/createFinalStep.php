<?php

use app\assets\AppAsset;
use app\assets\projects\ProjectCreateFinalStepAsset;
use app\models\projects\Project;
use app\widgets\TopTitle;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\bootstrap\Html;
use yii\widgets\ActiveForm;

$this->title = 'Création d\'un projet - finalisation du projet';
$this->params['breadcrumbs'][] = ['label' => 'Project', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';

AppAsset::register($this);
ProjectCreateFinalStepAsset::register($this);
?>

<?= TopTitle::widget(['title' => $this->title]) ?>
<div class="container">
    <div class="project-create">
        <?php $form = ActiveForm::begin(['id' => 'dynamic-form', 'options' => ['enctype' => 'multipart/form-data']]); ?>
        <div class="row">
            <div class="col s10 offset-s1">

                <!-- Card view basique -->
                <div class="card">

                    <div class="card-action">

                        <div class="col s12">
                            <div class="row">
                                <div class="input-field col s6">
                                    <!-- Nom du projet interne -->
                                    <?= $form->field($model, 'internal_name')->textInput(['maxlength' => true], ['autocomplete' => 'off'])->label("Nom du projet ou référence interne") ?>
                                    <!-- Nom du client -->
                                    <?= $form->field($model, 'company_name')
                                        ->widget(\yii\jui\AutoComplete::classname(), [
                                            'clientOptions' => ['source' => $clientsName,],
                                        ])->label(
                                            "Nom du client"
                                        );
                                    ?>
                                    <!-- Contact du client -->
                                    <?= $form->field($model, 'contact_name')
                                        ->widget(\yii\jui\AutoComplete::classname(), [
                                            'clientOptions' => ['source' => $clientsName,],
                                        ])->label(
                                            "Contact client (nom de famille)"
                                        );
                                    ?>
                                </div>
                                <div class="input-field col s6">
                                    <!-- Commentaire -->
                                    <?= $form->field($model, 'commentary')->textarea(['maxlength' => true], ['autocomplete' => 'off'])->label("") ?>
                                </div>
                            </div>
                        </div>


                        <!-- Buttons -->
                        <div class="form-group">
                            <?= Html::submitButton('Enregistrer <i class="material-icons right">save</i>', ['class' => 'waves-effect waves-light btn btn-blue']) ?>
                            <?= Html::a(Yii::t('app', 'Annuler'), ['#'], ['class' => 'waves-effect waves-light btn btn-grey']) ?>
                        </div>

                    </div>

                </div>

            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>