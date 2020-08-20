<?php

namespace app\models\companies;

use app\models\projects\Project;
use yii\db\ActiveRecord;

/**
 * Classe modèle métier des sociétés.
 * Permet de faire des requêtes depuis la table company de la db associé à l'app.
 * Marche de la même manière qu'un ORM (voir la fonction getAll par l'exemple).
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
        return 'company';
    }

    /**
     * Utilisé pour fonctionner avec un GridView.
     * Il retourne non pas un tableau de données classique avec chaque société mais un objet de type DataProvider.
     * 
     * @return DataProvider
     */
    static function getAllDataProvider()
    {
        return static::find();
    }

    /**
     * Récupère toutes les sociétés dans la base de données.
     * 
     * @return Array<Company>
     */
    public static function getAll()
    {
        return static::find()->all();
    }

    /**
     * Récupère une société par son id.
     * 
     * @return Company
     */
    public static function getOneById(int $id)
    {
        return static::find()->where(['id' => $id])->one();
    }

    /**
     * Récupère une société par son nom.
     * @param string name
     * 
     * @return Company
     */
    public static function getOneByName(string $name): Company
    {
        return static::find()->where(['name' => $name])->one();
    }

    /**
     * Créer un attribut contenant la liste des projets des sociétés retournées.
     * (Cette méthode peut-être utilisé à la place de l'attribut généré).
     * 
     * @return Array<Project>
     */
    public function getProjects()
    {
        return $this->hasMany(Project::className(), ['company_id' => 'id']);
    }

    /**
     * Créer un attribut contenant la liste de tous les contacts associé aux projets du client.
     * (Cette méthode peut-être utilisé à la place de l'attribut généré).
     * 
     * @return Array<Contact>
     */
    public function getContacts(): array
    {
        $contacts = [];
        foreach ($this->projects as $project) {
            array_push($contacts, $project->contact);
        }

        return $contacts;
    }
}
