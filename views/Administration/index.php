<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\User\Capaidentitysearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Liste des utilisateurs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="capaidentity-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Créer un utilisateur ', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'label' => 'Utilisateur',
                'attribute' => 'username',
            ],
            
            'email:email',
            [
                'label' => 'Cellule',
                'format' => 'ntext',
                'attribute'=>'cellule',
                'value' => function($model) {
                    return $model->cellule->name;
                },
            ],
            ['class' => 'yii\grid\ActionColumn',
            'template' => '{view} {update} {delete} {link}',
            'header'=> 'Actions',
            'buttons' => ['link' => function ($url,$model,$key) {
                return Html::button('Reinitialiser', ['class' => 'btn btn-success']);}],
            ]
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
