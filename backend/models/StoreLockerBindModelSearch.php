<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\StoreLockerBindModel;

/**
 * OrganizationCabinetSearch represents the model behind the search form about `backend\models\OrganizationCabinet`.
 */
class StoreLockerBindModelSearch extends StoreLockerBindModel
{
    public $name;
    public $address;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['oc_store_id', 'cabinet_id', 'create_time'], 'integer'],
            [['name', 'address'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
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
        $query = StoreLockerBindModel::find()->joinWith('store')->joinWith('cabinet');

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
            'oc_store_id' => $this->oc_store_id,
            'cabinet_id' => $this->cabinet_id,
            'create_time' => $this->create_time,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
        ->andFilterWhere(['like', 'cabinet.address', $this->address]);
        
        return $dataProvider;
    }
}
