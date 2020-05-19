<?php

namespace app\models\devis;

use yii\db\ActiveRecord;

/**
 * Classe modèle métier des types de projet.
 * Permet de faire des requêtes depuis la table delivery_type de la db associé à l'app.
 * Marche de la même manière qu'un ORM (voir la fonction getAll par l'exemple).
 * 
 * @version Capatools v2.0
 * @since Classe existante depuis la Release v2.0
 */
class DeliveryType  extends ActiveRecord
{

    /**
     * Utilisé pour définir quelle table est associé à cette classe.
     */
    public static function tableName()
    {
        return 'delivery_type';
    }

    public static function getDeliveryTypes()
    {
        return DeliveryType::find()->asArray()->All();
    }
}
