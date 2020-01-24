<?php

namespace app\controllers;

use Yii;
use yii\helpers\FileHelper;
use yii\base\Application;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

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
                'class' => VerbFilter::className(),
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


    public function getControllers()
    {


        $path = Yii::$app->getControllerPath();

        $data = array();


        $files = FileHelper::findFiles($path, array("fileTypes" => array("php")));


        foreach ($files as $file)
        {


            include_once $file;

             $data = array();

            $filename = basename($file, '.php');


            if (($pos = strpos($filename, 'Controller')) > 0)
             {


                $class_name = $controllers[] = substr($filename, 0, $pos);


                $class_name = 'app\controllers\\'.$class_name.'Controller';
                echo $class_name;
                $class_name::hello();
                if($class_name != 'Dashboard')
                {
                    array_push( $data, $class_name);
                }

            }
        }
            
    return $data;

    }
   
    public static  function hello()
    {
        echo 'hello';
    }


    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        //Si l'utilisateur est logger alors affiche la page principal
        if (!Yii::$app->user->isGuest) {

            $data =  $this->getControllers();
            return $this->render('index');
        }

        //Création du formulaire de login
        $model = new LoginForm();
    
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            
            $data =  $this->getControllers();
            return $this->render('index');
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
        //return $this->render('index');
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
