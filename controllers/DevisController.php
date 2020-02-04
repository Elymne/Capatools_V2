<?php

namespace app\controllers;

use yii\web\Controller;

class DevisController extends Controller implements ServiceInterface {

    public static function GetActionUser($user) {
        return [
            'Priorite' => 3,
            'Name' => 'Devis',
            'items' => [
                [
                    'Priorite' => 1,
                    'url' => 'devis/index',
                    'label' => 'Jambon fleur et Michon',
                    'icon' => 'show_chart'
                ]
            ]
        ];
    }

    public static function GetIndicateur($user) {
        
    }

    public static function GetRight() {
        
    }
    
    public function actionIndex() {
        return "SALUT MON POTE";
    }

}
