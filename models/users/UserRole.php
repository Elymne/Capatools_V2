<?php

namespace app\models\users;

use yii\db\ActiveRecord;

/**
 * Classe modèle métier des roles utilisateurs.
 * Permet de faire des requêtes depuis la table capa_user de la db associé à l'app.
 * Marche de la même manière qu'un ORM (voir la fonction getAll par l'exemple).
 * 
 * Cette classe implémente l'interface IDentityInterface qui permet de gérer les utiliseurs et la sécurité à la manière de Yii2.
 * 
 * @version Capatools v2.0
 * @since Classe existante depuis la Release v2.0
 * @deprecated Cette classe n'est plus utilisé car c'est le système de droits de Yii2 qui prend en charge cette fonctionnalité désormais.
 */
class UserRole extends ActiveRecord
{
    public static function tableName()
    {
        return 'user_role';
    }

    public function getCapaUser()
    {
        return $this->hasOne(CapaUser::className(), ['id' => 'user_id']);
    }
}
