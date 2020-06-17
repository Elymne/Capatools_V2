<?php

namespace app\models\projects;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\projects\Project;

/**
 * Cette classe permet de gérer différentes fonctionnalité à travers un objet GridView qui sert à afficher les données
 * d'un modèle sous la forme d'un tableau.
 * Il permet entre autre :
 * - De filtrer les modèles à afficher (inutilisé ici).
 * - D'ordonner les données par ordre ASC/DESC.
 * 
 * Il faut utiliser cette classe lorsque vous voulez récupérer toutes les données des projets et les afficher dans un GridView.
 * Etant donné que cette classe hérite de la classe Project, vous pouvez utiliser toutes les fonctions ORM (getAll ect...).
 * 
 * Notons que dans cette classe, nous faisons une grosses jointures avec les tables associés à la table project (les cellules, nom de société ect..).
 * 
 * @version Capatools v2.0
 * @since Classe existante depuis la Release v2.0
 */
class ProjectSearch extends Project
{

    /**
     * Fonction provenant de la classe ActiveRecord, elle permet de vérifier l'intégrité des données.
     */
    public function rules()
    {
        return [
            [['id', 'prospecting_time_day', 'version', 'cellule_id', 'company_id', 'capa_user_id'], 'integer'],
            [['id_capa', 'internal_name', 'project_manager.email', 'company.name', 'cellule.name'], 'safe'],
        ];
    }


    public function attributes()
    {
        return array_merge(parent::attributes(), ['project_manager.email', 'company.name', 'cellule.name']);
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {

        $query = Project::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false
        ]);

        $dataProvider->sort->attributes['cellule.name'] = [
            'asc' => ['cellule.name' => SORT_ASC],
            'desc' => ['cellule.name' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['company.name'] = [
            'asc' => ['company.name' => SORT_ASC],
            'desc' => ['company.name' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['project_manager.email'] = [
            'asc' => ['project_manager.email' => SORT_ASC],
            'desc' => ['project_manager.email' => SORT_DESC],
        ];

        $this->load($params);
        $query->joinWith(['project_manager']);
        $query->joinWith(['cellule']);
        $query->joinWith(['company']);

        if (!$this->validate()) {
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'prospecting_time_day' => $this->prospecting_time_day,
            'version' => $this->version,
            'cellule_id' => $this->cellule_id,
            'company_id' => $this->company_id,
            'capa_user_id' => $this->capa_user_id,
        ]);

        $query->andFilterWhere(['like', 'id_capa', $this->id_capa])
            ->andFilterWhere(['like', 'internal_name', $this->internal_name])
            ->andFilterWhere(['like', 'cellule.name', $this->getAttribute('cellule.name')])
            ->andFilterWhere(['like', 'company.name', $this->getAttribute('company.name')])
            ->andFilterWhere(['like', 'project_manager.email', $this->getAttribute('project_manager.email')]);

        return $dataProvider;
    }
}
