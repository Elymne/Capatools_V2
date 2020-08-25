<?php

namespace app\models\laboratories;

use app\models\equipments\Equipment;
use app\models\users\Cellule;
use JsonSerializable;
use yii\db\ActiveRecord;

/**
 * Classe modèle métier des laboratoires Capacités.
 * Permet de faire des requêtes depuis la table laboratory de la db associée à l'app.
 * Les attributs sont les suivants : 
 *  - id
 *  - name
 *  - price_contributor_day
 *  - price_contributor_hour
 *  - price_ec_day
 *  - price_ec_hour
 *  - cellule_id
 *  - cellule
 * 
 * @version Capatools v2.0
 * @since Classe existante depuis la Release v2.0
 */
class Laboratory extends ActiveRecord implements JsonSerializable
{

    /**
     * Utilisé pour définir quelle table est associée à cette classe.
     */
    static function tableName()
    {
        return 'laboratory';
    }

    /**
     * Récupère un laboratoire à partir de son id.
     * @param int $id : identifiant labo.
     * 
     * @return Laboratory, retourne un objet Laboratory.
     */
    static function getOneById(int $id)
    {
        return static::find(['id' => $id])->one();
    }

    /**
     * Récupère la liste de tous les laboratoires.
     * 
     * @return array<Laboratory>, retourne une liste d'objets Laboratory.
     */
    static function getAll()
    {
        return static::find()->all();
    }

    /**
     * Récupère la liste de tous les laboratoires sous l'objet DataProvider, utile pour nourirc certains widget.
     * 
     * @return DataProvider, retourne une liste d'objets Laboratory sous un objet ActiveData.
     */
    static function getAllDataProvider()
    {
        return static::find();
    }

    /**
     * Récupère la liste de tous les laboratoires possédant au moins un équipement.
     * 
     * @return array<Laboratory>, retourne une liste d'objet Laboratory.
     */
    static function getAllThatHasEquipments(): array
    {
        return \array_filter(static::find()->all(), function ($elem) {
            return \sizeof($elem->equipments) > 0;
        });
    }

    /**
     * Fait la jonction entre un laboratoire et sa liste de matériels.
     * Créer un attribut "equipments" qui sera composé d'une liste d'objet Equipment.
     */
    function getEquipments()
    {
        return $this->hasMany(Equipment::class, ['laboratory_id' => 'id']);
    }

    /**
     * Fait la jonction entre un laboratoire et sa cellule.
     * Créer un attribut "cellule" qui sera un objet Cellule.
     */
    public function getCellule()
    {
        return $this->hasOne(Cellule::className(), ['id' => 'cellule_id']);
    }

    /**
     * Fonction pour envoyer au format json les données de l'objet.
     */
    public function jsonSerialize()
    {
        return array(
            'id' => $this->id,
            'name' => $this->name,
            'price_contributor_day' => $this->price_contributor_day,
            'price_contributor_hour' => $this->price_contributor_hour,
            'price_ec_day' => $this->price_ec_day,
            'price_ec_hour' => $this->price_ec_hour,
            'cellule' => $this->cellule_id,
        );
    }
}
