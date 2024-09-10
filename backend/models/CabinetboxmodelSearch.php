<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Cabinetboxmodel;

/**
 * CabinetBoxModelSearch represents the model behind the search form about `app\models\CabinetBoxModel`.
 */
class CabinetboxmodelSearch extends Cabinetboxmodel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['model_id', 'is_allocable'], 'integer'],
            [['model_name'], 'safe'],
            [['length', 'width', 'height', 'model_price'], 'number'],
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
        $query = Cabinetboxmodel::find();

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
            'model_id' => $this->model_id,
            'length' => $this->length,
            'width' => $this->width,
            'height' => $this->height,
            'is_allocable' => $this->is_allocable,
            'model_price' => $this->model_price,
        ]);

        $query->andFilterWhere(['like', 'model_name', $this->model_name]);

        return $dataProvider;
    }
}
