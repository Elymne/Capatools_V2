<?php

use app\assets\AppAsset;
use app\assets\projects\ProjectCreateAsset;
use app\widgets\TopTitle;
use yii\bootstrap\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\devis\Devis */

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

                <!-- Informations générales -->
                <div id="first-form-card" class="card">
                    <div class="card-content">
                        <label>Informations générales</label>
                    </div>
                    <div class="card-action">

                        <?= $form->field($model, 'prospecting_time_day')
                            ->textInput(['maxlength' => true], ['autocomplete' => 'off'])
                            ->label("Temps passé à la prospection, réunions, chiffrages (déjà réalisé et estimation)")
                        ?>

                    </div>
                </div>

            </div>
        </div>
        <?php ActiveForm::end(); ?>


    </div>
</div>