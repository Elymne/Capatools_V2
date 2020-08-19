<?php

namespace app\models\companies;

use app\models\projects\Project;
use yii\db\ActiveRecord;

/**
 * Classe modèle métier des contacts.
 * Permet de faire des requêtes depuis la table contact de la db associé à l'app.
 * Marche de la même manière qu'un ORM (voir la fonction getAll par l'exemple).
 * 
 * @version Capatools v2.0
 * @since Classe existante depuis la Release v2.0
 */
class Contact extends ActiveRecord
{

    /**
     * Utilisé pour définir quelle table est associé à cette classe.
     */
    public static function tableName()
    {
        return 'contact';
    }

    /**
     * Récupère tous les contactes dans la base de données.
     * @return Array<Contact>
     */
    public static function getAll()
    {
        return static::find();
    }

    /**
     * Récupère un contacte par son id.
     * @return Contact
     */
    public static function getOneById(int $id)
    {
        return static::find()->where(['id' => $id])->one();
    }


    /**
     * Récupère un contact grace à son email.
     * @param string email
     * 
     * @return Contact
     */
    public static function getOneByEmail(string $email): Contact
    {
        return static::find()->where(['email' => $email])->one();
    }

    /**
     * Créer un attributs contenant la liste des projets des contactes retournés.
     * @return Array<Project>
     */
    public function getProjects()
    {
        return $this->hasMany(Project::class, ['contact_id' => 'id']);
    }
}
