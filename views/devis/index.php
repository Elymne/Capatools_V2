<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\devis\DevisSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Liste des devis';
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="devis-index">

    <!-- New -->

    <div class="row">
        <div class="card">

            <div class="card-content">
                <span class="card-title"><?= Html::encode($this->title) ?></span>
            </div>

            <div class="card-action">

                <br />

                <?php Pjax::begin(['id' => '1']); ?>

                <?= GridView::widget([
                    'id' => 'AvantContrat_id',
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'tableOptions' => [
                        'class' => ['highlight']
                    ],
                    'columns' => [
                        [
                            'attribute' => 'id_capa',
                            'format' => 'raw',
                            'label' => 'Identifiant Capacites',
                            'filterInputOptions' => [
                                'class' => 'form-control',
                                'placeholder' => 'Filtre CapaId'
                            ],
                            'value' => function ($data) {
                                return Html::a($data['id_capa'], ['devis/view', 'id' => $data['id']]);
                            }
                        ],
                        [
                            'attribute' => 'internal_name',
                            'format' => 'text',
                            'label' => 'Nom du projet',
                            'filterInputOptions' => [
                                'class' => 'form-control',
                                'placeholder' => 'Filtre Nom Projet'
                            ]
                        ],
                        [
                            'attribute' => 'capa_user.username',
                            'format' => 'text',
                            'label' => 'Responsable projet',
                            'filterInputOptions' => [
                                'class' => 'form-control',
                                'placeholder' => 'Filtre Responsable'
                            ]
                        ],
                        [
                            'attribute' => 'version',
                            'format' => 'text',
                            'label' => 'Version du fichier',
                            'filterInputOptions' => [
                                'class' => 'form-control',
                                'placeholder' => 'Filtre Version'
                            ]
                        ],

                        [
                            'attribute' => 'cellule.name',
                            'format' => 'text',
                            'label' => 'Cellule',
                            'filterInputOptions' => [
                                'class' => 'form-control',
                                'placeholder' => 'Filtre Cellule'
                            ]
                        ],
                        [
                            'attribute' => 'company.name',
                            'format' => 'text',
                            'label' => 'Entreprise',
                            'filterInputOptions' => [
                                'class' => 'form-control',
                                'placeholder' => 'Filtre Entreprise'
                            ]
                        ],
                        [
                            'attribute' => 'devis_status.label',
                            'format' => 'text',
                            'label' => 'Statut',
                        ],
                    ],
                ]); ?>

                <?php Pjax::end(); ?>

            </div>
        </div>
    </div>

</div>