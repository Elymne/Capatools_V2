<?php

namespace app\models\projects;

use app\services\userRoleAccessServices\UserRoleEnum;
use app\services\userRoleAccessServices\UserRoleManager;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;

/**
 * Classe qui hérite de la classe Millestone.
 * Cette classe permet de gérer des règles métiers un peu plus complexe que la classe qu'elle hérite.
 */
class MilestoneSearch extends Millestone
{
    public function rules()
    {
        return [
            [
                ["id", "number", "comment", "pourcentage", "price", "status", "estimate_date", "project_id", "project.internal_name", "cellule.name"],
                "safe"
            ],
        ];
    }

    /**
     * Override de la fonction attributes() de la classe Millestone.
     * Permet de définir de nouveau attributs pour le gridView.
     */
    public function attributes()
    {
        return array_merge(parent::attributes(), ['project.internal_name', "project.cellule.name"]);
    }

    /**
     * Fonction que l'on va utiliser dans la vue index des milestones (jalons).
     * Les data que nous retourne cette fonction nous permet d'ordonner les noms de projet par exemple.
     */
    public function search($params): ?ActiveDataProvider
    {
        if (UserRoleManager::hasRoles([UserRoleEnum::ADMIN, UserRoleEnum::SUPER_ADMIN, UserRoleEnum::ACCOUNTING_SUPPORT])) {
            return $this->createActiveDataProvider(self::find(), $params);
        }

        if (UserRoleManager::hasRoles([UserRoleEnum::PROJECT_MANAGER])) {
            return $this->createActiveDataProvider(self::find()->where(["project.cellule_id" => Yii::$app->user->identity->cellule_id]), $params);
        }

        return null;
    }

    /**
     * Fonction qui permet de créer l'active provider et de la retourner pour notre fonction search.
     */
    private function createActiveDataProvider(ActiveQuery $query, $params): ActiveDataProvider
    {
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false
        ]);

        $dataProvider->sort->attributes['project.internal_name'] = [
            'asc' => ['project.internal_name' => SORT_ASC],
            'desc' => ['project.internal_name' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['project.cellule.name'] = [
            'asc' => ['cellule.name' => SORT_ASC],
            'desc' => ['cellule.name' => SORT_DESC],
        ];

        $this->load($params);
        $query->joinWith(['project'])->joinWith(['project.cellule']);

        if (!$this->validate()) {
            return $dataProvider;
        }

        return $dataProvider;
    }
}
