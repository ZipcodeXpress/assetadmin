<?php
/**
 * Date: 2016-7-6
 * Time: 15:10
 * Description:公共函数类库
 */

namespace backend\components;
use backend\models\Log;
use Yii;
use backend\models\Organization;
use yii\helpers\ArrayHelper;
use backend\models\Couriercompany;
use backend\controllers\CommonController;
use backend\models\Store;
use backend\models\Memberorganization;
use backend\models\OrganizationCabinet;
use backend\models\Cabinetboxmodel;

class Helper {

    /*历史访客数*/
    public static function getHistoryVisNum(){
        $res = Log::find()->count();
        return $res;
    }

    /*最近一个月访问量*/
    public static function getMonthHistoryVisNum(){
        $LastMonth = strtotime("-1 month");
        $res = Log::find()->where(['>','create_time',$LastMonth])->count();
        return $res;
    }
    public static function getCompany()
    {
        $companys = Couriercompany::find()->all();
        $companys = ArrayHelper::map($companys, "company_id", "company_name");
        return $companys;
    }
    public static function getOrganizations()
    {
        $organizations = [];
        if(strtolower(Yii::$app->user->identity->usergroup->item_name) == 'superadmin')
        {
            $organizations = Organization::find()->all();
            $organizations = ArrayHelper::map($organizations, "organization_id", "organization_name");
        }
        else
        {
            $organizations = [];
            if(Yii::$app->user->identity->organization_ids)
            {
                $apt_ids = array_filter(explode(',', Yii::$app->user->identity->organization_ids));
                foreach ($apt_ids as $key=>$id)
                {
                    $organization = Organization::findOne(['organization_id'=>$id]);
                    if(!empty($organization))
                    {
                        $organizations[$organization->organization_id] = $organization->organization_name;
                    }
                }
            }
        }
        return $organizations;
    }
    public static function decodeChargeRule($charge_rules)
    {
        $box_models = Cabinetboxmodel::find()->where(['is_allocable'=>1])->asArray()->all();
        if(empty($charge_rules))
        {
            $box_penalty = array();
            foreach ($box_models as $key=>$value)
            {
                $box_penalty[$value['model_id']] = ["amount"=>"0","pay_online"=> "1","grace_day"=> 1];
            }
            $charge_rules_arr = array(
                "signup_fee" => array("amount" => 0,"pay_online"=> 0),
                "monthly_fee" => array("amount" => 0,"pay_online"=> 1),
                "box_penalty"=>$box_penalty,
            );
            $charge_rules = json_encode($charge_rules_arr);
        }
        $rules = json_decode($charge_rules,true);
        return $rules;
    }
    public static function getOverDueFee($storeId) 
    {
        $fee = 0;
        $storeModel = Store::findOne(['store_id'=>$storeId]);
        if(!isset($storeModel->box->box_model_id)) {return $fee;} 
        $box_model_id = $storeModel->box->box_model_id;
        $organization_id = OrganizationCabinet::findOne(['cabinet_id'=>$storeModel->cabinet_id])->organization_id;
        if($organization_id)
        {
            $organizationModel = Organization::findOne(['organization_id'=>$organization_id]);
            $rules = self::decodeChargeRule($organizationModel->charge_rule);
            if(isset($rules['box_penalty']))
            {
                if(empty($storeModel->pick_time))
                {
					$over_days=0;
					if(isset($rules['box_penalty'][$box_model_id]['grace_day']))
					{
                     $over_days = (time()-$storeModel->store_time)/3600/24 - $rules['box_penalty'][$box_model_id]['grace_day'];
                     if( $over_days > 0)
                     {
                        $fee = round($over_days * $rules['box_penalty'][$box_model_id]['amount'],1);
                     }
					}
                   
                }
                else 
                {
                    $over_days = ($storeModel->pick_time-$storeModel->store_time)/3600/24 - $rules['box_penalty'][$box_model_id]['grace_day'];
                    if($over_days > 0)
                    {
                        $fee = round($over_days*$rules['box_penalty'][$box_model_id]['amount'],1);
                    }
                   
                }
            }
        }
        return $fee;
    }
}
