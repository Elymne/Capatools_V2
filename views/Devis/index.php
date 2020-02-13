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

    <div class="row">
        <div class="card teal lighten-2">
            <div class="card-content white-text">
                <span class="card-title"><?= Html::encode($this->title) ?></span>
            </div>
        </div>
    </div>


    <h1> Devis en avant contrat :</h1>
    <?php Pjax::begin(['id'=>'1']); ?>
    <div class="row">
        <?php echo Html::a('Créer', ['devis/create'], ['class' => 'waves-effect waves-light btn blue']);  ?>
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
            ],
            [
                'attribute' => 'internal_name',
                'format' => 'text',
                'label' => 'Nom du projet',
            ],
            //todo Remplacer par le vrai nom du project-manager.
            [
                'attribute' => 'capaidentity.username',
                'format' => 'text',
                'label' => 'Responsable projet',
            ],
            [
                'attribute' => 'version',
                'format' => 'text',
                'label' => 'Version du fichier',
            ],

            [
                'attribute' => 'cellule.name',
                'format' => 'text',
                'label' => 'Cellule',
            ],
            [
                'attribute' => 'company.name',
                'format' => 'text',
                'label' => 'Entreprise',
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
                        return Html::a('Voir', ['devis/view', 'id' => $model->id],['class' => 'waves-effect waves-light btn blue']);
                    }
                ],
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}',
                'header' => false,
                'buttons' => [
                    'update' => function ($url, $model, $key) {
                        return Html::a('Modifier', ['devis/update', 'id' => $model->id], ['class' => 'waves-effect waves-light btn blue']);
                    }
                ],
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{delete}',
                'header' => false,
                'buttons' => [
                    'delete' => function ($url, $model, $key) {
                        return Html::a('Supprimer', ['devis/delete', 'id' => $model->id], ['class' => 'waves-effect waves-light btn blue']);
                    }
                ],
            ],

        ],
    ]); ?>

    
    <?php Pjax::end(); ?>
    <h1> Devis en validation operationel:</h1>
    <?php Pjax::begin(['id'=>'2']); ?>

    <?= GridView::widget([
        'id' => 'AvantContrat_id2',
        'dataProvider' => $dataProviderAttenteop,
        'filterModel' => $searchModelAttenteop,
        'columns' => [
            [
                'attribute' => 'id_capa',
                'format' => 'text',
                'label' => 'Identifiant Capacites',
            ],
            [
                'attribute' => 'internal_name',
                'format' => 'text',
                'label' => 'Nom du projet',
            ],
            //todo Remplacer par le vrai nom du project-manager.
            [
                'attribute' => 'capaidentity.username',
                'format' => 'text',
                'label' => 'Responsable projet',
            ],
            [
                'attribute' => 'version',
                'format' => 'text',
                'label' => 'Version du fichier',
            ],

            [
                'attribute' => 'cellule.name',
                'format' => 'text',
                'label' => 'Cellule',
            ],
            [
                'attribute' => 'company.name',
                'format' => 'text',
                'label' => 'Entreprise',
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
                        return Html::a('Voir', ['devis/view', 'id' => $model->id],['class' => 'waves-effect waves-light btn blue']);
                    }
                ],
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}',
                'header' => false,
                'buttons' => [
                    'update' => function ($url, $model, $key) {
                        return Html::a('Valider', ['devis/validationop', 'id' => $model->id], ['class' => 'waves-effect waves-light btn blue']);
                    }
                ],
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{delete}',
                'header' => false,
                'buttons' => [
                    'delete' => function ($url, $model, $key) {
                        return Html::a('Refuser', ['devis/RefuserOp', 'id' => $model->id], ['class' => 'waves-effect waves-light btn blue']);
                    }
                ],
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{delete}',
                'header' => false,
                'buttons' => [
                    'delete' => function ($url, $model, $key) {
                        return Html::a('Cloturer', ['devis/CloturerOp', 'id' => $model->id], ['class' => 'waves-effect waves-light btn blue']);
                    }
                ],
            ],

        ],
    ]); ?>

    <?php Pjax::end(); ?>


    <h1> Devis en validation client:</h1>
    <?php Pjax::begin(['id'=>'3']); ?>



    <?= GridView::widget([
        'id' => 'ValidationClient_id3',
        'dataProvider' => $dataProviderAttenteClient,
        'filterModel' => $searchModelAttenteClient,
        'columns' => [
            [
                'attribute' => 'id_capa',
                'format' => 'text',
                'label' => 'Identifiant Capacites',
            ],
            [
                'attribute' => 'internal_name',
                'format' => 'text',
                'label' => 'Nom du projet',
            ],
            //todo Remplacer par le vrai nom du project-manager.
            [
                'attribute' => 'capaidentity.username',
                'format' => 'text',
                'label' => 'Responsable projet',
            ],
            [
                'attribute' => 'version',
                'format' => 'text',
                'label' => 'Version du fichier',
            ],

            [
                'attribute' => 'cellule.name',
                'format' => 'text',
                'label' => 'Cellule',
            ],
            [
                'attribute' => 'company.name',
                'format' => 'text',
                'label' => 'Entreprise',
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
                        return Html::a('Voir', ['devis/view', 'id' => $model->id],['class' => 'waves-effect waves-light btn blue']);
                    }
                ],
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}',
                'header' => false,
                'buttons' => [
                    'update' => function ($url, $model, $key) {
                        return Html::a('Accepter', ['devis/validationclient', 'id' => $model->id], ['class' => 'waves-effect waves-light btn blue']);
                    }
                ],
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{delete}',
                'header' => false,
                'buttons' => [
                    'delete' => function ($url, $model, $key) {
                        return Html::a('Refuser', ['devis/Refuserclient', 'id' => $model->id], ['class' => 'waves-effect waves-light btn blue']);
                    }
                ],
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{delete}',
                'header' => false,
                'buttons' => [
                    'delete' => function ($url, $model, $key) {
                        return Html::a('Cloturer', ['devis/Cloturerclient', 'id' => $model->id], ['class' => 'waves-effect waves-light btn blue']);
                    }
                ],
            ],

        ],
    ]); ?>

    
    <?php Pjax::end(); ?>
    <h1> Devis en cours :</h1>
    <?php Pjax::begin(['id'=>'4']); ?>



