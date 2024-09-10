<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\ProductInventory;

/**
 * ProductInventorySearch represents the model behind the search form about `backend\models\ProductInventory`.
 */
class ProductInventorySearch extends ProductInventory
{
    /**
     * @inheritdoc
     */

    public $ProductName;
    public $memberemail;

    public function rules()
    {
        return [
            [['product_inventory_id', 'product_id', 'cabinet_id', 'organization_id', 'member_id',  'product_status_code', 'create_time', 'update_time', 'end_time'], 'integer'],
            [['rfid', 'ProductName','product_service_type', 'memberemail','reg_date'], 'safe'],
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
    public function search($params, $organizationIds = NULL)
    {
        
        // add conditions that should always apply here
        
      //  $query = ProductInventory::find()->leftJoin("product", "product.product_id = product_inventory.product_id")->orderBy('product.product_name DESC');
     //   $query->leftJoin("o_organization","o_organization.organization_id = product_inventory.organization_id");
     //   $query->leftJoin("cabinet_box","cabinet_box.box_id = product_inventory.box_id");
     //   $query->leftJoin("cabinet_box_model","cabinet_box_model.model_id = cabinet_box.box_model_id");
     $query = ProductInventory::find();
     $query -> joinwith('product');
     $query -> joinwith('organization');
     $query -> joinwith('member');
  
        
        if($organizationIds) {
            $query->andFilterWhere(['in', 'o_organization.organization_id', explode(',', $organizationIds)]);
        }
        //$query->select("o_store.*,o_courier.courier_name,o_member_organization.organization_id,o_store.to_phone as unit_name,cabinet_box_model.model_name")->distinct();
       

        
       // $query->select("o_store.*,o_courier.courier_name,o_member_organization.organization_id,o_courier_company.company_name,cabinet_box_model.model_name")->distinct();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
	    'pagination' => [
			'pagesize' => '20',
			]
        ]);

        $this->load($params);
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'product_inventory_id' => $this->product_inventory_id,
            'product_id' => $this->product_id,
            'cabinet_id' => $this->cabinet_id,
           
            'organization_id' => $this->organization_id,
            'member_id' => $this->member_id,
          // 'cabinetbox.column' => $this->column,
          //  'row' => $this->row,
            'product_status_code' => $this->product_status_code,
            'reg_date' => $this->reg_date,
            'create_time' => $this->create_time,
            'update_time' => $this->update_time,
            'end_time' => $this->end_time,
        ]);

        $query->andFilterWhere(['like', 'rfid', $this->rfid])
            ->andFilterWhere(['like', 'product_service_type', $this->product_service_type])
            ->andFilterWhere(['like', 'email', $this->memberemail])
            ->andFilterWhere(['like', 'product_name', $this->ProductName]);
          


        return $dataProvider;
    }
}
