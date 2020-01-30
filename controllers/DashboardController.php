<?php

namespace app\controllers;

use Yii;
use yii\base\Application;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ForgetPasswordForm;
use app\models\ContactForm;
use app\models\Capaidentity;
use app\models\Cellule;
use app\models\userrightapplication;

class DashboardController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
            'class' => AccessControl::className(),
            'only' => ['logout','contact','resetpassword'],
            'rules' => [
                [
                    'actions' => ['logout','contact'],
                    'allow' => true,
                    'roles' => ['@'],
                ],
                [
                    'actions' => ['resetpassword'],
                    'allow' => true,
                    'roles' => ['?'],
                ],
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



 
    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        echo 'hello';
        //Si l'utilisateur est logger alors affiche la page principal
        if (!Yii::$app->user->isGuest) {

            return $this->render('index');
        }

        //Création du formulaire de login
        $model = new LoginForm();
    
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
        
            return $this->render('index');
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Displays resetpassword page.
     *
     * @return Response|string
     */
    public function actionResetpassword()
    {
       //if(Yii::$app->user->isGuest) 
       {
            $model = new ForgetPasswordForm();
            if ($model->load(Yii::$app->request->post())) {
                $model->generatednewpassword();  
                return  $this->goHome();

            }
            return $this->render('ForgetPassword', [
                'model' => $model,
            ]);
       }
    }


    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
}
