<?php

namespace app\controllers;

use yii\web\Controller;
use yii\data\ActiveDataProvider;

use \app\models\devis\Devis;

class DevisController extends Controller implements ServiceInterface
{

    public function actions()
    {
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
                ],
                [
                    'Priorite' => 2,
                    'url' => 'devis/create',
                    'label' => 'Créer un devis',
                    'icon' => 'show_chart'
                ],
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
            'details',
            [
                'query' => $query
            ]
        );
    }

    public function actionUpdate($id)
    {

        $query = Devis::getOneById($id);

        return $this->render(
            'update',
            [
                'query' => $query
            ]
        );
    }
}
