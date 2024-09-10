<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\ProductRental;
use backend\models\Organization;
use backend\models\ProductInventory;

/**
 * ProductRentalSearch represents the model behind the search form about `backend\models\ProductRental`.
 */
class ProductRentalSearch extends ProductRental
{
    /**
     * @inheritdoc
     */
    public $email; 
    public $aptname;
    public $product_name;

    public function rules()
    {
        return [
            [['rental_id', 'organization_id', 'cabinet_id', 'product_inventory_id',  'reserve_time', 'expire_time', 'rental_time', 'applied_free_days', 'return_locker_id', 'return_time', 'return_elapsed_days', 'Is_comment', 'Is_delete'], 'integer'],
            [['rfid', 'pickup_code', 'member_id','rental_status_code', 'email', 'product_name','aptname'], 'safe'],
            [['applied_deposit', 'applied_daily_fee', 'applied_sale_amt', 'total_charged_amt'], 'number'],
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
      //  $query = ProductRental::find();
        $query = ProductRental::find();
        $query->joinwith('member');
        $query->joinwith('organization');
        $query->joinwith('productInventory');
        $query->leftJoin(Product::tableName(),Product::tableName().'.product_id = product_inventory.product_id');


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
            'rental_id' => $this->rental_id,
            'organization_id' => $this->organization_id,
            'cabinet_id' => $this->cabinet_id,
            'product_inventory_id' => $this->product_inventory_id,
            'member_id' => $this->member_id,
   //        'member.email' => $this->email,
            'reserve_time' => $this->reserve_time,
            'expire_time' => $this->expire_time,
            'rental_time' => $this->rental_time,
            'applied_deposit' => $this->applied_deposit,
            'applied_daily_fee' => $this->applied_daily_fee,
            'applied_sale_amt' => $this->applied_sale_amt,
            'applied_free_days' => $this->applied_free_days,
            'return_locker_id' => $this->return_locker_id,
            'return_time' => $this->return_time,
            'return_elapsed_days' => $this->return_elapsed_days,
            'total_charged_amt' => $this->total_charged_amt,
            'Is_comment' => $this->Is_comment,
            'Is_delete' => $this->Is_delete,
        ]);

        $query->andFilterWhere(['like', 'rfid', $this->rfid])
            ->andFilterWhere(['like', 'pickup_code', $this->pickup_code])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'product.product_name', $this->product_name])
            ->andFilterWhere(['like', 'organization_name', $this->aptname])
            ->andFilterWhere(['like', 'rental_status_code', $this->rental_status_code]);

        return $dataProvider;
    }
}
