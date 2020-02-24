<?php

namespace app\models\devis;

use yii\db\ActiveRecord;
use dosamigos\chartjs\ChartJs;
use yii\helpers\ArrayHelper;
use app\models\user\Cellule;
use app\models\user\Capaidentity;

class Devis extends ActiveRecord
{

    public static function tableName()
    {
        return 'devis';
    }


    /**
     * Récupère tous les devis.
     */
    public static function getAll()
    {
        return static::find();
    }


    public static function getGroupbyStatus()
    {
        //Je recherche l'ensemble des statuts d'un devis
        $statuts = DevisStatut::find()->asArray()->orderby('id')->all();
        $val = array();
        foreach ($statuts as $st) {
            //Je calcul lenb de devis par statut
            $tot =  static::find()->where(['statut_id' => $st['id']])->count();

            $val = array_merge($val,  [['statutlbl' => $st['label'], 'val' => (int) $tot]]);
        }

        $string = ChartJs::widget([
            'options' => [
                'height' => 100,

            ],
            'clientOptions' => [
                'responsive' => true,
                'legend' => ['display' => false],
                'animation' => [
                    'duration' => 369,
                ],
                'title' => [
                    'display' => true,
                    'text' => 'Etat des Projet(s)',
                    'Position' => 'bottom'
                ],
                'scales' => [
                    'yAxes' => [
                        [
                            'scaleLabel' => [
                                'display' => 'true',
                                'labelString' => 'Nombres de projet(s)'
                            ],
                            'ticks' => [
                                'min' => 0,
                                'stepSize' => 5,
                                'suggestedMax' => 30

                            ]
                        ]
                    ],
                    'xAxes' => [
                        []
                    ]
                ]
            ],
            'type' => 'bar',
            'data' =>
            [
                'labels' => ArrayHelper::getColumn($val, 'statutlbl'),
                'datasets' =>
                [
                    [
                        'label' => "Projet(s)",
                        'data' =>  ArrayHelper::getColumn($val, 'val'),
                        'backgroundColor' => ['blue', 'red', 'yellow', 'green'],

                    ],

                ]
            ],

        ]);
        return  $string;
    }

    public static function getOneById($id)
    {
        return static::find()->where(['id' => $id])->one();
    }


    public static function getOneByName($id_capa)
    {
        return static::find()->where(['id_capa' => $id_capa])->one();
    }

    public function getCellule()
    {
        return $this->hasOne(Cellule::className(), ['id' => 'cellule_id']);
    }

    public function getCompany()
    {
        return $this->hasOne(Company::className(), ['id' => 'company_id']);
    }
    public function getStatut()
    {
        return $this->hasOne(DevisStatut::className(), ['id' => 'statut_id']);
    }

    public function getCapaidentity()
    {
        return $this->hasOne(Capaidentity::className(), ['id' => 'capaidentity_id']);
    }

    public function gettypeprestation()
    {
        return $this->hasOne(Typeprestation::className(), ['id' => 'typeprestation_id']);
    }
}
