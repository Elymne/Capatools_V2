<?php

namespace app\models\projects;

use yii\db\ActiveRecord;
use app\models\users\Cellule;
use app\models\users\CapaUser;
use app\models\companies\Company;
use app\models\companies\Contact;
use app\models\laboratories\LaboratoryContributor;
use app\models\equipments\EquipmentRepayment;
use yii\helpers\ArrayHelper;

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

    const TJMRAISON_TJMOK = 'TJMOK';
    const TJMRAISON_CONCURRENTIEL = 'Contexte concurrentiel';
    const TJMRAISON_INTERVENANT = 'Profil intervenant';
    const TJMRAISON_OFFER = "Thématique offre";
    const TJMRAISON_OTHER = "Autre";
    const TJMRAISON = [
        self::TJMRAISON_CONCURRENTIEL => self::TJMRAISON_CONCURRENTIEL,
        self::TJMRAISON_INTERVENANT => self::TJMRAISON_INTERVENANT,
        self::TJMRAISON_OFFER => self::TJMRAISON_OFFER,
        self::TJMRAISON_OTHER => self::TJMRAISON_OTHER
    ];

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

    const STATE_DEVIS_MODEL = 'Model';
    const STATE_DEVIS_DRAFT = 'Avant-projet';
    const STATE_DEVIS_SENDED = 'Devis envoyé';
    const STATE_DEVIS_SIGNED = "Projet en cours";
    const STATE_DEVIS_CANCELED = "Projet annulé";
    const STATE_DEVIS_FINISHED = "Projet terminé";
    const STATES = [
        0 => self::STATE_DEVIS_MODEL,
        1 => self::STATE_DEVIS_DRAFT,
        2 => self::STATE_DEVIS_SENDED,
        3 => self::STATE_DEVIS_SIGNED,
        4 => self::STATE_DEVIS_CANCELED,
        5 => self::STATE_DEVIS_FINISHED
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

    public static function getAllDataProvider()
    {
        return static::find();
    }

    public static function getAllDraftDataProvider()
    {
        return static::find()->where(['state' => [self::STATE_DEVIS_DRAFT,  self::STATE_DEVIS_MODEL]]);
    }

    public static function getAllProjectDataProvider()
    {
        return static::find()->where(['state' => [self::STATE_DEVIS_FINISHED, self::STATE_DEVIS_SIGNED, self::STATE_DEVIS_CANCELED, self::STATE_DEVIS_SENDED]]);
    }

    public static function getAllDraftByCelluleDataProvider($idCellule)
    {
        return static::find()->where(['state' => [self::STATE_DEVIS_DRAFT,  self::STATE_DEVIS_MODEL], 'project.cellule_id' => $idCellule]);
    }

    public static function getAllProjectByCelluleDataProvider($idCellule)
    {
        return static::find()->where(['state' => [self::STATE_DEVIS_FINISHED, self::STATE_DEVIS_SIGNED, self::STATE_DEVIS_CANCELED, self::STATE_DEVIS_SENDED], 'project.cellule_id' => $idCellule]);
    }
    public  function getCapaidreduc()
    {
        return substr($this->id_capa, 0, 20);
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
        return $this->hasOne(Cellule::class, ['id' => 'cellule_id']);
    }

    public function getContact()
    {
        return $this->hasOne(Contact::class, ['id' => 'contact_id']);
    }

    public function getCompany()
    {
        return $this->hasOne(Company::class, ['id' => 'company_id']);
    }

    public function getProject_manager()
    {
        return $this->hasOne(CapaUser::class, ['id' => 'capa_user_id']);
    }

    public function getLots()
    {
        return $this->hasMany(Lot::class, ['project_id' => 'id']);
    }

    public function getMillestones()
    {
        return $this->hasMany(Millestone::class, ['project_id' => 'id']);
    }
    public function getLotaventprojet()
    {

        return Lot::find()->where(['number' => 0, 'project_id' => $this->id])->one();
    }

    public function getLotByNumber($number)
    {

        return Lot::find()->where(['number' => $number, 'project_id' => $this->id])->one();
    }
    public function getRatiototalCostAVPDivTotalCostLot()
    {

        $lotavp = Lot::find()->where(['number' => 0, 'project_id' => $this->id])->one();
        return  $lotavp->totalCost / $this->totalCostlotWithoutAVP;
    }


    public function getTotalCostlotWithoutAVP()
    {
        $totalCost = 0.0;
        $lotsproject = $this->lots;
        foreach ($lotsproject as $lot) {
            if ($lot->number != 0) {
                $totalCost = $totalCost + $lot->totalCost;
            }
        }
        return $totalCost;
    }


    public function getTotalCostlotWithAVP()
    {
        $totalCost = 0.0;
        $lotsproject = $this->lots;
        foreach ($lotsproject as $lot) {
            if ($lot->number != 0) {
                $totalCost = $totalCost + $lot->totalCostWithAVP;
            }
        }
        return $totalCost;
    }



    public function getTotalAchatInvesteReversementCost()
    {
        $totalAchatinvest = 0.0;
        $lotsproject = $this->lots;
        foreach ($lotsproject as $lot) {
            if ($lot->number != 0) {
                $totalAchatinvest = $totalAchatinvest + $lot->totalCostInvest + $lot->totalCostRepayement;
            }
        }
        return $totalAchatinvest;
    }



    public function getTotalHourWithRisk()
    {
        $totaltimewithrisk = 0.0;
        $lotsproject = $this->lots;
        foreach ($lotsproject as $lot) {

            $totaltimewithrisk = $totaltimewithrisk + $lot->totalTaskTimeWithRisk * 7.7;
        }

        return $totaltimewithrisk;
    }

    public function getTotalcostRH()
    {
        $TotalCostHuman = 0.0;
        $lotsproject = $this->lots;
        foreach ($lotsproject as $lot) {

            $TotalCostHuman = $TotalCostHuman + $lot->TotalcostHuman;
        }

        return $TotalCostHuman;
    }


    public function getTjmWithRisk()
    {
        $totaltimewithrisk = 0.0;
        $TotalCostHumanWithMargin = 0.0;
        $lotsproject = $this->lots;
        foreach ($lotsproject as $lot) {
            $totaltimewithrisk = $totaltimewithrisk + $lot->totalTaskTimeWithRisk;
            if ($lot->number == 0) {
                $TotalCostHumanWithMargin = $TotalCostHumanWithMargin +  $lot->totalCostHuman * (1 + $this->marginAverage / 100);
            } else {
                $TotalCostHumanWithMargin = $TotalCostHumanWithMargin + $lot->totalPriceHumanWithMargin;
            }
        }

        $TotalCostHumanWithMargin = $TotalCostHumanWithMargin / (1 - $this->management_rate / 100);
        return $TotalCostHumanWithMargin / $totaltimewithrisk;
    }

    public function getCoutExternalDepense()
    {
        $ListeExternalFinal = array();
        foreach ($this->lots as $lot) {
            $couttotal = 0;
            $ListeExternal = Consumable::getAllExternalGroupByTitleBylotID($lot->id);

            foreach ($ListeExternal as $External) {
                $couttotal = $couttotal + $External->total;
                $title = $External->title;
                if (array_key_exists($title, $ListeExternalFinal)) {
                    $ListeExternalFinal[$title]['total'] = $ListeExternalFinal[$title]['total'] + $External->total;
                } else {
                    $ListeExternalFinal = $ListeExternalFinal + array($title => array('title' => $title, 'total' => $couttotal));
                }
            }
        }
        return  $ListeExternalFinal;
    }

    public function getCoutInternalDepense()
    {
        $ListeInternalternalFinal = array();
        foreach ($this->lots as $lot) {
            $couttotal = 0;
            $ListeInternalternal = Consumable::getAllInternalGroupByTitleBylotID($lot->id);

            foreach ($ListeInternalternal as $Internalternal) {
                $couttotal = $couttotal + $Internalternal->total;
                $title = $Internalternal->title;
                if (array_key_exists($title, $ListeInternalternalFinal)) {
                    $ListeInternalternalFinal[$title]['total'] = $ListeInternalternalFinal[$title]['total'] + $Internalternal->total;
                } else {
                    $ListeInternalternalFinal = $ListeInternalternalFinal + array($title => array('title' => $title, 'total' => $couttotal));
                }
            }
        }
        return  $ListeInternalternalFinal;
    }


    public function getCoutEquipementLaboratoire()
    {
        $ListeEquipementLaboratoire = array();
        foreach ($this->lots as $lot) {

            $ListeContributorGroupbyLabolot = EquipmentRepayment::getAllEquipementRepayementGroupByLaboBylotID($lot->id);
            $ListeEquipementLaboratoire = array_merge($ListeEquipementLaboratoire, $ListeContributorGroupbyLabolot);
        }
        return  ArrayHelper::index($ListeEquipementLaboratoire, null, 'id');
    }

    public function getCoutLaboratoire()
    {
        $ListeContributor = array();
        foreach ($this->lots as $lot) {

            $ListeContributorGroupbyLabolot = LaboratoryContributor::getAllContributionGroupByLaboBylotID($lot->id);
            $ListeContributor = array_merge($ListeContributor, $ListeContributorGroupbyLabolot);
        }
        return  ArrayHelper::index($ListeContributor, null, 'id');
    }

    public function getSupportPrice()
    {
        return round($this->sellingPrice * ($this->management_rate / 100), 2);
    }

    public function getSellingPrice()
    {
        $pvtotal = 0;
        foreach ($this->lots as $lot) {
            if ($lot->number != 0)
                $pvtotal = $pvtotal + $lot->sellingPriceWithGestionPrice;
        }
        return $pvtotal;
    }


    public function getMarginAverage()
    {
        $average = ($this->sellingPrice  - $this->totalCostlotWithAVP - $this->supportPrice) / ($this->totalCostlotWithAVP + $this->supportPrice);


        return $average * 100;
    }
}
