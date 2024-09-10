<?php

namespace backend\controllers;

use Yii;
use backend\models\Courierorganization;
use backend\models\CourierSearch;
use backend\models\Courier;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\Store;
use backend\models\CourierorganizationSearch;
use backend\models\SMSGateway;

/**
 * CourierorganizationController implements the CRUD actions for Courierorganization model.
 */
class ApmrcourierorganizationController extends CommonController
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
     * Lists all Courierorganization models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CourierorganizationSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $this->_organizationIds);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Courierorganization model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {

        $model = new Courierorganization();

        if ($model->load(Yii::$app->request->post())) {//&& $model->save() 
                if(Courierorganization::find()->where(['courier_id'=>$model->courier_id,'organization_id'=>$model->organization_id])->count()>0)
                {
                    $model->addError('organization_id','This courier already authorized to this organization.');
                    return $this->render('create', [
                        'model' => $model,
                        'courierModel'=>Courierorganization::getCourierList(Yii::$app->request->get('courierId')),
                        'organizationModel'=>Courierorganization::getOrganizationName($this->_organizationIds),
                    ]);
                }
                else 
                {
                    $courier = Courierorganization::getCourierEx(Yii::$app->request->post('Courierorganization')['courier_id']);var_dump($model);
                    $organization = Courierorganization::getOrganizationName(Yii::$app->request->post('Courierorganization')['organization_id']);
                    if(isset($couriercourier_name))
                    {
                        $phone = $courier->phone;
                        $email = $courier->email;
                        if(empty($phone)||empty($email))
                        {
                            $model->addError("courier_id","Email and Phone can not be empty!");
                            return $this->render('create', [
                                'model' => $model,
                                'courierModel'=>Courierorganization::getCourierList(Yii::$app->request->get('courierId')),
                                'organizationModel'=>Courierorganization::getOrganizationName($this->_organizationIds),
                            ]);
                        }
                        $model->save();
                        //send email
                        $res1 = Yii::$app->mailer->compose()
                        ->setTo($courier['email'])
                        ->setSubject("ZipcodeXpress Courier Authorization Notice")
                        ->setHtmlBody("You have been authorized to use locker at Organization: ".$organization[Yii::$app->request->post('Courierorganization')['organization_id']]." <br>Access Code: ".$courier['card_code']."<br>Please keep your access code safe, and follow the instructions of the smart locker to complete the whole parcel deposit process correctly. Thanks for your cooperation.") //发送的消息内容
                        ->send();
                        
                        //send sms
                        
                        $phone = str_replace('-', '', $phone);
                        if($phone && strlen($phone) == 10) {
                            $smsGateway = new SMSGateway('yonghuiz@hotmail.com', 'richardz1');
                            //$phone = '5127347755'; richard's phone
                            $options = [
                                'send_at' => strtotime('+1 minutes'), // Send the message in 10 minutes
                                'expires_at' => strtotime('+1 hour') // Cancel the message in 1 hour if the message is not yet sent
                            ];
                            //Please note options is no required and can be left out
                            $message = "[ZipcodeXpress] You have been authorized to use locker at Organization: ".$organization[Yii::$app->request->post('Courierorganization')['organization_id']]."; Access Code: ".$courier['card_code'];
                            //$message = "[ZipcodeXpress] You have been authorized to use locker at Organization: ".$organization[Yii::$app->request->post('Courierorganization')['organization_id']].". Access Code: ".$courier['card_code'].". Please keep your access code safe, and follow the instructions of the smart locker to complete the whole parcel deposit process correctly.";
                            $res2 = $smsGateway->sendMessageToNumber($phone, $message);
                        }
                        
                    }
                    else 
                    {
                        //courier
                        $model->save();
                    }
                    return $this->redirect(['index']);
                }
            //return $this->redirect(['view', 'id' => $model->courier_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'courierModel'=>Courierorganization::getCourierList(Yii::$app->request->get('courierId')),
                'organizationModel'=>Courierorganization::getOrganizationName($this->_organizationIds),
            ]);
        }
    }

    /**
     * Deletes an existing Courierorganization model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($courier_id=0,$organization_id=0)
    {
        if (Yii::$app->request->isAjax)
        {
            $data = Yii::$app->request->post(); //var_dump($data);
            $courier_id= explode(":", $data['courier_id']);
            $courier_id= $courier_id[0];
            
            $organization_id= explode(":", $data['organization_id']);
            $organization_id= $organization_id[0];
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        }
        $model = $this->findModel($courier_id,$organization_id);
        $model->delete();
        if(Yii::$app->request->isAjax)
        {
            return [
                'msg' => 'Delete courier success.',
                'code' => 200,
            ];
        }
        else
        {
            \Yii::$app->getSession()->setFlash('success', 'Delete courier success.');
        }
        return $this->redirect(['index']);
        //$this->findModel($id)->delete();
        //return $this->redirect(['index']);
    }

    /**
     * Finds the Courierorganization model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Courierorganization the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($courier_id,$organization_id)
    {
        if (($model = Courierorganization::findOne($courier_id,$organization_id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
