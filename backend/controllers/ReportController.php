<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 */
class ReportController extends CommonController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'index' => ['GET'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index', [
        ]);
    }
    
    public function actionChart()
    {
        return $this->render('chart', [
        ]);
    }

    public function actionZippora()
    {
        $is_super_admin = strtolower(Yii::$app->user->identity->usergroup['item_name'])=='superadmin';
        $apt_ids = array_filter(explode(',', Yii::$app->user->identity->organization_ids));
        //count o_member_organization
        $count1 = $is_super_admin?
            (new \yii\db\Query())
            ->from('o_member_organization')
            ->where([
                'status' => 1,
                'approve_status' => 1,
            ])
            ->count():
            (new \yii\db\Query())
            ->from('o_member_organization')
            ->where([
                'status' => 1,
                'approve_status' => 1,
                'organization_id'=>$apt_ids,
            ])
            ->count()
            ;

        //sum statement.amount, zippora/monthfee
        $sum1 =  $is_super_admin?
            (new \yii\db\Query())
            ->from('statement')
            ->where([
                'statement_type' => 'zippora',
                'statement_desc' => 'monthly_fee',
            ])
            ->sum('amount')
            :
            (new \yii\db\Query())
            ->select("statement,o_member_organization.organization_id")
            ->from('statement')
            ->leftJoin('o_member_organization','statement.member_id = o_member_organization.member_id')
            ->where([
                'statement_type' => 'zippora',
                'statement_desc' => 'monthly_fee',
            ])
            ->where([
                'organization_id'=>$apt_ids,
            ])
            ->sum('amount')
            ;
        $sum1 = sprintf('%.2f', -$sum1);

        //count o_store
        $count2 =  $is_super_admin?
            (new \yii\db\Query())
            ->from('o_store')
            ->where([
            ])
            ->count():
            (new \yii\db\Query())
            ->from('o_store')
            ->leftJoin('o_organization_cabinet','o_store.cabinet_id = o_organization_cabinet.cabinet_id')
            ->where([
                'organization_id'=>$apt_ids,
            ])
            ->count();

        //sum o_store.pick_fee
        $sum2 = $is_super_admin?
            (new \yii\db\Query())
            ->from('o_store')
            ->where([
            ])
            ->sum('pick_fee')
            :
            (new \yii\db\Query())
            ->from('o_store')
            ->leftJoin('o_organization_cabinet','o_store.cabinet_id = o_organization_cabinet.cabinet_id')
            ->where([
                'organization_id'=>$apt_ids,
            ])
            ->sum('pick_fee');


        //count o_store, sum o_store.pick_fee by day
        //SELECT FROM_UNIXTIME(create_time,'%Y%m%d') day,COUNT(store_id) count, sum(pick_fee) sum FROM o_store GROUP BY day;
        $sql = "SELECT FROM_UNIXTIME(create_time,'%Y%m%d') day,COUNT(store_id) count, sum(pick_fee) sum FROM o_store GROUP BY day";
        $sql1 = "SELECT FROM_UNIXTIME(o_store.create_time,'%Y%m%d') day,COUNT(store_id) count, sum(pick_fee) sum FROM o_store
            left join o_organization_cabinet on o_store.cabinet_id = o_organization_cabinet.cabinet_id
            where o_organization_cabinet.organization_id in (".Yii::$app->user->identity->organization_ids.
            ") GROUP BY day";
        $arr =  $is_super_admin?  Yii::$app->db->createCommand($sql)->queryAll()  :  Yii::$app->db->createCommand($sql1)->queryAll();
        $linedata1 = $linedata2 = [];
        foreach($arr as $d) {
            $linedata1[] = [
                strtotime($d['day'])*1000,
                intval($d['count']),
            ];
            $linedata2[] = [
                strtotime($d['day'])*1000,
                floatval($d['sum']),
            ];
        }

        $sql = "SELECT count(*) as count, sum(pick_fee) as sum FROM o_store where DATE_SUB(CURDATE(), INTERVAL 30 DAY) <= FROM_UNIXTIME(create_time, '%Y-%m-%d')";
        $sql1 = "SELECT count(*) as count, sum(pick_fee) as sum FROM o_store 
             left join o_organization_cabinet on o_store.cabinet_id = o_organization_cabinet.cabinet_id
             where o_organization_cabinet.organization_id in (".Yii::$app->user->identity->organization_ids.
            ") and DATE_SUB(CURDATE(), INTERVAL 30 DAY) <= FROM_UNIXTIME(o_store.create_time, '%Y-%m-%d')";
        $arr =  $is_super_admin?  Yii::$app->db->createCommand($sql)->queryAll()  :  Yii::$app->db->createCommand($sql1)->queryAll();
        $lastMonthOrders = $arr[0]['count'];
        $lastMonthIncome = $arr[0]['sum'];

        //count order type
        $pie1count1 = (new \yii\db\Query())
            ->from('o_store')
            ->leftJoin('o_organization_cabinet','o_store.cabinet_id = o_organization_cabinet.cabinet_id')
            ->where([
                'organization_id'=>$apt_ids,
            ])
            ->where([
                'courier_id' => null,
            ])
            ->count();

        $pie1count2 = (new \yii\db\Query())
            ->from('o_store')
            ->leftJoin('o_organization_cabinet','o_store.cabinet_id = o_organization_cabinet.cabinet_id')
            ->where([
                'organization_id'=>$apt_ids,
            ])
            ->where([
                'from_member_id' => null,
            ])
            ->count();

        //count pick_with
        $pie2count1 = (new \yii\db\Query())
            ->from('o_store')
            ->leftJoin('o_organization_cabinet','o_store.cabinet_id = o_organization_cabinet.cabinet_id')
            ->where([
                'organization_id'=>$apt_ids,
            ])
            ->where([
                'pick_with' => 'app',
            ])
            ->count();

        $pie2count2 = (new \yii\db\Query())
            ->from('o_store')
            ->leftJoin('o_organization_cabinet','o_store.cabinet_id = o_organization_cabinet.cabinet_id')
            ->where([
                'organization_id'=>$apt_ids,
            ])
            ->where([
                'pick_with' => 'code',
            ])
            ->count();

        //count box status
        $pie3count1 = (new \yii\db\Query())
            ->from('cabinet_box')
            ->leftJoin('o_organization_cabinet','cabinet_box.cabinet_id = o_organization_cabinet.cabinet_id')
            ->where([
                'organization_id'=>$apt_ids,
            ])
            ->where([
                'status' => 0,
            ])
            ->count();

        $pie3count2 = (new \yii\db\Query())
            ->from('cabinet_box')
            ->leftJoin('o_organization_cabinet','cabinet_box.cabinet_id = o_organization_cabinet.cabinet_id')
            ->where([
                'organization_id'=>$apt_ids,
            ])
            ->where([
                'status' => 1,
            ])
            ->count();


        return $this->render('zippora', [
            'count1' => $count1,
            'sum1' => $sum1,
            'count2' => $count2,
            'sum2' => $sum2,
            'linedata1' => $linedata1 ? json_encode($linedata1) : '',
            'linedata2' => $linedata2 ? json_encode($linedata2) : '',
            'pie1count1' => $pie1count1 ? : 0,
            'pie1count2' => $pie1count2 ? : 0,
            'pie2count1' => $pie2count1 ? : 0,
            'pie2count2' => $pie2count2 ? : 0,
            'pie3count1' => $pie3count1 ? : 0,
            'pie3count2' => $pie3count2 ? : 0,

            'lastMonthOrders' => $lastMonthOrders ? : 0,
            'lastMonthIncome' => $lastMonthIncome ? : 0,
        ]);
    }

    public function actionZiplocker()
    {
        //count ziplocker member
        $count1 = (new \yii\db\Query())
            ->from('z_deliver')
            ->distinct('from_member_id')
            ->count();

        //sum statement.amount, zippora/monthfee
        $sum1 = (new \yii\db\Query())
            ->from('statement')
            ->where([
                'statement_type' => 'ziplocker',
            ])
            ->sum('amount');
        $sum1 = sprintf('%.2f', -$sum1);

        //count z_deliver
        $count2 = (new \yii\db\Query())
            ->from('z_deliver')
            ->where([
            ])
            ->count();

        //sum z_deliver.fee_total
        $sum2 = (new \yii\db\Query())
            ->from('z_deliver')
            ->where([
            ])
            ->sum('fee_total');


        //count z_deliver, sum z_deliver.fee_total by day
        //SELECT FROM_UNIXTIME(create_time,'%Y%m%d') day,COUNT(deliver_id) count, sum(fee_total) sum FROM z_deliver GROUP BY day;
        $sql = "SELECT FROM_UNIXTIME(create_time,'%Y%m%d') day,COUNT(deliver_id) count, sum(fee_total) sum FROM z_deliver GROUP BY day";
        $arr = Yii::$app->db->createCommand($sql)->queryAll();
        $linedata1 = $linedata2 = [];
        foreach($arr as $d) {
            $linedata1[] = [
                strtotime($d['day'])*1000,
                intval($d['count']),
            ];
            $linedata2[] = [
                strtotime($d['day'])*1000,
                floatval($d['sum']),
            ];
        }

        $sql = "SELECT count(*) as count, sum(fee_total) as sum FROM z_deliver where DATE_SUB(CURDATE(), INTERVAL 30 DAY) <= FROM_UNIXTIME(create_time, '%Y-%m-%d')";
        $arr = Yii::$app->db->createCommand($sql)->queryAll();
        $lastMonthOrders = $arr[0]['count'];
        $lastMonthIncome = $arr[0]['sum'];

        //count order type
        $pie1count1 = (new \yii\db\Query())
            ->from('z_deliver')
            ->where([
                'courier_id' => null,
            ])
            ->count();

        $pie1count2 = (new \yii\db\Query())
            ->from('z_deliver')
            ->where([
                'from_member_id' => null,
            ])
            ->count();

        //count box status
        $pie3count1 = (new \yii\db\Query())
            ->from('cabinet_box')
            ->where([
                'status' => 0,
            ])
            ->count();

        $pie3count2 = (new \yii\db\Query())
            ->from('cabinet_box')
            ->where([
                'status' => 1,
            ])
            ->count();


        return $this->render('ziplocker', [
            'count1' => $count1,
            'sum1' => $sum1,
            'count2' => $count2,
            'sum2' => $sum2,
            'linedata1' => $linedata1 ? json_encode($linedata1) : '',
            'linedata2' => $linedata2 ? json_encode($linedata2) : '',
            'pie1count1' => $pie1count1 ? : 0,
            'pie1count2' => $pie1count2 ? : 0,
            'pie3count1' => $pie3count1 ? : 0,
            'pie3count2' => $pie3count2 ? : 0,

            'lastMonthOrders' => $lastMonthOrders ? : 0,
            'lastMonthIncome' => $lastMonthIncome ? : 0,
        ]);
    }
}
