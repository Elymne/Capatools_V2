<?php

namespace app\models\projects;

use Yii;
use yii\db\ActiveRecord;

/**
 * Classe modèle métier des projets.
 * Permet de faire des requêtes depuis la table devis de la db associé à l'app.
 * Marche de la même manière qu'un ORM (voir la fonction getAll par l'exemple).
 * 
 * @version Capatools v2.0
 * @since Classe existante depuis la Release v2.0
 */
class Millestone extends ActiveRecord
{

    const STATUT_NOT_STARTED = 'Pas démarré';
    const STATUT_ENCOURS = 'En cours';
    const STATUT_FACTURATIONENCOURS = 'Facturation en cours';
    const STATUT_FACTURER = 'Facturé';
    const STATUT_PAYED = "Payé";
    const STATUT_CANCELED = "Annulé";
    const STATUT = [
        0 => self::STATUT_NOT_STARTED,
        1 => self::STATUT_ENCOURS,
        2 => self::STATUT_FACTURATIONENCOURS,
        3 => self::STATUT_FACTURER,
        4 => self::STATUT_PAYED,
        5 => self::STATUT_CANCELED
    ];

    public static function tableName()
    {
        return 'millestone';
    }

    public static function getAll()
    {
        return static::find()->all();
    }

    public static function getOneById($id)
    {
        return static::find()->where(['id' => $id])->one();
    }

    public static function getAllByProject($idproject)
    {
        return static::find()->where(['millestone.project_id' => $idproject])->all();
    }


    public function getProject()
    {
        return $this->hasOne(Project::class, ['id' => 'project_id']);
    }
    public function getPriceeuros()
    {
        return Yii::$app->formatter->asCurrency($this->price);
    }
}
