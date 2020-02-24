<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\user\CapaUserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Liste des salariés';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="capa_user-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?=

            Html::a('Créer un salarié <i class="material-icons right">add_box</i>', ['create'], ['class' => 'btn waves-effect waves-light']); ?>
    </p>

    <?php Pjax::begin(); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'label' => 'Salarié',
                'attribute' => 'username',
                'filterInputOptions' => [
                    'class' => 'form-control',
                    'placeholder' => 'Filtre salarié'
                ]
            ],
            [
                'label' => 'Email',
                'format' => 'ntext',
                'attribute' => 'email',
                'filterInputOptions' => [
                    'class' => 'form-control',
                    'placeholder' => 'Filtre Email'
                ]

            ],
            [
                'label' => 'Cellule',
                'format' => 'ntext',
                'attribute' => 'cellule.name',
                'filterInputOptions' => [
                    'class' => 'form-control',
                    'placeholder' => 'Filtre Cellule'
                ]

            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete} {link}',
                'header' => 'Actions',
                'buttons' => [
                    'view' => function ($url, $model, $key) {
                        $options = [
                            'class' => 'btn-floating blue tooltipped',
                            'data-position' => 'bottom',
                            'data-tooltip' => 'Voir'
                        ];
                        return Html::a('<i class="material-icons">search</i>', $url, $options);
                    },
                    'update' => function ($url, $model, $key) {
                        $options = [
                            'class' => 'btn-floating orange tooltipped',
                            'data-position' => 'bottom',
                            'data-tooltip' => 'Mettre à jour'
                        ];
                        return Html::a('<i class="material-icons">mode_edit</i>', $url, $options);
                    },
                    'delete' => function ($url, $model, $key) {
                        $options = [
                            'class' => 'btn-floating red tooltipped',
                            'data-position' => 'bottom',
                            'data-tooltip' => 'Supprimer'
                        ];
                        return Html::a('<i class="material-icons">delete</i>', $url, $options);
                    },
                    'link' => function ($url, $model, $key) {
                        $options = [
                            'class' => 'btn-floating green tooltipped',
                            'data-position' => 'bottom',
                            'data-tooltip' => 'Réinitialiser'
                        ];
                        return Html::a('<i class="material-icons">sync</i>', $url, $options);
                    }
                ],
            ]
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>