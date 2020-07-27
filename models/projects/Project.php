<?php

namespace app\models\projects;

use yii\db\ActiveRecord;
use app\models\users\Cellule;
use app\models\users\CapaUser;
use app\models\companies\Company;
use app\models\companies\Contact;

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

    const TYPE_PRESTATION = 'Prestation';
    const TYPE_OUTSOURCING_AD = 'Sous traitance AD';
    const TYPE_OUTSOURCING_UN = "Sous traitance UN";
    const TYPE_INTERNAL = "Interne";
    const TYPES = [
        1 => self::TYPE_PRESTATION,
        2 => self::TYPE_OUTSOURCING_AD,
        3 => self::TYPE_OUTSOURCING_UN,
        4 => self::TYPE_INTERNAL
    ];

    const STATE_DRAFT = 'Avant-projet';
    const STATE_DEVIS_SENDED = 'Devis envoyé';
    const STATE_DEVIS_SIGNED = "Devis signé";
    const STATE_CANCELED = "Projet annulé";
    const STATE_FINISHED = "Projet terminé";
    const STATES = [
        1 => self::STATE_DRAFT,
        2 => self::STATE_DEVIS_SENDED,
        3 => self::STATE_DEVIS_SIGNED,
        4 => self::STATE_CANCELED, self::STATE_FINISHED
    ];

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

    public static function getAllDraft()
    {
        return static::find()->where(['draft' => true])->all();
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

    public function getContact()
    {
        return $this->hasOne(Contact::className(), ['id' => 'contact_id']);
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

    public function getMillestones()
    {
        return $this->hasMany(Millestone::className(), ['project_id' => 'id']);
    }
    public function getLotaventprojet()
    {

        return Lot::find()->where(['number' => 0, 'project_id' => $this->id])->one();
    }

    public function getLotByNumber($number)
    {

        return Lot::find()->where(['number' => $number, 'project_id' => $this->id])->one();
    }
    public function getAdditionalLotPrice()
    {

        $lotavp = Lot::find()->where(['number' => 0, 'project_id' => $this->id])->one();
        $lotavpTotalMarge = $lotavp->total / (1 - $this->marginaverage / 100);
        return round(($lotavpTotalMarge / (count($this->lots) - 1)), 2);
    }

    public function getTotal()
    {
        $totalwithmargin = 0.0;
        $lotsproject = $this->lots;
        foreach ($lotsproject as $lot) {
            if ($lot->number != 0) {
                $totalwithmargin = $totalwithmargin + $lot->totalwithmargin + $this->additionallotprice;
            }
        }
        return $totalwithmargin;
    }

    public function getSupportPrice()
    {
        return round($this->sellingPrice * ($this->management_rate / 100), 2);
    }

    public function getSellingPrice()
    {
        return round($this->total / (1 - $this->management_rate / 100), -2);
    }

    public function getMarginAverage()
    {

        $totalwithmargin = 0.0;
        $totalwithoutmargin = 0.0;
        $lotsproject = $this->lots;
        foreach ($lotsproject as $lot) {
            if ($lot->number != 0) {
                $totalwithmargin = $totalwithmargin + $lot->totalwithmargin;
                $totalwithoutmargin = $totalwithoutmargin + $lot->total;
            }
        }
        return round((($totalwithmargin / $totalwithoutmargin) - 1) * 100, 2);
    }
    public function getNbLot()
    {
        $ListeLot = $this->lots;
        return count($ListeLot) - 1;
    }
}
