<?php

use app\widgets\TopTitle;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\user\CapaUserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Liste des salariés';
$this->params['breadcrumbs'][] = $this->title;
?>

<?= TopTitle::widget(['title' => $this->title]) ?>

<div class="container">
    <div class="capa_user-index">

        <div class="row">
            <div class="card">

                <div class="card-content">

                    <?php Pjax::begin(); ?>

                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'tableOptions' => [
                            'class' => ['highlight']
                        ],
                        'columns' => [
                            [
                                'attribute' => 'username',
                                'format' => 'raw',
                                'label' => 'Salarié',
                                'filterInputOptions' => [
                                    'class' => 'form-control',
                                    'placeholder' => 'filtre salarié'
                                ],
                                'value' => function ($data) {
                                    return Html::a($data['username'], ['administration/view', 'id' => $data['id']]);
                                }
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
                                'template' => '{update} {delete} {link}',
                                'header' => 'Actions',
                                'buttons' => [
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
            </div>
        </div>

    </div>
</div>