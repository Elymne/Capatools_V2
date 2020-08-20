<?php

namespace app\models\equipments;

use app\models\laboratories\Laboratory;
use JsonSerializable;
use yii\db\ActiveRecord;

/**
 * Classe modèle métier des matériels.
 * Permet de faire des requêtes depuis la table equipment de la db associée à l'app.
 * 
 * @version Capatools v2.0
 * @since Classe existante depuis la Release v2.0
 */
class Equipment extends ActiveRecord implements JsonSerializable
{

    /**
     * Utilisé pour définir quelle table est associée à cette classe.
     */
    public static function tableName()
    {
        return 'equipment';
    }

    public function getOneById(int $id)
    {
        return static::find(['id' => $id])->one();
    }

    /**
     * Utilisé pour récupérer tous les matériels.
     * 
     * @return array<Equipment>, une liste d'objet Equipment.
     */
    public static function getAll()
    {
        return static::find()->all();
    }

    /**
     * Permet de récupérer la liste de tous les équipements par rapport à l'id des laboratoires.
     */
    public static function getAllByLaboratoryID($id): array
    {
        return static::find()->where(['laboratory_id' => $id])->all();
    }

    /**
     * Fait la jonction entre un matériel et son laboratoire.
     * Créer un attribut "laboratory" qui sera un objet Laboratory.
     */
    public function getLaboratory()
    {
        return $this->hasOne(Laboratory::class, ['id' => 'laboratory_id']);
    }

    /**
     * Fonction pour envoyer au format json les données de l'objet.
     */
    public function jsonSerialize()
    {
        return array(
            'id' => $this->id,
            'name' => $this->name,
            'price_day' => $this->price_day,
            'price_hour' => $this->price_hour,
            'type' => $this->type,
            'laboratory_id' => $this->laboratory_id
        );
    }
}
