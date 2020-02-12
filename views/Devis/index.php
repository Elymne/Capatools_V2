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


    <?php Pjax::begin(); ?>

    <div class="row">
        <?php echo Html::a('Créer', ['devis/create'], ['class' => 'waves-effect waves-light btn blue']);  ?>
    </div>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
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
                'class' => 'yii\grid\ActionColumn',
                'template' => '{get}',
                'header' => false,
                'buttons' => [
                    'get' => function ($url, $model, $key) {
                        return Html::a('Voir', ['devis/view', 'id' => $model->id], ['class' => 'waves-effect waves-teal btn-flat']);
                    }
                ],
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}',
                'header' => false,
                'buttons' => [
                    'update' => function ($url, $model, $key) {
                        return Html::a('Modifier', ['devis/update', 'id' => $model->id], ['class' => 'waves-effect waves-teal btn-flat']);
                    }
                ],
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{delete}',
                'header' => false,
                'buttons' => [
                    'delete' => function ($url, $model, $key) {
                        return Html::a('Supprimer', ['devis/delete', 'id' => $model->id], ['class' => 'waves-effect waves-teal btn-flat']);
                    }
                ],
            ],

        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>