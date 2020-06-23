<?php

namespace app\models\laboratories;

use app\models\equipments\Equipment;
use app\models\users\Cellule;
use yii\db\ActiveRecord;

/**
 * Classe modèle métier des laboratoires Capacités.
 * Permet de faire des requêtes depuis la table laboratory de la db associée à l'app.
 * 
 * @version Capatools v2.0
 * @since Classe existante depuis la Release v2.0
 */
class Laboratory extends ActiveRecord
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
        return static::find();
    }

    /**
     * Fait la jonction entre un laboratoire et sa liste de matériels.
     * Créer un attribut "equipments" qui sera composé d'une liste d'objet Equipment.
     */
    function getEquipments()
    {
        return $this->hasMany(Equipment::className(), ['laboratory_id' => 'id']);
    }

    /**
     * Fait la jonction entre un laboratoire et sa cellule.
     * Créer un attribut "cellules" qui sera un objet Cellule.
     */
    public function getCellule()
    {
        return $this->hasOne(Cellule::className(), ['id' => 'cellule_id']);
    }
}
