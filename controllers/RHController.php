<?php

namespace app\controllers;

use yii\web\Controller;
use yii\filters\AccessControl;

class RHController extends Controller implements ServiceInterface
{

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index'],
                'rules' => [
                    [
                        'actions' => ['Index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Get list of indicateur
     */
    public static function getIndicator($user)
    {
    }

    /**
     * Get Action for the user
     */
    public static function getActionUser($user)
    {
        return [
            'priorite' => 2,
            'name' => 'RH',
            'items' => [
                [
                    'priorite' => 2,
                    'url' => 'RH/nn',
                    'label' => 'Demande de congé',
                    'icon' => 'show_chart',
                    'active' => ''
                ],
                [
                    'priorite' => 1,
                    'url' => 'RH/ActionName',
                    'label' => 'Etat des congés',
                    'icon' => 'show_chart',
                    'active' => ''
                ],
            ]
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {

        return [1 => "ok google"];
    }
}
