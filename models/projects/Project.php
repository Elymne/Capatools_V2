<?php

namespace app\models\projects;

use yii\db\ActiveRecord;
use app\models\users\Cellule;
use app\models\users\CapaUser;
use app\models\companies\Company;

/**
 * Classe modèle métier des projets.
 * Permet de faire des requêtes depuis la table devis de la db associé à l'app.
 * Marche de la même manière qu'un ORM (voir la fonction getAll par l'exemple).
 * 
 * @version Capatools v2.0
 * @since Classe existante depuis la Release v2.0
 */
class Project extends ActiveRecord
{

    const TYPE_INTERNAL_PRESTATION = 'Prestation interne';
    const TYPE_OUTSOURCING_AD = 'Sous traitance AD';
    const TYPE_OUTSOURCING_UN = "Sous traitance UN";
    const TYPES = [self::TYPE_INTERNAL_PRESTATION, self::TYPE_OUTSOURCING_AD, self::TYPE_OUTSOURCING_UN];

    const STATE_DRAFT = 'Avant-projet';
    const STATE_DEVIS_SENDED = 'Devis envoyé';
    const STATE_DEVIS_SIGNED = "Devis signé";
    const STATE_CANCELED = "Projet annulé";
    const STATE_FINISHED = "Projet terminé";
    const STATES = [self::STATE_DRAFT, self::STATE_DEVIS_SENDED, self::STATE_DEVIS_SIGNED, self::STATE_CANCELED, self::STATE_FINISHED];

    public static function tableName()
    {
        return 'project';
    }

    public static function getAll()
    {
        return static::find()->all();
    }

    public static function getOneById($id)
    {
        return static::find()->where(['id' => $id])->one();
    }

    public static function getAllByCellule($idCellule)
    {
        return static::find()->where(['project.cellule_id' => $idCellule])->all();
    }

    public function getStatusIndex()
    {
        $result = -1;

        foreach (self::STATES as $key => $state) {
            if ($state == $this->state) $result = $key;
        }

        return $result;
    }

    // Relation map.

    public function getCellule()
    {
        return $this->hasOne(Cellule::className(), ['id' => 'cellule_id']);
    }

    public function getCompany()
    {
        return $this->hasOne(Company::className(), ['id' => 'company_id']);
    }

    public function getProject_manager()
    {
        return $this->hasOne(CapaUser::className(), ['id' => 'capa_user_id']);
    }

    public function getLots()
    {
        return $this->hasMany(Lot::className(), ['project_id' => 'id']);
    }
}
