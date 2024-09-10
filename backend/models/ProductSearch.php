<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Product;

/**
 * ProductSearch represents the model behind the search form about `backend\models\Product`.
 */
class ProductSearch extends Product
{
    /**
     * @inheritdoc
     */
    public $product_cate_name;
    public $organization_name;
    public $model_name; 
    public function rules()
    {
        return [
            [['product_id', 'organization_id', 'category_id','boxmodel_id','part_num', 'model_num', 'is_public', 'create_time', 'update_time', 'end_date'], 'integer'],
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
    public function search($params,$organizationIds=null)
    {
        $query = Product::find();
        $query->joinWith('productcategory');
        $query->joinWith('organization');
        $query->joinWith('boxmodel');
        // add conditions that should always apply here


        if($organizationIds) {
            $query->andFilterWhere(['in', 'product.organization_id', explode(',', $organizationIds)]);
        }
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
            'product.organization_id'=>$this->organization_id,
            'cabinet_box_model.model_id'=>$this->boxmodel_id,
            'product.category_id' => $this->category_id,
          //  'part_num' => $this->part_num,
          //  'model_num' => $this->model_num,
          // 'is_public' => $this->is_public,
           
        ]);

        $query->andFilterWhere(['like', 'product_name', $this->product_name])
        ->andFilterWhere(['like', 'product_cate_name', $this->product_cate_name])
        ->andFilterWhere(['like', 'model_name', $this->model_name])
            ->andFilterWhere(['like', 'brand', $this->brand])
            ->andFilterWhere(['like', 'manufacturer', $this->manufacturer])
            ->andFilterWhere(['like', 'organization_name', $this->organization_name])
            ->andFilterWhere(['like', 'product_desc', $this->product_desc])
           
            ->andFilterWhere(['like', 'instruction', $this->instruction]);

        return $dataProvider;
    }
}
