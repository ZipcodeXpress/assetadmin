<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\ProductCategory;

/**
 * ProductCategorySearch represents the model behind the search form of `backend\models\ProductCategory`.
 */
class ProductCategorySearch extends ProductCategory
{
    public $organization_name;
   
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_cate_id', 'organization_id','create_time', 'update_time'], 'integer'],
            [['product_cate_name', 'product_cate_desc'], 'safe'],
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
        $query = ProductCategory::find()->joinWith('organization');
        
        if($organizationIds) {
            $query->andFilterWhere(['in', 'o_organization.organization_id', explode(',', $organizationIds)]);
        }

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);
//var_dump($organizationIds);
        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'product_cate_id' => $this->product_cate_id,
            'organization_id' => $this->organization_id,
      //      'create_time' => $this->create_time,
      //      'update_time' => $this->update_time,
        ]);

        $query->andFilterWhere(['like', 'product_cate_name', $this->product_cate_name])
       ->andFilterWhere(['like', 'organization_name', $this->organization_name])
        ->andFilterWhere(['like', 'product_cate_desc', $this->product_cate_desc]);
        

        return $dataProvider;
    }
}
