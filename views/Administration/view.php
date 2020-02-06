<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\User\Capaidentity */

$this->title = $model->username;
$this->params['breadcrumbs'][] = ['label' => 'Capaidentities', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="capaidentity-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'username',
            'email:email',
            [                      // the owner name of the model
                'label' => 'Nom de la cellule',
                'attribute'=>'cellule.name',
            ],
        ],
    ]) ?>

<?= 

GridView::widget([
    'dataProvider' => $Rightprovider,
    'columns' => [
                [
                    'label' => 'Service',
                    'attribute' => 'Application',
                ],
                [

                    'label' => 'Statut',
                    'attribute' => 'Credential',
                ],
            ]
        ]);
                    ?>

</div>
