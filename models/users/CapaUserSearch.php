<?php

namespace app\models\users;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\users\CapaUser;


/**
 * Cette classe permet de gérer différentes fonctionnalité à travers un objet GridView qui sert à afficher les données
 * d'un modèle sous la forme d'un tableau.
 * Il permet entre autre :
 * - De filtrer les modèles à afficher (inutilisé ici).
 * - D'ordonner les données par ordre ASC/DESC.
 * 
 * Il faut utiliser cette classe lorsque vous voulez récupérer toutes les données des utilisateurs et les afficher dans un GridView.
 * Etant donné que cette classe hérite de la classe Devis, vous pouvez utiliser toutes les fonctions ORM (getAll ect...).
 * 
 * Notons que dans cette classe, nous faisons une grosses jointures avec les tables associés à la table capa_user (les cellules..).
 * 
 * @version Capatools v2.0
 * @since Classe existante depuis la Release v2.0
 */
class CapaUserSearch extends CapaUser
{
    public $name;

    /**
     * Fonction provenant de la classe ActiveRecord, elle permet de vérifier l'intégrité des données.
     */
    public function rules()
    {
        return [
            [['id', 'cellule_id', 'flag_password'], 'integer'],
            [['firstname', 'surname', 'email', 'auth_key', 'password_hash', 'cellule.name', 'userRight'], 'safe'],
        ];
    }

    public function attributes()
    {
        // add related fields to searchable attributes
        return array_merge(parent::attributes(), ['cellule.name']);
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
    public function searchFilter($params, array $filters)
    {

        $query = CapaUser::find()->where($filters);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => -1,
            ],
            'sort' => [
                'defaultOrder' => [
                    'surname' => SORT_ASC,
                ]
            ],
        ]);

        $dataProvider->sort->attributes['cellule.name'] = [
            'asc' => ['cellule.name' => SORT_ASC],
            'desc' => ['cellule.name' => SORT_DESC],
        ];

        $dataProvider->sort->defaultOrder = ['cellule.name' => SORT_ASC];
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            $query->joinWith(['cellule']);
            return $dataProvider;
        }
        // filter by cellule name
        $query->joinWith(['cellule' => function ($q) {
            $q->where('cellule.name LIKE "%' . $this->cellule . '%"');
        }]);

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'cellule_id' => $this->cellule_id,
            'flag_password' => $this->flag_password,
        ]);

        $query->andFilterWhere(['like', 'firstname', $this->firstname])
            ->andFilterWhere(['like', 'surname', $this->surname])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'auth_key', $this->auth_key])
            ->andFilterWhere(['like', 'password_hash', $this->password_hash])
            ->andFilterWhere(['like', 'cellule.name', $this->getAttribute('cellule.name')]);

        return $dataProvider;
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
        $query = CapaUser::find()->where(['flag_active' => true]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => -1,
            ],
            'sort' => [
                'defaultOrder' => [
                    'surname' => SORT_ASC,
                ]
            ],
        ]);

        $dataProvider->sort->attributes['cellule.name'] = [
            'asc' => ['cellule.name' => SORT_ASC],
            'desc' => ['cellule.name' => SORT_DESC],
        ];

        $dataProvider->sort->defaultOrder = ['cellule.name' => SORT_ASC];
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            $query->joinWith(['cellule']);
            return $dataProvider;
        }
        // filter by cellule name
        $query->joinWith(['cellule' => function ($q) {
            $q->where('cellule.name LIKE "%' . $this->cellule . '%"');
        }]);

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'cellule_id' => $this->cellule_id,
            'flag_password' => $this->flag_password,
        ]);

        $query->andFilterWhere(['like', 'firstname', $this->firstname])
            ->andFilterWhere(['like', 'surname', $this->surname])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'auth_key', $this->auth_key])
            ->andFilterWhere(['like', 'password_hash', $this->password_hash])
            ->andFilterWhere(['like', 'cellule.name', $this->getAttribute('cellule.name')]);

        return $dataProvider;
    }
}
