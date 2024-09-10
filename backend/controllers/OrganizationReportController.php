<?php

namespace backend\controllers;


use Yii;
use backend\models\Organization;
use scotthuangzl\export2excel\Export2ExcelBehavior;

class OrganizationReportController extends CommonController
{
    public function behaviors()
    {
        return [
            'export2excel' => [
					'class' => Export2ExcelBehavior::className(),
	                //            'prefixStr' => yii::$app->user->identity->username,
                    //            'suffixStr' => date('Ymd-His'),
				],
        ];
    }
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
            //new add download action
            'download' => [
                'class' => 'scotthuangzl\export2excel\DownloadAction',
            ],
        ];
    }
    
    public function actionIndex()
    {
        $begin_time = date('Y-m-01', strtotime(date("Y-m-d")));
        $end_time =  date('Y-m-d', strtotime("$begin_time +1 month -1 day"));
        if(Yii::$app->request->post())
        {
            $data = Yii::$app->request->post();
            $begin_time = trim($data['begin_time']);
            $end_time = trim($data['end_time']);
        }
        $organizations_reports = [];
        if(Yii::$app->user->identity->usergroup->item_name == 'SuperAdmin')
        {
            $organizations = Organization::find()->all();
            foreach ($organizations as $organization)
            {
                $sql_amount="select m.email,m.phone,a.organization_name,SUM(c.amount) as amount  from o_charge c LEFT join member m on c.member_id = m.member_id left join o_organization a on c.organization_id = a.organization_id where c.organization_id=".$organization->organization_id." and paid_time>=UNIX_TIMESTAMP('".$begin_time."') and paid_time<=UNIX_TIMESTAMP('".$end_time."') GROUP BY c.member_id";
                $charges_amount = Yii::$app->db->createCommand($sql_amount)->queryAll();
                $sql_details = "select c.charge_id,m.email,m.phone,a.organization_name,c.charge_type,c.charge_channel,c.amount,from_unixtime(c.paid_time) as paid_time  from o_charge c LEFT join member m on c.member_id = m.member_id left join o_organization a on c.organization_id = a.organization_id where c.organization_id=".$organization->organization_id." and (paid_time>=UNIX_TIMESTAMP('".$begin_time."') and paid_time<=UNIX_TIMESTAMP('".$end_time."'))" ;
                $charges_details = Yii::$app->db->createCommand($sql_details)->queryAll();
                if(empty($charges_amount)) continue;
                $organizations_reports[$organization->organization_name]['charges_amount'] = $charges_amount;
                $organizations_reports[$organization->organization_name]['charges_details'] = $charges_details;
            }
        }
        else 
        {
            $organizations = [];
            if($this->_organizationIds)
            {
                $apt_ids = array_filter(explode(',', $this->_organizationIds));
                foreach ($apt_ids as $key=>$id)
                {
                    $organizations[$id] = Organization::findOne(['organization_id'=>$id])->organization_name;
                }
            } //var_dump($organizations);exit;
            foreach ($organizations as $a_id=>$organization)   
            { 
                $sql_amount="select m.email,m.phone,a.organization_name,SUM(c.amount) as amount  from o_charge c LEFT join member m on c.member_id = m.member_id left join o_organization a on c.organization_id = a.organization_id where c.organization_id=".$a_id." and (paid_time>=UNIX_TIMESTAMP('".$begin_time."') and paid_time<=UNIX_TIMESTAMP('".$end_time."'))  GROUP BY c.member_id";
                $charges_amount = Yii::$app->db->createCommand($sql_amount)->queryAll();
                $sql_details = "select c.charge_id,m.email,m.phone,a.organization_name,c.charge_type,c.charge_channel,c.amount,from_unixtime(c.paid_time) as paid_time  from o_charge c LEFT join member m on c.member_id = m.member_id left join o_organization a on c.organization_id = a.organization_id where c.organization_id=".$a_id." and (paid_time>=UNIX_TIMESTAMP('".$begin_time."') and paid_time<=UNIX_TIMESTAMP('".$end_time."'))";
                $charges_details = Yii::$app->db->createCommand($sql_details)->queryAll();
                $organizations_reports[$organization]['charges_amount'] = $charges_amount;
                $organizations_reports[$organization]['charges_details'] = $charges_details;
            }
        } //var_dump($organizations_reports);exit;
        return $this->render('@app/views/report/AptReport', [
            'organizations_reports' => $organizations_reports,
            'begin_time'=>$begin_time,
            'end_time'=>$end_time
        ]);
    }
    
    public function actionExportAmount()
    {
        if(Yii::$app->request->post())
        {
            $data = Yii::$app->request->post();
            $export_amount = json_decode(trim($data['charges_amount_export']));
            $export_amount = json_decode(json_encode($export_amount),true);
            
            $excel_data = Export2ExcelBehavior::excelDataFormat($export_amount); //var_dump($export_amount);exit;
            $excel_title = $excel_data['excel_title']; 
            $excel_ceils = $excel_data['excel_ceils'];
            $excel_content = array(
                array(
                    'sheet_name' => $export_amount[0]['organization_name'],
                    'sheet_title' => $excel_title,
                    'ceils' => $excel_ceils,
                    'freezePane' => 'B2',
                    'headerColor' => Export2ExcelBehavior::getCssClass("header"),
                    'headerColumnCssClass' => array(
                        'id' => Export2ExcelBehavior::getCssClass('blue'),
                        'Status_Description' => Export2ExcelBehavior::getCssClass('grey'),
                    ), //define each column's cssClass for header line only.  You can set as blank.
                    'oddCssClass' => Export2ExcelBehavior::getCssClass("odd"),
                    'evenCssClass' => Export2ExcelBehavior::getCssClass("even"),
                ),
          
            );
            $excel_file = "organization_amount";
            $this->export2excel($excel_content, $excel_file);
        }
    }
    public function actionExportDetails()
    {
        if(Yii::$app->request->post())
        {
            $data = Yii::$app->request->post();
            $export_details = json_decode(trim($data['charges_details_export']));
            $export_details = json_decode(json_encode($export_details),true);
            
            $excel_data = Export2ExcelBehavior::excelDataFormat($export_details); //var_dump($export_amount);exit;
            $excel_title = $excel_data['excel_title'];
            $excel_ceils = $excel_data['excel_ceils'];
            $excel_content = array(
                array(
                    'sheet_name' => $export_details[0]['organization_name'],
                    'sheet_title' => $excel_title,
                    'ceils' => $excel_ceils,
                    'freezePane' => 'B2',
                    'headerColor' => Export2ExcelBehavior::getCssClass("header"),
                    'headerColumnCssClass' => array(
                        'id' => Export2ExcelBehavior::getCssClass('blue'),
                        'Status_Description' => Export2ExcelBehavior::getCssClass('grey'),
                    ), //define each column's cssClass for header line only.  You can set as blank.
                    'oddCssClass' => Export2ExcelBehavior::getCssClass("odd"),
                    'evenCssClass' => Export2ExcelBehavior::getCssClass("even"),
                ),
            
            );
            $excel_file = "organization_details";
            $this->export2excel($excel_content, $excel_file);
        }
    }
    
}
