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
     * Récupère toutes les sociétés dans la base de données.
     * @return Array<Company>
     */
    public static function getAll()
    {
        return static::find();
    }

    /**
     * Récupère une société par son id.
     * @return Company
     */
    public static function getOneById(int $id)
    {
        return static::find(['id' => $id])->one();
    }

    /**
     * Créer un attributs contenant la liste des projets des sociétés retournées.
     * @return Array<Project>
     */
    public function getProjects()
    {
        return $this->hasMany(Project::className(), ['company_id' => 'id']);
    }
}
