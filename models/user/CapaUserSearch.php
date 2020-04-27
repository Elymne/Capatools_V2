<?php

namespace app\models\user;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\user\CapaUser;

/**
 * CapaUserSearch represents the model behind the search form of `app\models\user\CapaUser`.
 */
class CapaUserSearch extends CapaUser
{
    public $name;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'cellule_id', 'flag_password'], 'integer'],
            [['username', 'email', 'auth_key', 'password_hash', 'cellule.name', 'userRight'], 'safe'],
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
                'pageSize' => 10,
            ],
            'sort' => [
                'defaultOrder' => [
                    'username' => SORT_ASC,
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

        $query->andFilterWhere(['like', 'username', $this->username])
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
                'pageSize' => 10,
            ],
            'sort' => [
                'defaultOrder' => [
                    'username' => SORT_ASC,
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

        $query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'auth_key', $this->auth_key])
            ->andFilterWhere(['like', 'password_hash', $this->password_hash])
            ->andFilterWhere(['like', 'cellule.name', $this->getAttribute('cellule.name')]);

        return $dataProvider;
    }
}
