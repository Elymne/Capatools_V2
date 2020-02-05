<?php

use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'Devis';

htmlDetails();

foreach ($errors as $error) {
    Yii::$app->session->setFlash('error', $error);
}

if (empty($errors)) {
    showData($dataProvider);
}


//=== Function ===\\


function showData($dataProvider)
{
    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            [
                'label' => 'ID Capacites',
                'attribute' => 'id_capa'
            ],
            [
                'label' => 'Nom interne',
                'attribute' => 'internal_name'
            ],
            [
                'label' => 'Nom du fichier',
                'attribute' => 'filename'
            ],
            [
                'label' => 'Version',
                'attribute' => 'version'
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{get}',
                'buttons' => [
                    'get' => function ($url, $model, $key) {
                        return Html::a('Voir', ['devis/get', 'id' => $model->id], ['class' => 'waves-effect waves-light btn btn-small']);
                    }
                ],
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{change}',
                'buttons' => [
                    'change' => function ($url, $model, $key) {
                        return Html::a('Modifier', ['devis/get', 'id' => $model->id], ['class' => 'waves-effect waves-light btn btn-small orange']);
                    }
                ],
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{remove}',
                'buttons' => [
                    'remove' => function ($url, $model, $key) {
                        return Html::a('Supprimer', ['devis/get', 'id' => $model->id], ['class' => 'waves-effect waves-light btn btn-small red']);
                    }
                ],
            ]
        ]
    ]);
}

function htmlDetails()
{ ?>

    <h3> Liste des devis </h3>

<?php }
