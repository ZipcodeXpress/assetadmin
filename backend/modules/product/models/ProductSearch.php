<?php

namespace app\modules\product\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\Product\models\Product;

/**
 * ProductSearch represents the model behind the search form about `app\modules\Product\models\Product`.
 */
class ProductSearch extends Product
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id', 'organization_id', 'category_id', 'part_num', 'model_num', 'is_public', 'create_time', 'update_time', 'end_date'], 'integer'],
            [['product_name', 'brand', 'manufacturer', 'UOM', 'product_desc', 'product_image', 'product_thumbnail', 'instruction'], 'safe'],
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
        $query = Product::find();

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
            'product_id' => $this->product_id,
            'organization_id' => $this->organization_id,
            'category_id' => $this->category_id,
            'part_num' => $this->part_num,
            'model_num' => $this->model_num,
            'is_public' => $this->is_public,
            'create_time' => $this->create_time,
            'update_time' => $this->update_time,
            'end_date' => $this->end_date,
        ]);

        $query->andFilterWhere(['like', 'product_name', $this->product_name])
            ->andFilterWhere(['like', 'brand', $this->brand])
            ->andFilterWhere(['like', 'manufacturer', $this->manufacturer])
            ->andFilterWhere(['like', 'UOM', $this->UOM])
            ->andFilterWhere(['like', 'product_desc', $this->product_desc])
            ->andFilterWhere(['like', 'product_image', $this->product_image])
            ->andFilterWhere(['like', 'product_thumbnail', $this->product_thumbnail])
            ->andFilterWhere(['like', 'instruction', $this->instruction]);

        return $dataProvider;
    }
}
