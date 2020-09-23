<?php

namespace app\models\projects;

use yii\data\ActiveDataProvider;

/**
 * Classe qui hérite de la classe Millestone.
 * Cette classe permet de gérer des règles métiers un peu plus complexe que la classe qu'elle hérite.
 */
class MilestoneSearch extends Millestone
{
    public function rules()
    {
        return [
            [["id", "number", "comment", "pourcentage", "price", "status", "estimate_date", "project_id", "project.internal_name"], "safe"],
        ];
    }

    /**
     * Override de la fonction attributes() de la classe Millestone.
     * Permet de définir de nouveau attributs pour le gridView.
     */
    public function attributes()
    {
        return array_merge(parent::attributes(), ['project.internal_name']);
    }

    /**
     * Fonction que l'on va utiliser dans la vue index des milestones (jalons).
     * Les data que nous retourne cette fonction nous permet d'ordonner les noms de projet par exemple.
     */
    public function search($params)
    {
        $query = self::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false
        ]);

        $dataProvider->sort->attributes['project.internal_name'] = [
            'asc' => ['project.internal_name' => SORT_ASC],
            'desc' => ['project.internal_name' => SORT_DESC],
        ];

        $this->load($params);
        $query->joinWith(['project']);

        if (!$this->validate()) {
            return $dataProvider;
        }

        return $dataProvider;
    }
}
