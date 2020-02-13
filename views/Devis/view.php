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
            <span class="card-title">Nom interne : <?= Html::encode($model->internal_name) ?></span>
            <span class="card-title">Nom laboxy : <?= Html::encode($model->id_laboxy) ?></span>
            </div>
            <div class="card-action">
                <?= Html::a('Revenir', ['index'], ['class' => 'waves-effect waves-light btn']) ?>
                
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
                            'attribute' => 'capaidentity.username',
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
                <span class="card-title"> Fichier PDF</span>
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
                        ]
                    ],
                ]) ?>
            </div>
        </div>
    </div>

</div>




<?php
