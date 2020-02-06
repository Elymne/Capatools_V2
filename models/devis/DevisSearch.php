<?php

namespace app\models\devis;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\devis\Devis;

/**
 * DevisSearch represents the model behind the search form of `app\models\devis\Devis`.
 */
class DevisSearch extends Devis
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'service_duration', 'version', 'cellule_id', 'company_id', 'capaidentity_id'], 'integer'],
            [['id_capa', 'internal_name', 'filename', 'filename_first_upload', 'filename_last_upload', 'capaidentity.username', 'company.name', 'cellule.name'], 'safe'],
        ];
    }

    public function attributes()
    {
        // add related fields to searchable attributes
        return array_merge(parent::attributes(), ['capaidentity.username', 'company.name', 'cellule.name']);
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
        $query = Devis::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20,
            ]
        ]);

        $dataProvider->sort->attributes['cellule.name'] = [
            'asc' => ['cellule.name' => SORT_ASC],
            'desc' => ['cellule.name' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['company.name'] = [
            'asc' => ['company.name' => SORT_ASC],
            'desc' => ['company.name' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['capaidentity.username'] = [
            'asc' => ['capaidentity.username' => SORT_ASC],
            'desc' => ['capaidentity.username' => SORT_DESC],
        ];
        

        $this->load($params);
        $query->joinWith(['capaidentity']);
        $query->joinWith(['cellule']);
        $query->joinWith(['company']);

        if (!$this->validate()) {
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'service_duration' => $this->service_duration,
            'version' => $this->version,
            'filename_first_upload' => $this->filename_first_upload,
            'filename_last_upload' => $this->filename_last_upload,
            'cellule_id' => $this->cellule_id,
            'company_id' => $this->company_id,
            'capaidentity_id' => $this->capaidentity_id,
        ]);

        $query->andFilterWhere(['like', 'id_capa', $this->id_capa])
            ->andFilterWhere(['like', 'internal_name', $this->internal_name])
            ->andFilterWhere(['like', 'filename', $this->filename])
            ->andFilterWhere(['like', 'cellule.name', $this->getAttribute('cellule.name')])
            ->andFilterWhere(['like', 'company.name', $this->getAttribute('company.name')])
            ->andFilterWhere(['like', 'capaidentity.username', $this->getAttribute('capaidentity.username')]);

        return $dataProvider;
    }
}
