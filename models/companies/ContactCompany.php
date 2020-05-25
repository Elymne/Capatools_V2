<?php

namespace app\models\companies;

use yii\db\ActiveRecord;

/**
 * Classe modèle métier d'une table d'association, utilisé pour l'instant pour tester la gestion des modèles de Yii2.
 * //TODO classe surement inutile et donc à supprimer. *ne rien faire pour l'instant*
 * 
 * @version Capatools v2.0
 * @since Classe existante depuis la Release v2.0
 */
class Company extends ActiveRecord
{

    /**
     * Utilisé pour définir quelle table est associé à cette classe.
     */
    public static function tableName()
    {
        return 'contact_company';
    }
}
