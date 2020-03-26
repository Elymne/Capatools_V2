<?php

namespace app\models\devis;

use app\helper\_enum\UserRoleEnum;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\devis\Devis;
use Yii;

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
            [['id', 'service_duration', 'version', 'cellule_id', 'company_id', 'capa_user_id', 'status_id', 'delivery_type_id'], 'integer'],
            [['id_capa', 'internal_name', 'filename', 'filename_first_upload', 'filename_last_upload', 'capa_user.username', 'company.name', 'cellule.name', 'delivery_type.label'], 'safe'],
        ];
    }

    public function attributes()
    {
        // add related fields to searchable attributes
        return array_merge(parent::attributes(), ['capa_user.username', 'company.name', 'cellule.name', 'devis_status.label', 'delivery_type.label']);
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
        // Prepare query.
        $query = null;

        if (Yii::$app->user->can(UserRoleEnum::OPERATIONAL_MANAGER_DEVIS) || Yii::$app->user->can(UserRoleEnum::ACCOUNTING_SUPPORT_DEVIS)) {
            $query = Devis::find();
        } else {
            $query = Devis::getAllByCellule(Yii::$app->user->identity->cellule->id);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
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

        $dataProvider->sort->attributes['capa_user.username'] = [
            'asc' => ['capa_user.username' => SORT_ASC],
            'desc' => ['capa_user.username' => SORT_DESC],
        ];


        $dataProvider->sort->attributes['delivery_type.label'] = [
            'asc' => ['delivery_type.label' => SORT_ASC],
            'desc' => ['delivery_type.label' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['devis_status.label'] = [
            'asc' => ['devis_status.label' => SORT_ASC],
            'desc' => ['devis_status.label' => SORT_DESC],
        ];


        $this->load($params);
        $query->joinWith(['capa_user']);
        $query->joinWith(['cellule']);
        $query->joinWith(['company']);
        $query->joinWith(['devis_status']);
        $query->joinWith(['delivery_type']);

        if (!$this->validate()) {
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'service_duration' => $this->service_duration,
            'version' => $this->version,
            'filename_first_upload' => $this->filename_first_upload,
            'filename_last_upload' => $this->filename_last_upload,
            'cellule_id' => $this->cellule_id,
            'company_id' => $this->company_id,
            'capa_user_id' => $this->capa_user_id,
            'delivery_type_id' => $this->delivery_type_id,
        ]);

        $query->andFilterWhere(['like', 'id_capa', $this->id_capa])
            ->andFilterWhere(['like', 'internal_name', $this->internal_name])
            ->andFilterWhere(['like', 'filename', $this->filename])
            ->andFilterWhere(['like', 'cellule.name', $this->getAttribute('cellule.name')])
            ->andFilterWhere(['like', 'company.name', $this->getAttribute('company.name')])
            ->andFilterWhere(['like', 'capa_user.username', $this->getAttribute('capa_user.username')])
            ->andFilterWhere(['like', 'delivery_type.label', $this->getAttribute('delivery_type.label')])
            ->andFilterWhere(['like', 'devis_status.label', $this->getAttribute('devis_status.label')]);

        return $dataProvider;
    }
}
