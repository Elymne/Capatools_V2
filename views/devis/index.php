<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\devis\Devisstatut;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\devis\DevisSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Liste des devis';
$this->params['breadcrumbs'][] = $this->title;

$listeEtapes = array(0 => 'Avant Contrat', 1 => 'Attente validation Opérationnel', 2 => 'Attente validation client', 3 => 'Projet en cours', 4 => 'Projet terminé / annulé');
?>
<div class="timeline">
    <?php foreach ($listeEtapes as $uneEtape) { ?>

        <div class="timeline-event">
            <p class="event-label"><?php echo $uneEtape; ?></p>
            <span class="point"><a href="#">&nbsp;&nbsp;</a></span>
        </div>
    <?php } ?>
</div>

<div class="devis-index">

    <div class="row">
        <div class="card teal lighten-2">
            <div class="card-content white-text">
                <span class="card-title"><?= Html::encode($this->title) ?></span>
            </div>
        </div>
    </div>


    <h1> Devis en avant contrat :</h1>
    <?php Pjax::begin(['id' => '1']); ?>
    <div class="row">
        <?php echo Html::a('Créer un devis <i class="material-icons right">add_box</i>', ['devis/create'], ['class' => 'btn waves-effect waves-light']); ?>
    </div>
    <?= GridView::widget([
        'id' => 'AvantContrat_id1',
        'dataProvider' => $dataProviderAvantContrat,
        'filterModel' => $searchModelAvantContrat,
        'columns' => [
            [
                'attribute' => 'id_capa',
                'format' => 'text',
                'label' => 'Identifiant Capacites',
                'filterInputOptions' => [
                    'class' => 'form-control',
                    'placeholder' => 'Filtre CapaId'
                ]
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
            //todo Remplacer par le vrai nom du project-manager.
            [
                'attribute' => 'capaidentity.username',
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
                'attribute' => 'deliveryType.label',
                'format' => 'text',
                'label' => 'type de prestation',
            ],
            [
                'attribute' => 'statut.label',
                'format' => 'text',
                'label' => 'Statut',
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{get}{update}{delete}',
                'header' => 'Action',
                'buttons' => [
                    'get' => function ($url, $model, $key) {
                        $options = [
                            'class' => 'btn-floating blue tooltipped',
                            'data-position' => 'bottom',
                            'data-tooltip' => 'Voir'
                        ];
                        return Html::a('<i class="material-icons">search</i>', ['devis/view', 'id' => $model->id], $options);
                    },
                    'update' => function ($url, $model, $key) {
                        $options = [
                            'class' => 'btn-floating orange tooltipped',
                            'data-position' => 'bottom',
                            'data-tooltip' => 'Modifier'
                        ];
                        return Html::a('<i class="material-icons">mode_edit</i>', ['devis/updateavcontrat', 'id' => $model->id], $options);
                    },
                    'delete' => function ($url, $model, $key) {
                        $options = [
                            'class' => 'btn-floating red tooltipped',
                            'data-position' => 'bottom',
                            'data-tooltip' => 'Supprimer'
                        ];
                        return Html::a('<i class="material-icons">delete</i>', ['devis/delete', 'id' => $model->id], $options);
                    }
                ],
            ],
        ],
    ]); ?>


    <?php Pjax::end(); ?>
    <h1> Devis en validation operationel:</h1>
    <?php Pjax::begin(['id' => '2']); ?>

    <?= GridView::widget([
        'id' => 'AvantContrat_id2',
        'dataProvider' => $dataProviderAttenteop,
        'filterModel' => $searchModelAttenteop,
        'columns' => [
            [
                'attribute' => 'id_capa',
                'format' => 'text',
                'label' => 'Identifiant Capacites',
                'filterInputOptions' => [
                    'class' => 'form-control',
                    'placeholder' => 'Filtre CapaId'
                ]
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
            //todo Remplacer par le vrai nom du project-manager.
            [
                'attribute' => 'capaidentity.username',
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
                'attribute' => 'statut.label',
                'format' => 'text',
                'label' => 'Statut',
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{get}{update}{refuse}{cloture}',
                'header' => false,
                'buttons' => [
                    'get' => function ($url, $model, $key) {
                        $options = [
                            'class' => 'btn-floating blue tooltipped',
                            'data-position' => 'bottom',
                            'data-tooltip' => 'Voir'
                        ];
                        return Html::a('<i class="material-icons">search</i>', ['devis/view', 'id' => $model->id], $options);
                    },
                    'update' => function ($url, $model, $key) {
                        $options = [
                            'class' => 'btn-floating green tooltipped',
                            'data-position' => 'bottom',
                            'data-tooltip' => 'Valider'
                        ];
                        return Html::a('<i class="material-icons">thumb_up</i>', ['devis/validationop', 'id' => $model->id], $options);
                    },
                    'refuse' => function ($url, $model, $key) {
                        $options = [
                            'class' => 'btn-floating red tooltipped',
                            'data-position' => 'bottom',
                            'data-tooltip' => 'Refuser'
                        ];
                        return Html::a('<i class="material-icons">thumb_down</i>', ['devis/RefuserOp', 'id' => $model->id], $options);
                    },
                    'cloture' => function ($url, $model, $key) {
                        $options = [
                            'class' => 'btn-floating red tooltipped',
                            'data-position' => 'bottom',
                            'data-tooltip' => 'Clôturer'
                        ];
                        return Html::a('<i class="material-icons">lock</i>', ['devis/CloturerOp', 'id' => $model->id], $options);
                    }

                ],
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>


    <h1> Devis en validation client:</h1>
    <?php Pjax::begin(['id' => '3']); ?>



    <?= GridView::widget([
        'id' => 'ValidationClient_id3',
        'dataProvider' => $dataProviderAttenteClient,
        'filterModel' => $searchModelAttenteClient,
        'columns' => [
            [
                'attribute' => 'id_capa',
                'format' => 'text',
                'label' => 'Identifiant Capacites',
                'filterInputOptions' => [
                    'class' => 'form-control',
                    'placeholder' => 'Filtre CapaId'
                ]
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
            //todo Remplacer par le vrai nom du project-manager.
            [
                'attribute' => 'capaidentity.username',
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
                'attribute' => 'statut.label',
                'format' => 'text',
                'label' => 'Statut',
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{get}{accept}{refuse}{cloture}',
                'header' => false,
                'buttons' => [
                    'get' => function ($url, $model, $key) {
                        $options = [
                            'class' => 'btn-floating blue tooltipped',
                            'data-position' => 'bottom',
                            'data-tooltip' => 'Voir'
                        ];
                        return Html::a('<i class="material-icons">search</i>', ['devis/view', 'id' => $model->id], $options);
                    },
                    'accept' => function ($url, $model, $key) {
                        $options = [
                            'class' => 'btn-floating green tooltipped',
                            'data-position' => 'bottom',
                            'data-tooltip' => 'Accepter'
                        ];
                        return Html::a('<i class="material-icons">thumb_up</i>', ['devis/validationclient', 'id' => $model->id], $options);
                    },
                    'refuse' => function ($url, $model, $key) {
                        $options = [
                            'class' => 'btn-floating red tooltipped',
                            'data-position' => 'bottom',
                            'data-tooltip' => 'Refuser'
                        ];
                        return Html::a('<i class="material-icons">thumb_down</i>', ['devis/Refuserclient', 'id' => $model->id], $options);
                    },
                    'cloture' => function ($url, $model, $key) {
                        $options = [
                            'class' => 'btn-floating red tooltipped',
                            'data-position' => 'bottom',
                            'data-tooltip' => 'Clôturer'
                        ];
                        return Html::a('<i class="material-icons">lock</i>', ['devis/Cloturerclient', 'id' => $model->id], $options);
                    }
                ],
            ],
        ],
    ]); ?>


    <?php Pjax::end(); ?>
    <h1> Devis en cours :</h1>
    <?php Pjax::begin(['id' => '4']); ?>



    <?= GridView::widget([
        'id' => 'Projetencour_id4',
        'dataProvider' => $dataProviderEncours,
        'filterModel' => $searchModelEncours,
        'columns' => [
            [
                'attribute' => 'id_capa',
                'format' => 'text',
                'label' => 'Identifiant Capacites',
                'filterInputOptions' => [
                    'class' => 'form-control',
                    'placeholder' => 'Filtre CapaId'
                ]
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
            //todo Remplacer par le vrai nom du project-manager.
            [
                'attribute' => 'capaidentity.username',
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
                    'placeholder' => 'Filtre Enreprise'
                ]
            ],
            [
                'attribute' => 'statut.label',
                'format' => 'text',
                'label' => 'Statut',
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{get}{update}{cloture}',
                'header' => false,
                'buttons' => [
                    'get' => function ($url, $model, $key) {
                        $options = [
                            'class' => 'btn-floating blue tooltipped',
                            'data-position' => 'bottom',
                            'data-tooltip' => 'Voir'
                        ];
                        return Html::a('<i class="material-icons">search</i>', ['devis/view', 'id' => $model->id], $options);
                    },
                    'update' => function ($url, $model, $key) {
                        $options = [
                            'class' => 'btn-floating green tooltipped',
                            'data-position' => 'bottom',
                            'data-tooltip' => 'Modifier'
                        ];
                        return Html::a('<i class="material-icons">mode_edit</i>', ['devis/Modifierencours', 'id' => $model->id], $options);
                    },
                    'cloture' => function ($url, $model, $key) {
                        $options = [
                            'class' => 'btn-floating red tooltipped',
                            'data-position' => 'bottom',
                            'data-tooltip' => 'Clôturer'
                        ];
                        return Html::a('<i class="material-icons">lock</i>', ['devis/Cloturerclient', 'id' => $model->id], $options);
                    },
                ],
            ],

        ],
    ]); ?>


    <?php Pjax::end(); ?>
    <h1> Devis Terminé :</h1>
    <?php Pjax::begin(['id' => '5']); ?>



    <?= GridView::widget([
        'id' => 'ProjetTerminer_id5',
        'dataProvider' => $dataProviderTerminer,
        'filterModel' => $searchModelTerminer,
        'columns' => [
            [
                'attribute' => 'id_capa',
                'format' => 'text',
                'label' => 'Identifiant Capacites',
                'filterInputOptions' => [
                    'class' => 'form-control',
                    'placeholder' => 'Filtre CapaId'
                ]
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
            //todo Remplacer par le vrai nom du project-manager.
            [
                'attribute' => 'capaidentity.username',
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
                'attribute' => 'statut.label',
                'format' => 'text',
                'label' => 'Statut',
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{get}',
                'header' => false,
                'buttons' => [
                    'get' => function ($url, $model, $key) {
                        $options = [
                            'class' => 'btn-floating blue tooltipped',
                            'data-position' => 'bottom',
                            'data-tooltip' => 'Voir'
                        ];
                        return Html::a('<i class="material-icons">search</i>', ['devis/view', 'id' => $model->id], $options);
                    }
                ],
            ],

        ],
    ]); ?>


    <?php Pjax::end(); ?>
</div>