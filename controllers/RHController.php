<?php

namespace app\controllers;

use yii\web\Controller;

class RHController extends Controller implements ServiceInterface {

    /**
     * {@inheritdoc}
     */
    public function behaviors() {
        return [
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions() {
        return [];
    }

    /**
     * Get list of the right
     */
    public static function GetRight() {
        
    }

    /**
     * Get list of indicateur
     *
     */
    public static function GetIndicateur($user) {
        
    }

    /**
     * Get Action for the user
     */
    public static function GetActionUser($user) {
        return [
            'Priorite' => 2,
            'Name' => 'RH',
            'items' => [
                [
                    'Priorite' => 2,
                    'url' => 'RH/nn',
                    'label' => 'Demande de congé',
                    'icon' => 'show_chart'
                ],
                [
                    'Priorite' => 1,
                    'url' => 'RH/ActionName',
                    'label' => 'Etat des congés',
                    'icon' => 'show_chart'
                ],
            ]
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex() {
        
    }

}
