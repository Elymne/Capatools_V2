<?php

namespace app\models\projects;

use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use app\models\users\Cellule;
use app\models\users\CapaUser;
use app\models\companies\Company;
use dosamigos\chartjs\ChartJs;

/**
 * Classe modèle métier des devis.
 * Permet de faire des requêtes depuis la table devis de la db associé à l'app.
 * Marche de la même manière qu'un ORM (voir la fonction getAll par l'exemple).
 * 
 * @version Capatools v2.0
 * @since Classe existante depuis la Release v2.0
 */
class Project extends ActiveRecord
{

    public static function tableName()
    {
        return 'project';
    }

    public static function getAll()
    {
        return static::find();
    }

    public static function getOneById($id)
    {
        return static::find()->where(['id' => $id])->one();
    }

    public static function getAllByCellule($idCellule)
    {
        return static::find()->where(['devis.cellule_id' => $idCellule]);
    }

    /**
     * Fonctions permettant de faire la relation oneToMany d'autres tables.
     * En d'autres termes, ceci va nous permettre de récupérer la cellule, client, status ect d'un devis.
     */
    public function getCellule()
    {
        return $this->hasOne(Cellule::className(), ['id' => 'cellule_id']);
    }

    public function getCompany()
    {
        return $this->hasOne(Company::className(), ['id' => 'company_id']);
    }

    public function getDevis_status()
    {
        return $this->hasOne(DevisStatus::className(), ['id' => 'status_id']);
    }

    public function getCapa_user()
    {
        return $this->hasOne(CapaUser::className(), ['id' => 'capa_user_id']);
    }

    public function getDelivery_type()
    {
        return $this->hasOne(DeliveryType::className(), ['id' => 'delivery_type_id']);
    }


    /**
     * Fonctions de relations ManyToMany.
     */
    public function getMilestones()
    {
        return $this->hasMany(Milestone::className(), ['devis_id' => 'id']);
    }

    public function getContributors()
    {
        return $this->hasMany(Contributor::className(), ['devis_id' => 'id']);
    }

    /**
     * //TODO Déplacer cette fonction sur une section ui et non métier.
     */
    public static function getGroupbyStatus()
    {
        //Je recherche l'ensemble des statuts d'un devis
        $statusList = DevisStatus::find()->asArray()->orderby('id')->all();
        $val = array();
        foreach ($statusList as $status) {
            //Je calcul lenb de devis par statut
            $tot =  static::find()->where(['status_id' => $status['id']])->count();

            $val = array_merge($val,  [['statutlbl' => $status['label'], 'val' => (int) $tot]]);
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
        return $string;
    }
}
