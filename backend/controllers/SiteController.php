<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use backend\models\Menu;
//
use backend\models\UploadForm;
use yii\web\UploadedFile;

/**
 * 首页控制器
 */
class SiteController extends Controller
{
	//
 	public function actionUpload()
    {
        $model = new UploadForm();

        if (Yii::$app->request->isPost) {
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
            if ($model->upload()) {
                // file is uploaded successfully
                return;
            }
        }

        return $this->render('upload', ['model' => $model]);
    } 
	//
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['get'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionIndex()
    {
        $user_id=Yii::$app->user->identity->getId();
        $user_info = Yii::$app->authManager->getRolesByUser($user_id);
        $user_head_img = "img/profile_small.jpg";
        if(strtolower(Yii::$app->user->identity->usergroup->item_name) == 'superadmin')
        {
            $user_head_img = "img/profile_small.jpg";
        }
        else 
        {
            switch(Yii::$app->user->identity->username)
            {
                case "ChardonnayAdmin":
                    $user_head_img = "img/ChardonnayAdmin.png";
                    break;
                default:
                    $user_head_img = "img/profile_small.jpg";
                    break;
            }
            
        }
        $menu = new Menu();
        $menu = $menu->getLeftMenuList();
        return $this->render('index',[
            'menu' => $menu,
            'user_info' => key($user_info),
            'user_head_img'=>$user_head_img,
        ]);
    }

    /**
     * 登录
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            $model->loginLog();
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * 注销登录
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }

}
