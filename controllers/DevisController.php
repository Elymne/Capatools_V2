<?php

namespace app\controllers;

use yii\web\Controller;
use \app\models\devis\Devis;
use richardfan\sortable\SortableAction;
use yii\data\ActiveDataProvider;

class DevisController extends Controller implements ServiceInterface
{

    public function actions()
    {
        return [
            'sortItem' => [
                'class' => SortableAction::className(),
                'activeRecordClassName' => Devis::className()
            ]
        ];
    }

    public static function GetActionUser($user)
    {
        return [
            'Priorite' => 3,
            'Name' => 'Devis',
            'items' => [
                [
                    'Priorite' => 1,
                    'url' => 'devis/index',
                    'label' => 'Liste des devis',
                    'icon' => 'show_chart'
                ]
            ]
        ];
    }

    public static function GetIndicateur($user)
    {
    }

    public static function GetRight()
    {
    }

    public function actionIndex()
    {
        $query = Devis::getAll();

        $errors = [];
        if (empty($query))
            array_unshift($errors, 'No data found');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        return $this->render(
            'index',
            [
                'dataProvider' => $dataProvider,
                'errors' => $errors
            ]
        );
    }

    public function actionGet($id)
    {
        $query = Devis::getOneById($id);

        return $this->render(
            'devis_details',
            [
                'query' => $query
            ]
        );
    }
}
