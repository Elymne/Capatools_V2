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

    <?php Pjax::begin(['id' => '1']); ?>
    <div class="row">
        <?php echo Html::a('Créer un devis <i class="material-icons right">add_box</i>', ['devis/create'], ['class' => 'btn waves-effect waves-light']); ?>
    </div>
    <?= GridView::widget([
        'id' => 'AvantContrat_id1',
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
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
                'attribute' => 'delivery_type.label',
                'format' => 'text',
                'label' => 'type de prestation',
            ],
            [
                'attribute' => 'status.label',
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
                        return Html::a('<i class="material-icons">mode_edit</i>', ['devis/update', 'id' => $model->id], $options);
                    },
                    'delete' => function ($url, $model, $key) {
                        $options = [
                            'class' => 'btn-floating red tooltipped',
                            'data-position' => 'bottom',
                            'data-tooltip' => 'Supprimer',
                            'title' => Yii::t('app', 'Delete'),
                            'data-confirm' => Yii::t('app', 'Voulez vous vraiment supprimer ce devis ?'),
                            'data-method' => 'post'
                        ];
                        return Html::a('<i class="material-icons">delete</i>', ['devis/delete', 'id' => $model->id], $options);
                    }
                ],
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>
</div>