<?php

namespace app\models\user;

use Yii;
use yii\db\ActiveRecord;
use yii\base\Model;
use yii\data\ActiveDataProvider;

use app\models\user\userrightapplication;

class UserRightApplicationSearch extends UserRightApplication
{

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'Userid'], 'integer'],
            [['Application', 'Credential'], 'safe'],
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
    public function search($params, $userid)
    {
        $query = userrightapplication::find()->where(['userid' => $userid]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
            'sort' => [
                'defaultOrder' => [
                    'Application' => SORT_ASC,
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
        $query->andFilterWhere(['like', 'Application', $this->Application]);
        return $dataProvider;
    }
}
