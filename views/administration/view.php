<?php

use app\widgets\TopTitle;
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\user\CapaUser */

$this->title = "Détail du salarié: " . $model->username;
$this->params['breadcrumbs'][] = ['label' => 'Capaidentities', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

?>

<?= TopTitle::widget(['title' => $this->title]) ?>

<div class="container">
    <div class="capa_user-view">

        <div class="row">
            <div class="card">

                <div class="card-content">
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
                </div>

                <div class="card-content">
                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            [                      // the owner name of the model
                                'label' => 'Nom et prénom',
                                'attribute' => 'username',
                            ],
                            'email:email',
                            [                      // the owner name of the model
                                'label' => 'Nom de la cellule',
                                'attribute' => 'cellule.name',
                            ],
                        ],
                    ]) ?>

                    <?=

                        GridView::widget([
                            'dataProvider' => $rightProvider,
                            'columns' => [
                                [
                                    'label' => 'Service',
                                    'attribute' => 'service',
                                ],
                                [

                                    'label' => 'Statut',
                                    'attribute' => 'role',
                                ],
                            ]
                        ]);
                    ?>
                </div>
            </div>

        </div>
    </div>

</div>
</div>