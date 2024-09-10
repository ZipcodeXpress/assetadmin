<?php

namespace backend\controllers;
use backend\models\AuthItem;
use backend\models\PasswordForm;
use yii\data\Pagination;
use backend\models\User;

use Yii;
use backend\models\Organization;
use yii\helpers\ArrayHelper;

class UserController extends CommonController
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * 用户列表
     */
    public function actionList()
    {
        Yii::$app->user->identity->username;
        $data = User::find();
        $pages = new Pagination(['totalCount' =>$data->count(), 'pageSize' => '15']);
        $user = $data->joinWith('usergroup')->offset($pages->offset)->limit($pages->limit)->all();
        return $this->render('list',[
            'user'=>$user,
            'pages' => $pages
        ]);
    }

    /**
     * 新增用户
     */
    public function actionCreate()
    {
        $model = new User();
        $model1 = new AuthItem();

        $auth = Yii::$app->authManager;
        $item = $auth->getRoles();
        $itemArr =array();
        foreach($item as $v){
            $itemArr[] .= $v->name;
        }
        foreach($itemArr as $key=>$value)
        {
            $item_one[$value]=$value;
        }

        if ($model->load(Yii::$app->request->post())) {
            /* 表单验证 */
            $post = Yii::$app->request->post();

            $data = $post['User'];
            $data['created_at']     = time();
            /* 表单数据加载和验证，具体验证规则在模型rule中配置 */
            /* 密码单独验证，否则setPassword后密码肯定符合rule */
            if (empty($data['auth_key']) || strlen($data['auth_key']) < 6) {
                $this->error('The length of the password is less than 6!');
            }
            $model->setAttributes($data);
            $model->generateAuthKey();
            $model->setPassword($data['auth_key']);
            if(!empty($model->organization_ids))
            {
                $model->organization_ids = implode(",",$model->organization_ids);//var_dump($model->organization_ids);exit;
            }
            /* 保存用户数据到数据库 */
            if ($model->save()) {
                //获取插入后id
                $user_id = $model->attributes['id'];
                $role = $auth->createRole($post['AuthItem']['name']);     //创建角色对象
                $auth->assign($role, $user_id);                           //添加对应关系
                return $this->redirect(['list']);
            }else{
                $this->error('Operation error');
            }
        } else {
            return $this->render('create', [
                'model' => $model,
                'model1' => $model1,
                'organizations'=>Organization::find()->all(),
                'item' => $item_one
            ]);
        }
    }

    /**
     * 更新用户
     */
    public function actionUpdate(){
        $id = Yii::$app->request->get('id');
        $act = Yii::$app->request->get('act');
        $model = User::find()->joinWith('usergroup')->where(['id'=>$id])->one();
        $auth = Yii::$app->authManager;
        $item = $auth->getRoles();
        $itemArr =array();
        foreach($item as $v){
            $itemArr[] .= $v->name;
        }
        foreach($itemArr as $key=>$value)
        {
            $item_one[$value]=$value;
        }
        $model1 = $this->findModel($id);
        $organizations = Organization::find()->all();
        $organizationIDs=[];
        if(!empty($model->organization_ids))
        {
            $organizationIDs = array_filter(explode(',', $model->organization_ids));  //var_dump($organizationIDs); var_dump(ArrayHelper::map($organizations, "organization_id", "organization_name"));
        }
        if ($model1->load(Yii::$app->request->post())) {
            $post = Yii::$app->request->post();
            if(!empty($model1->organization_ids))
            {
                if(is_array($model1->organization_ids))
                {
                    $model1->organization_ids = implode(",",$model1->organization_ids);//var_dump($model1->organization_ids);exit;
                }
            }
            //更新密码
            if(!empty($post['User']['auth_key_new'])){
                $model1->setPassword($post['User']['auth_key_new']);
                $model1->generateAuthKey();
            }else{
                $model1->auth_key = $post['User']['auth_key'];
            }
            $model1->save($post);
            if(!empty($post['AuthAssignment']['item_name'])){
                //分配角色
                $role = $auth->createRole($post['AuthAssignment']['item_name']);    //创建角色对象
                $user_id = $id;
                $auth->revokeAll($user_id);
                $auth->assign($role, $user_id);       //分配角色与用户对应关系
            }
            if(!isset($act))
            {
                return $this->redirect(['list']);
            }
            else 
            {
                \Yii::$app->getSession()->setFlash('success', 'update success.');
            }
            //return $this->redirect(['user/update', 'id' => $model1->id]);
        }

        return $this->render('update',[
            'model' => $model,
            'item' => $item_one,
            'organizations'=>$organizations,
            'organizationIDs'=>$organizationIDs
        ]);
    }

    /**
     * 删除用户
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        return $this->redirect(['list']);
        //$this->success('删除成功！','list');
    }

    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            $this->error('Fail delete！');
        }
    }

}
