<?php

use app\assets\AppAsset;
use app\assets\projects\ProjectCreateFirstPhaseAsset;
use app\models\projects\Project;
use app\widgets\TopTitle;
use yii\bootstrap\Html;
use yii\widgets\ActiveForm;

$this->title = 'Création d\'un projet - paramètres généraux';
$this->params['breadcrumbs'][] = ['label' => 'Devis', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';

AppAsset::register($this);
ProjectCreateFirstPhaseAsset::register($this);

?>

<?= TopTitle::widget(['title' => $this->title]) ?>
<div class="container">
    <div class="project-create">
        <?php $form = ActiveForm::begin(['id' => 'dynamic-form', 'options' => ['enctype' => 'multipart/form-data']]); ?>
        <div class="row">
            <div class="col s10 offset-s1">

                <!-- Card view basique -->
                <div class="card">

                    <div class="card-content">
                        <label>Informations générales</label>
                    </div>

                    <div class="card-action">

                        <!-- TODO Utiliser des comboboxs -->
                        <label class='blue-text control-label typeLabel'>Type de projet</label>
                        <div class="col s12">
                            <div class="row">

                                <div class="col s3">
                                    <?php $comboboxLabel = '<span>Prestation</span>'; ?>
                                    <?= $form->field($model, 'type')->radio([
                                        'label' => $comboboxLabel
                                    ]) ?>
                                </div>
                                <div class="col s3">
                                    <?php $comboboxLabel = '<span>Sous traitance UN</span>'; ?>
                                    <?= $form->field($model, 'type')->radio([
                                        'label' => $comboboxLabel
                                    ]) ?>
                                </div>
                                <div class="col s3">
                                    <?php $comboboxLabel = '<span>Sous traitance AD</span>'; ?>
                                    <?= $form->field($model, 'type')->radio([
                                        'label' => $comboboxLabel
                                    ]) ?>
                                </div>
                                <div class="col s3">
                                    <?php $comboboxLabel = '<span>Interne</span>'; ?>
                                    <?= $form->field($model, 'type')->radio([
                                        'label' => $comboboxLabel
                                    ]) ?>
                                </div>
                            </div>
                        </div>


                        <div class="form-group">
                            <?= Html::submitButton('Enregistrer <i class="material-icons right">save</i>', ['class' => 'waves-effect waves-light btn btn-blue']) ?>

                            <?= Html::a(Yii::t('app', 'Annuler'), ['index'], ['class' => 'waves-effect waves-light btn btn-grey']) ?>
                        </div>

                    </div>

                </div>

            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>