<?= GridView::widget([
    'id' => 'Projetencour_id4',
    'dataProvider' => $dataProviderEncours,
    'filterModel' => $searchModelEncours,
    'columns' => [
        [
            'attribute' => 'id_capa',
            'format' => 'text',
            'label' => 'Identifiant Capacites',
        ],
        [
            'attribute' => 'internal_name',
            'format' => 'text',
            'label' => 'Nom du projet',
        ],
        //todo Remplacer par le vrai nom du project-manager.
        [
            'attribute' => 'capaidentity.username',
            'format' => 'text',
            'label' => 'Responsable projet',
        ],
        [
            'attribute' => 'version',
            'format' => 'text',
            'label' => 'Version du fichier',
        ],

        [
            'attribute' => 'cellule.name',
            'format' => 'text',
            'label' => 'Cellule',
        ],
        [
            'attribute' => 'company.name',
            'format' => 'text',
            'label' => 'Entreprise',
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
                    return Html::a('Voir', ['devis/view', 'id' => $model->id],['class' => 'waves-effect waves-light btn blue']);
                }
            ],
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{update}',
            'header' => false,
            'buttons' => [
                'update' => function ($url, $model, $key) {
                    return Html::a('Modifier', ['devis/Modifierencours', 'id' => $model->id], ['class' => 'waves-effect waves-light btn blue']);
                }
            ],
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{delete}',
            'header' => false,
            'buttons' => [
                'delete' => function ($url, $model, $key) {
                    return Html::a('Cloturer', ['devis/Cloturerclient', 'id' => $model->id], ['class' => 'waves-effect waves-light btn blue']);
                }
            ],
        ],

    ],
]); ?>


<?php Pjax::end(); ?>
    <h1> Devis Terminé :</h1>
    <?php Pjax::begin(['id'=>'5']); ?>



<?= GridView::widget([
    'id' => 'ProjetTerminer_id5',
    'dataProvider' => $dataProviderTerminer,
    'filterModel' => $searchModelTerminer,
    'columns' => [
        [
            'attribute' => 'id_capa',
            'format' => 'text',
            'label' => 'Identifiant Capacites',
        ],
        [
            'attribute' => 'internal_name',
            'format' => 'text',
            'label' => 'Nom du projet',
        ],
        //todo Remplacer par le vrai nom du project-manager.
        [
            'attribute' => 'capaidentity.username',
            'format' => 'text',
            'label' => 'Responsable projet',
        ],
        [
            'attribute' => 'version',
            'format' => 'text',
            'label' => 'Version du fichier',
        ],

        [
            'attribute' => 'cellule.name',
            'format' => 'text',
            'label' => 'Cellule',
        ],
        [
            'attribute' => 'company.name',
            'format' => 'text',
            'label' => 'Entreprise',
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
                    return Html::a('Voir', ['devis/view', 'id' => $model->id],['class' => 'waves-effect waves-light btn blue']);
                }
            ],
        ],

    ],
]); ?>


<?php Pjax::end(); ?>
</div>