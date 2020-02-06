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
            [['id_capa', 'internal_name', 'filename', 'filename_first_upload', 'filename_last_upload'], 'safe'],
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
    public function search($params)
    {
        $query = Devis::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
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
            ->andFilterWhere(['like', 'filename', $this->filename]);

        return $dataProvider;
    }
}
