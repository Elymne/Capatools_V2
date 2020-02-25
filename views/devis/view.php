<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\devis\Devis */


if ($model->id_capa) $this->title = $model->id_capa;
else $this->title = "Modification d'un devis";

$this->params['breadcrumbs'][] = ['label' => 'Devis', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

?>
<div class="devis-view">

    <h2 style="color:#009688"> Devis : <?= Html::encode($this->title) ?> </h2>

    <div class="row">

        <div class="card">
            <div class="card-content">
                <span class="card-title"> <?= Html::encode($model->internal_name) ?></span>
                <span class="card-title"> <?= Html::encode($model->id_laboxy) ?></span>
            </div>
            <div class="card-action">
                <?= Html::a('Revenir <i class="material-icons right">keyboard_return</i>', ['index'], ['class' => 'waves-effect waves-light btn']) ?>

            </div>
        </div>

    </div>

    <div class="row">
        <div class="card">
            <div class="card-content teal white-text">
                <span class="card-title"> Détails devis </span>
            </div>
            <div class="card-action white">
                <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        [
                            'attribute' => 'service_duration',
                            'format' => 'text',
                            'label' => 'Durée de la prestation',
                        ],
                        [
                            'attribute' => 'deliveryType.label',
                            'format' => 'text',
                            'label' => 'Type de la prestation',
                        ],
                        [
                            'attribute' => 'cellule.name',
                            'format' => 'text',
                            'label' => 'Nom de cellule',
                        ],
                        [
                            'attribute' => 'company.name',
                            'format' => 'text',
                            'label' => 'Entreprise',
                        ],
                        [
                            'attribute' => 'capaUser.username',
                            'format' => 'text',
                            'label' => 'Responsable projet',
                        ]
                    ],
                ]) ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="card">
            <div class="card-content teal white-text">
                <span class="card-title"> Information Laboxy </span>
            </div>
            <div class="card-action white">
                <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        [
                            'attribute' => 'id_laboxy',
                            'format' => 'text',
                            'label' => 'Identifiant laboxy',
                        ],
                        [
                            'attribute' => 'service_duration',
                            'format' => 'text',
                            'label' => 'Durée de la prestation (h)',
                            'value' => function ($data) {
                                return $data->service_duration * Yii::$app->params['LaboxyTimeDay'];
                            }
                        ],

                    ],
                ]) ?>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="card">
            <div class="card-content teal white-text">
                <span class="card-title"> Proposition technique</span>
            </div>
            <div class="card-action white">
                <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        [
                            'attribute' => 'filename',
                            'format' => 'text',
                            'label' => 'Nom du fichier PDF',
                        ],
                        [
                            'format' => 'html',
                            'label' => 'Visualiser',
                            'value' => function ($data) {
                                return Html::a('Visualiser', ['viewpdf', 'id' => $data->id,], ['class' => 'btn btn-primary']);
                            }
                        ],
                        [
                            'attribute' => 'version',
                            'format' => 'text',
                            'label' => 'Version de fichier',
                        ],
                        [
                            'attribute' => 'filename_first_upload',
                            'format' => 'text',
                            'label' => 'Date d\'upload du fichier',
                        ],
                        [
                            'attribute' => 'filename_last_upload',
                            'format' => 'text',
                            'label' => 'Dernière modification du fichier',
                        ],
                    ],
                ]) ?>
            </div>
        </div>
    </div>

</div>




<?php
