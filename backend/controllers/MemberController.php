<?php

namespace backend\controllers;

use Yii;
use backend\models\Member;
use backend\models\MemberSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\Memberaddress;
use backend\models\Memberprofile;
use backend\models\Wallet;
use backend\models\Memberorganization;
use backend\common\CommonStatus;
use yii\web\UploadedFile;
use backend\models\Organization;
use backend\models\Unit;
use yii\helpers\ArrayHelper;
use backend\common\CommonHelper;

/**
 * MemberController implements the CRUD actions for Member model.
 */
class MemberController extends CommonController
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
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Member models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MemberSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$this->_organizationIds);
        $model = new Member();
        $organizationModel = $this->getApts();
        $transaction = Yii::$app->db->beginTransaction();
        try
        {
            if ($model->load(Yii::$app->request->post()))
            {
                $post = Yii::$app->request->post();
                $organization_id = $post['Member']['organization_id'];
                $price = Organization::findOne(['organization_id'=>$organization_id])->price;
                $model->file = UploadedFile::getInstance($model, 'file');
                if ($model->file && $model->validate()) 
                {
                    $file_path = $this->getDir().'/'.$this->getRandName().'.'.$model->file->extension;
                    $model->file->saveAs($file_path);
                    $members = [];
                    $file = fopen($file_path,'r');
                    while ($data = fgetcsv($file)) 
                    {
                        $members[] = $data;
                    }
                    unset($members[0]);
                    //var_dump($members);//exit;
                    foreach ($members as $member)
                    {
                        if(empty($member))
                        {
                            continue;
                        }
                        if(strtolower($member[0])=='vacant'||strtolower($member[1])=='vacant')
                        {
                            continue;
                        }
                        if(!empty($member) && $member[2])
                        {
                            $first_name = $member[0];
                            $last_name = $member[1];
                            $email = $member[2];
                            $phone = empty($member[3])? null:CommonHelper::replace_tel($member[3]);
                            $address = $member[4];
                            $unit = $member[5];
                            $city = $member[6];
                            $state = $member[7];
                            $zipcode = $member[8];
                            //save unit
                            $unit_id = $this->AddUnit($unit, $organization_id);
                            if(!empty($unit_id))
                            {
                                $_model = Member::findOne(['email'=>$email]);
                                if(empty($_model)){
                                    $_model=new Member();
                                   
                                }
                                
                                //save member
                                
                                $_model->email = $email;
                                $_model->phone = $phone;
                                $_model->register_time = time();
                                $_model->service_mode = 'zippora';
                                $_model->save(); 
                                $member_id = $_model->attributes['member_id']; 
                                

                                //save ptofile
                                $this->saveProfile($member_id,$phone, $first_name,$last_name,$address,$unit,$city,$state,$zipcode);
                                //save wallet
                                $this->saveWallet($member_id);
                                //create Member Organization
                                $this->createMemberOrganization($member_id,$organization_id,$unit_id,$price);
                                //auto approve
                                $this->approveAptMember($member_id,$organization_id,$unit_id,$price);
                                
                            }
                            else 
                            {
                                $model->addError('file','Failed to add the unit!');
                                return $this->render('index', [
                                    'searchModel' => $searchModel,
                                    'dataProvider' => $dataProvider,
                                    'model'=>$model,
                                    'organizationModel'=>$organizationModel
                                ]);
                            }
                        }
                    }
                    fclose($file);
                    //commit
                    $transaction->commit(); //var_dump($transaction);exit;
                    return $this->render('index', [
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
                        'model'=>$model,
                        'organizationModel'=>$organizationModel
                    ]);
                }
                else
                {
                    $model->addError('file','Please select the csv file!');
                    return $this->render('index', [
                            'searchModel' => $searchModel,
                            'dataProvider' => $dataProvider,
                            'model'=>$model,
                            'organizationModel'=>$organizationModel
                        ]);
                }
            }
            else 
            {
                return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'model'=>$model,
                    'organizationModel'=>$organizationModel
                ]);
            }
        }
        catch (\Exception $e)
        {
            $transaction->rollBack();
            $model->addError('file',$e->getMessage());
                return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'model'=>$model,
                    'organizationModel'=>$organizationModel
                ]);
        }
    }
    protected function getApts()
    {
        $apt_arr = []; 
        if(empty($this->_organizationIds)) 
        {
            $apt_arr = ArrayHelper::map(Organization::find()->all(), "organization_id", "organization_name");
        }
        else 
        {
            $apt_ids = array_filter(explode(',', $this->_organizationIds));
            foreach ($apt_ids as $id)
            {
                $apt_arr[$id] = Organization::findOne(['organization_id'=>$id])->organization_name;
            }
        }
        return $apt_arr;
    }
    //随机生成移动后的文件名
    protected function getRandName() {
        $str = 'abcdefghijkmnpqrstwxyz23456789';
        return substr(str_shuffle($str),0,6);
    }
    protected  function getDir()
    {
        $dir = Yii::$app->basePath.'/web/uploads/'.date("Ymd");
        if(!is_dir($dir)) 
        {
           mkdir($dir,0777,true);
        }
        return $dir;
    }
    protected function  AddUnit($unit_name,$organization_id)
    {
        $unitModel = Unit::findOne(['unit_name'=>$unit_name,'organization_id'=>$organization_id]);
        if(empty($unitModel))
        { 
            $unitModel= new Unit();
            $unitModel->unit_name = $unit_name;
            $unitModel->organization_id = $organization_id;
            $unitModel->save();
            return $unitModel->attributes['unit_id'];
        }
        else 
        {  
            return $unitModel->unit_id;
        }
    }

    protected function approveAptMember($member_id,$organization_id,$unit_id)
    {
        $memberOrganizationModel = Memberorganization::findOne(['member_id'=>$member_id,'organization_id'=>$organization_id,'unit_id'=>$unit_id]);
        if(empty($memberOrganizationModel)){
            $memberOrganizationModel = new Memberorganization();
            $memberOrganizationModel->member_id = $member_id;
            $memberOrganizationModel->organization_id = $organization_id;
            $memberOrganizationModel->unit_id = $unit_id;
        }
        
        $memberOrganizationModel->status = 1;
        $memberOrganizationModel->approve_status = 1;
        $memberOrganizationModel->cancel_time=0;
        $memberOrganizationModel->approve_time = time();
        $memberOrganizationModel->save(); 
    }
    protected function createMemberOrganization($member_id,$organization_id,$unit_id,$price)
    {
        $memberOrganizationModel = Memberorganization::findOne(['member_id'=>$member_id,'organization_id'=>$organization_id,'unit_id'=>$unit_id]);
        if(empty($memberOrganizationModel)){
            $memberOrganizationModel = new Memberorganization();
            $memberOrganizationModel->member_id = $member_id;
            $memberOrganizationModel->organization_id = $organization_id;
            $memberOrganizationModel->unit_id = $unit_id;
        }

        $memberOrganizationModel->price = $price;
        $memberOrganizationModel->apply_time=time();
        $memberOrganizationModel->create_time = time();
        $memberOrganizationModel->cancel_time=0;
        $memberOrganizationModel->save(); 
    }
    protected function saveAddress($member_id,$first_name,$last_name,$address,$unit,$city,$state,$zipcode)
    {
        $addressModel = Memberaddress::findOne(['member_id'=>$member_id]);
        if(empty($addressModel)){
            $addressModel = new Memberaddress();
            $addressModel->member_id = $member_id;
        }
       
        $addressModel->first_name = $first_name;
        $addressModel->last_name = $last_name;
        $addressModel->state = $state;
        $addressModel->city = $city;
        $addressModel->address = $address;
        $addressModel->zipcode = $zipcode;
        $addressModel->create_time = time();
        $addressModel->save();
    }
    protected function saveProfile($member_id,$phone, $first_name,$last_name,$address,$unit,$city,$state,$zipcode)
    {
        $profileModel = Memberprofile::findOne(['member_id'=>$member_id]);
        if(empty($profileModel)){
            $profileModel = new Memberprofile();
            $profileModel->member_id = $member_id;
        }
        $profileModel->first_name = $first_name;
        $profileModel->last_name = $last_name;
        $profileModel->addressline1 = $address;
        $profileModel->city = $city;
        $profileModel->state = $state;
        $profileModel->zipcode = $zipcode;
        $profileModel->phone = $phone;
        $profileModel->create_time = time();
        $profileModel->save(); 
    }
    protected function saveWallet($member_id)
    {
        $walletModel = new Wallet();
        $walletModel->member_id = $member_id;
        $walletModel->money = 0;
        $walletModel->frozen_money = 0;
        $walletModel->ubi = 0;
        $walletModel->save();
    }
    /**
     * Displays a single Member model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Member model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Member();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->member_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Member model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id); 
        $memberAddressModel = Memberaddress::findAll(['member_id'=>$id]);
        $memberProfileModel = Memberprofile::findOne(['member_id'=>$id]);
        $walletModel = Wallet::findOne(['member_id'=>$id]);
        $memberOrganizationModel = Memberorganization::findAll(['member_id'=>$id]);
        
        return $this->render('update', [
            'model' => $model,
            'statusModel'=> CommonStatus::member_status(),
            'cstatusModel'=> CommonStatus::member_c_status(),
            'memberAddressModel' => $memberAddressModel,
            'memberProfileModel' => $memberProfileModel,
            'walletModel' => $walletModel,
            'memberOrganizationModel' => $memberOrganizationModel,
        
        ]);
    }
    public  function actionUpdateMember($id=0)
    {
        if (Yii::$app->request->isAjax)
        {
            $data = Yii::$app->request->post(); //var_dump($data);
            $id= explode(":", $data['id']);
            $id= $id[0];
            
            $email= explode(":", $data['email']);
            $email= $email[0];

            $cardcode= explode(":", $data['cardcode']);
            $cardcode= $cardcode[0];

            $phone= explode(":", $data['phone']);
            $phone= $phone[0];
            $phone = str_replace("-","",$phone);
            
            $status= explode(":", $data['status']);
            $status= $status[0];
            
            $c_status= explode(":", $data['c_status']);
            $c_status= $c_status[0];
            
            $is_email_verified= explode(":", $data['is_email_verified']);
            $is_email_verified= $is_email_verified[0];
            
            $is_profile_completed= explode(":", $data['is_profile_completed']);
            $is_profile_completed= $is_profile_completed[0];
            
            $has_credit_card= explode(":", $data['has_credit_card']);
            $has_credit_card= $has_credit_card[0];
            
            $cabinet_id= explode(":", $data['cabinet_id']);
            $cabinet_id= $cabinet_id[0];
            
            $service_mode= explode(":", $data['service_mode']);
            $service_mode= $service_mode[0];
            
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            
            $model = $this->findModel($id);
            $model->email = $email;
            $model->cardcode = $cardcode;

            $model->phone = $phone;
            $model->status = $status;
            $model->c_status = $c_status;
            $model->is_email_verified = $is_email_verified;
            $model->is_profile_completed = $is_profile_completed;
            $model->has_credit_card = $has_credit_card;
            $model->cabinet_id = $cabinet_id;
            $model->service_mode = $service_mode;
            if($model->save())
            {
                return [
                    'msg' => 'Update member success.',
                    'code' => 200,
                ];
            }
            else 
            {
                return [
                    'msg' => 'Update member failed.',
                    'code' => 100,
                ];
            }
        }
    }
    public  function actionUpdateWallet($id=0)
    {
        if (Yii::$app->request->isAjax)
        {
            $data = Yii::$app->request->post(); //var_dump($data);
            $id= explode(":", $data['id']);
            $id= $id[0];
    
            $money= explode(":", $data['money']);
            $money= $money[0];
    
            $frozen_money= explode(":", $data['frozen_money']);
            $frozen_money= $frozen_money[0];
    
            $ubi= explode(":", $data['ubi']);
            $ubi= $ubi[0];
    
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    
            $model = Wallet::findOne(['member_id'=>$id]);
            if($model!=null)
            {
                $model->money = $money;
                $model->frozen_money = $frozen_money;
                $model->ubi = $ubi;
                if($model->save())
                {
                    return [
                        'msg' => 'Update member wallet success.',
                        'code' => 200,
                    ];
                }
                else
                {
                    return [
                        'msg' => 'Update member wallet failed.',
                        'code' => 100,
                    ];
                }
            }
            else 
            {
                return [
                    'msg' => 'Cannot find this member\'s wallet.',
                    'code' => 100,
                ];
            }
        }
    }
    public  function actionUpdateProfile($id=0)
    {
        if (Yii::$app->request->isAjax)
        {
            $data = Yii::$app->request->post(); //var_dump($data);
            $id= explode(":", $data['id']);
            $id= $id[0];
    
            $nick_name= explode(":", $data['nick_name']);
            $nick_name= $nick_name[0];
    
            $first_name= explode(":", $data['first_name']);
            $first_name= $first_name[0];
    
            $last_name= explode(":", $data['last_name']);
            $last_name= $last_name[0];
    
            $addressline1= explode(":", $data['addressline1']);
            $addressline1= $addressline1[0];
    
            $addressline2= explode(":", $data['addressline2']);
            $addressline2= $addressline2[0];
    
            $state= explode(":", $data['state']);
            $state= $state[0];
    
            $city= explode(":", $data['city']);
            $city= $city[0];
    
            $zipcode= explode(":", $data['zipcode']);
            $zipcode= $zipcode[0];
    
            $phone= explode(":", $data['phone']);
            $phone= $phone[0];
            $phone = str_replace("-","",$phone);
            
            $birth= explode(":", $data['birth']);
            $birth= $birth[0];
            
            $sex= explode(":", $data['sex']);
            $sex= $sex[0];
            
            $avatar= explode(":", $data['avatar']);
            $avatar= $avatar[0];
    
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    
            $model = Memberprofile::findOne(['member_id'=>$id]); 
            if($model==null)
            {
                $model = new Memberprofile();
            }
            $model->nick_name = $nick_name;
            $model->first_name = $first_name;
            $model->last_name = $last_name;
            $model->addressline1 = $addressline1;
            $model->addressline2 = $addressline2;
            $model->state = $state;
            $model->city = $city;
            $model->zipcode = $zipcode;
            $model->phone = $phone;
            $model->birth = $birth;
            $model->sex = $sex;
            $model->avatar = $avatar;
            if($model->save())
            {
                return [
                    'msg' => 'Update member profile success.',
                    'code' => 200,
                ];
            }
            else
            {
                return [
                    'msg' => 'Update member profile failed.',
                    'code' => 100,
                ];
            }
        }
    }
    /**
     * Deletes an existing Member model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        //$this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Member model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Member the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Member::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
