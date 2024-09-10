<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\ProductAuth;

/**
 * ProductAuthSearch represents the model behind the search form about `backend\models\ProductAuth`.
 */
class ProductAuthSearch extends ProductAuth
{
    public $product_name;
    public $member_firstname;
    public $member_lastname;
    public $org_name;
    public $status;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id', 'member_id', 'auth_code', 'organization_id', 'cancel_time', 'created_time', 'approve_time', 'approve_status',], 'integer'],
            [['product_name', 'member_firstname', 'member_lastname', 'org_name'], 'safe'],
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
    public function search($params, $organizationIds = null)
    {
        $query = ProductAuth::find()->joinWith('product')->joinWith('profile')->joinWith('organization');

        // add conditions that should always apply here
        if ($organizationIds) {
            $query->andFilterWhere(['in', 'o_product_auth.organization_id', explode(',', $organizationIds)]);
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
            // 'product.product_name' => $this->product_name,
            //   'o_organization.organization_name' => $this->org_name,
            'approve_time' => $this->approve_time,
            'approve_status' => $this->approve_status,
            'auth_code' => $this->status,
            'o_product_auth.product_id' => $this->product_id,
            'organization_id' => $this->organization_id,
            'member_id' => $this->member_id,
            'cancel_time' => $this->cancel_time,
            'create_time' => $this->created_time,
        ]);

        $query->andFilterWhere(['like', 'product.product_name', $this->product_name])
            ->andFilterWhere(['like', 'o_organization.organization_name', $this->org_name])
            ->andFilterWhere(['like', 'member_profile.first_name', $this->member_firstname])
            ->andFilterWhere(['like', 'member_profile.last_name', $this->member_lastname]);
        return $dataProvider;
    }
}
