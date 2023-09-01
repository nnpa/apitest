<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\Users;


class SiteController extends Controller
{
    public $enableCsrfValidation = false;
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
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
        ];
    }


    public function actionIndex()
    {

        return $this->render('index');
    }
    
    public function actionRegister(){

        $errors = [];
        
        if( isset($_POST["email"]) && !empty($_POST["email"]) &&
            isset($_POST["name"])    
                ){
            $email = $_POST["email"];
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = "не валидная почта";
            }
            
            $user = Users::find()->where(["email" => $email])->one();
            
            if(!is_null($user)){
                $errors[] = "пользователь уже зарегистрирован";
            }
            
            if(empty($errors)){
                $user = new Users();
                $user->email = $email;
                $user->api_key = md5($email.time());
                $user->is_admin = 0;
                $user->name = $_POST["name"];

                $user->save(false);
                
                echo "Ваш api ключ: ". $user->api_key;exit;
            }
        }
        
        return $this->render('register',["errors" =>$errors]);
    }
}
