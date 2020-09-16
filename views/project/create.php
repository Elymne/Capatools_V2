<?php

use app\assets\AppAsset;
use app\assets\projects\ProjectCreateAsset;
use app\models\projects\Project;
use app\widgets\TopTitle;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Création';
$this->params['breadcrumbs'][] = ['label' => 'Devis', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';

AppAsset::register($this);
ProjectCreateAsset::register($this);

?>

<?= TopTitle::widget(['title' => $this->title]) ?>

<div class="container">
    <div class="project-create">

        <?php $form = ActiveForm::begin(['id' => 'dynamic-form', 'options' => ['enctype' => 'multipart/form-data']]); ?>
        <div class="row">
            <div class="col s10 offset-s1">

                <!-- Informations lots et tâches -->
                <div id="first-form-card" class="card">
                    <div class="card-content">
                        <label>Informations générales</label>
                    </div>
                    <div class="card-action">

                        <!-- TODO Utiliser des comboboxs -->
                        <div class="col s12">
                            <div class="row">
                                <div class="input-field col s6">
                                    <?= $form->field($model, 'type')->widget(Select2::class, [
                                        'data' => Project::TYPES,
                                        'pluginLoading' => false,
                                        'pluginOptions' => [
                                            'allowClear' => false
                                        ],
                                    ])->label("Type de prestation"); ?>
                                </div>
                            </div>
                        </div>

                        <div class="col s12">
                            <div class="row">
                                <div class="input-field col s6">
                                    <?= $form->field($model, 'prospecting_time_day')
                                        ->textInput(['maxlength' => true], ['autocomplete' => 'off'])
                                        ->label("Temps passé à la prospection, réunions, chiffrages (déjà réalisé et estimation)")
                                    ?>
                                </div>
                            </div>
                        </div>

                        <div class="col s12">
                            <div class="row">

                                <div class="input-field col s1 offset-s11">
                                    <?= Html::a('Suivant', null, ['id' => 'first-next-link']) ?>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>

                <!-- Informations de je sais pas quoi -->
                <div id="second-form-card" class="card" style="display: none">

                    <div class="card-content">
                        <label>Tâches</label>
                    </div>

                    <div class="card-action">

                        <div class="col s12">
                            <div class="row">
                                <div class="input-field col s1 offset-s10">
                                    <?= Html::a('Retour', null, ['id' => 'second-back-link']) ?>
                                </div>
                                <div class="input-field col s1">
                                    <?= Html::a('Suivant', null, ['id' => 'second-next-link']) ?>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>

            </div>
        </div>
        <?php ActiveForm::end(); ?>


    </div>
</div>