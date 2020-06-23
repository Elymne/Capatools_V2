<?php

namespace app\models\projects;

use app\models\laboratories\Laboratory;
use yii\db\ActiveRecord;

/**
 * Classe modèle métier des reversements..
 * Permet de faire des requêtes depuis la table devis de la db associé à l'app.
 * Marche de la même manière qu'un ORM (voir la fonction getAll par l'exemple).
 * C'est un modèle dont l'objectif est de ralier plusieurs modèles utilisés pour la gestion des reversements labo.
 * 
 * @version Capatools v2.0
 * @since Classe existante depuis la Release v2.0
 */
class Repayment extends ActiveRecord
{

    /**
     * Permet de définir le nom de la table associé.
     */
    public static function tableName()
    {
        return 'repayment';
    }

    /**
     * Fonction de jointure au modèle des lots.
     * Créer un attribut "lot" de type <Lot>.
     * 
     * @return Lot, un lot.
     */
    public function getLot()
    {
        return $this->hasOne(Lot::className(), ['id' => 'lot_id']);
    }

    /**
     * Fonction de jointure au modèle des laboratoires.
     * Créer un attribut "laboratory" de type <Laboratory>.
     * 
     * @return Laboratory, un laboratoire.
     */
    public function getLaboratory()
    {
        return $this->hasOne(Laboratory::className(), ['id' => 'laboratory_id']);
    }


    public function getTasks()
    {
        return $this->hasMany(Task::className(), ['lot_id' => 'id']);
    }

    //TODO update pour les autres jointures qui n'existent pas encore.
}
