<?php

namespace app\controllers;

use yii\web\Controller;
use yii\filters\AccessControl;

/**
 * Classe contrôleur des vues et des actions de la partie RH.
 * Attention au nom du contrôleur, il détermine le point d'entré de la route.
 * ex : pour notre contrôleur RHController -> rh/[*]
 * Chaque route généré par le controller provient des fonctions dont le nom commence par action******.
 * ex : actionIndex donnera la route suivante -> rh/index
 * ex : actionIndexDetails donnera la route suivante -> rh/index-details.
 * 
 * Ce contrôleur n'est actuellement pas fonctionnel et non prévu pour la v2.0 de capatools.
 * 
 * @version Capatools v2.0
 * @since Classe existante depuis la Release v2.0
 */
class RHController extends Controller implements ServiceInterface
{

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

    public static function getIndicator($user)
    {
    }

    public static function getActionUser()
    {
        if (false) {
            return [
                'priorite' => 2,
                'name' => 'RH',
                'serviceMenuActive' => '',
                'items' => [
                    [
                        'priorite' => 2,
                        'url' => 'RH/nn',
                        'label' => 'Demande de congé',
                        'icon' => 'show_chart',
                        'subServiceMenuActive' => ''
                    ],
                    [
                        'priorite' => 1,
                        'url' => 'RH/ActionName',
                        'label' => 'Etat des congés',
                        'icon' => 'show_chart',
                        'subServiceMenuActive' => ''
                    ],
                ]
            ];
        }
    }

    public function actionIndex()
    {
        return [1 => "ok google"];
    }
}
