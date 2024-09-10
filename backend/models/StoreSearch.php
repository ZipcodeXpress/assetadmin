<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Store;

/**
 * StoreSearch represents the model behind the search form about `backend\models\Store`.
 */
class StoreSearch extends Store
{
    public $email;
    public $phone;
    public $to_email;
    public $to_phone;
    public $courier;
    public $company_name;
    public $model_name;
    //public $storage_duration;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['store_id', 'cabinet_id', 'box_id', 'from_member_id', 'store_time', 'to_member_id', 'pick_expire', 'pick_time', 'clean_time', 'create_time'], 'integer'],
            [['tracking_no', 'to_phone', 'pick_code', 'pick_with'], 'safe'],
            [['pick_fee'], 'number'],
            [['email','phone','to_email','to_phone','courier','company_name','model_name','storage_duration'], 'safe'],
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
        /** //$query = Store::find()->joinWith('member')->leftJoin(['to_member' => Member::tableName()], 'to_member.member_id = member.member_id');
        $query = Store::find()->joinWith('member')->leftJoin(Member::tableName().' as to_member', 'to_member.member_id = o_store.to_member_id')->orderBy('create_time DESC');
        $query->joinWith('courier');
        $query->leftJoin("o_member_organization","to_member.member_id = o_member_organization.member_id");
        $query->leftJoin("o_organization","o_member_organization.organization_id = o_organization.organization_id");
        $query->leftJoin(Unit::tableName(),Unit::tableName().'.unit_id = o_member_organization.unit_id');
        $query->leftJoin("cabinet_box","cabinet_box.box_id = o_store.box_id");
        $query->leftJoin("cabinet_box_model","cabinet_box_model.model_id = cabinet_box.box_model_id");
        $query->select("o_store.*, o_courier.courier_id,o_courier.courier_name,o_member_organization.organization_id,o_unit.unit_name as unit_name,cabinet_box_model.model_name");
        // add conditions that should always apply here
        **/
        $query = Store::find()->leftJoin("member as to_member", "to_member.member_id = o_store.to_member_id")->orderBy('create_time DESC');
        $query->leftjoin("o_courier","o_courier.courier_id=o_store.courier_id");
        $query->leftJoin("o_member_organization","to_member.member_id = o_member_organization.member_id");
        //$query->leftJoin("o_organization","o_member_organization.organization_id = o_organization.organization_id");
        //$query->leftJoin("o_unit","o_unit.unit_id = o_member_organization.unit_id");
        $query->innerJoin("o_organization_cabinet","o_store.cabinet_id = o_organization_cabinet.cabinet_id and o_organization_cabinet.organization_id = o_member_organization.organization_id");
        $query->leftJoin("cabinet_box","cabinet_box.box_id = o_store.box_id");
        $query->leftJoin("cabinet_box_model","cabinet_box_model.model_id = cabinet_box.box_model_id");
        $query->leftJoin("o_courier_company_organization","o_store.courier_id = o_courier_company_organization.courier_id");
        $query->leftJoin("o_courier_company","o_courier_company_organization.company_id = o_courier_company.company_id");
        
        //$query->select("o_store.*,o_courier.courier_name,o_member_organization.organization_id,o_store.to_phone as unit_name,cabinet_box_model.model_name")->distinct();
        if($organizationIds) {
            $query->andFilterWhere(['in', 'o_member_organization.organization_id', explode(',', $organizationIds)]);
        }

        
         $query->select("o_store.*,o_courier.courier_name,o_member_organization.organization_id,o_courier_company.company_name,cabinet_box_model.model_name")->distinct();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
	    'pagination' => [
			'pagesize' => '20',
			]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'store_id' => $this->store_id,
            'o_store.cabinet_id' => $this->cabinet_id,
            'box_id' => $this->box_id,
            'from_member_id' => $this->from_member_id,
            'store_time' => $this->store_time,
            'to_member_id' => $this->to_member_id,
            'pick_expire' => $this->pick_expire,
            'pick_fee' => $this->pick_fee,
            'pick_time' => $this->pick_time,
            'clean_time' => $this->clean_time,
            'create_time' => $this->create_time,
        ]);

        $query->andFilterWhere(['like', 'tracking_no', $this->tracking_no])
        ->andFilterWhere(['like', 'o_courier.courier_name', $this->courier])
        ->andFilterWhere(['like', 'company_name', $this->company_name])
        ->andFilterWhere(['like', 'model_name', $this->model_name])
        //->andFilterWhere(['=', 'time_to_sec(timediff(pick_time,store_time))/3600', $this->storage_duration])
        ->andFilterWhere(['like', 'member.email', $this->email])
        ->andFilterWhere(['like', 'member.phone', $this->phone])
        ->andFilterWhere(['like', 'to_member.email', $this->to_email])
            ->andFilterWhere(['like', 'to_phone', $this->to_phone])
            ->andFilterWhere(['like', 'pick_code', $this->pick_code])
            ->andFilterWhere(['like', 'pick_with', $this->pick_with]);

        return $dataProvider;
    }
}
