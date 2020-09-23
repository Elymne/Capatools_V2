<?php

namespace app\models\administrativeDocuments;


use yii\db\ActiveRecord;

/**
 * Classe modèle métier des matériels.
 * Permet de faire des requêtes depuis la table equipment de la db associée à l'app.
 * 
 * Notons bien la différence entre une fonction qui renvoi juste une liste de donnes sous la forme d'un tableau 
 * et les fonctions qui retournent un dataProvider pour utiliser les données avec des objets de types GridView.
 * 
 * @version Capatools v2.0
 * @since Classe existante depuis la Release v2.0
 */
class AdministrativeDocument extends ActiveRecord
{

    /**
     * Utilisé pour définir quelle table est associée à cette classe.
     */
    public static function tableName()
    {
        return 'administrative_document';
    }

    public function getOneById(int $id)
    {
        return static::find(['id' => $id])->one();
    }

    /**
     * Récupère toutes les données des document administratifs mais ne transforme pas le résultat en tableau de données utilisable.
     * Le seul propos de l'existance de cette fonction est de permettre de fournir à un GridView des données qu'il puisse traiter et afficher.
     * 
     * @return DataProvider
     */
    static function getAllDataProvider()
    {
        return static::find();
    }

    /**
     * Utilisé pour récupérer tous des documents.
     * 
     * @return array<AdminstrativeDocument>, une liste d'objet documents.
     */
    public static function getAll()
    {
        return static::find()->all();
    }
}
