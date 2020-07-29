<?php

namespace app\models\projects;

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
    const STATUT_ENCOURS = 'en cours';
    const STATUT_FACTURATIONENCOURS = 'Facturation en cours';
    const STATUT_FACTURER = 'Facturé';
    const STATUT_PAYED = "Payé";
    const STATUT = [
        0 => self::STATUT_ENCOURS,
        1 => self::STATUT_FACTURATIONENCOURS,
        2 => self::STATUT_FACTURER,
        3 => self::STATUT_PAYED
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
        return $this->hasOne(Project::className(), ['id' => 'project_id']);
    }
}
