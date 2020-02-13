<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\User\Capaidentity */

$this->title = "Détail du salarié: ".$model->username;
$this->params['breadcrumbs'][] = ['label' => 'Capaidentities', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="capaidentity-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Modifier <i class="material-icons right">mode_edit</i>', ['update', 'id' => $model->id], ['class' => 'btn waves-effect waves-light']) ?>
        <?= Html::a('Supprimer <i class="material-icons right">delete</i> ', ['delete', 'id' => $model->id], [
            'class' => 'btn waves-effect waves-light',
            'data' => [
                'confirm' => 'Etes vous sûr de vouloir supprimer ce salarié ?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [                      // the owner name of the model
                'label' => 'Nom et prénom',
                'attribute'=>'username',
            ],
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
