<?php

namespace app\models\user;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * Cette classe permet de gérer différentes fonctionnalité à travers un objet GridView qui sert à afficher les données
 * d'un modèle sous la forme d'un tableau.
 * Il permet entre autre :
 * - De filtrer les modèles à afficher (inutilisé ici).
 * - D'ordonner les données par ordre ASC/DESC.
 * 
 * Il faut utiliser cette classe lorsque vous voulez récupérer toutes les données des rôles utilisateurs et les afficher dans un GridView.
 * Etant donné que cette classe hérite de la classe UserRole, vous pouvez utiliser toutes les fonctions ORM (getAll ect...).
 * 
 * Notons que dans cette classe, nous faisons une grosses jointures avec les tables associés à la table capa_user (les cellules..).
 * 
 * @version Capatools v2.0
 * @since Classe existante depuis la Release v2.0
 * @deprecated Cette classe n'est plus utilisé car c'est le système de droits de Yii2 qui prend en charge cette fonctionnalité désormais.
 */
class UserRoleSearch extends UserRole
{

    /**
     * Fonction provenant de la classe ActiveRecord, elle permet de vérifier l'intégrité des données.
     */
    public function rules()
    {
        return [
            [['id', 'user_id'], 'integer'],
            [['service', 'role'], 'safe'],
        ];
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
    public function search($params, $user_id)
    {
        $query = UserRole::find()->where(['user_id' => $user_id]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
            'sort' => [
                'defaultOrder' => [
                    'service' => SORT_ASC,
                ]
            ],
        ]);


        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }


        // grid filtering conditions      
        $query->andFilterWhere(['like', 'service', $this->service]);
        return $dataProvider;
    }
}
