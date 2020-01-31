<?php

namespace app\controllers;

use Yii;
use yii\base\Application;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;

//Model utile pour login
use app\models\login\LoginForm;
use app\models\login\ForgetPasswordForm;
use app\models\login\FirstConnexionForm;


use app\models\ContactForm;


//Model de données utilisateurs.
use app\models\User\Capaidentity;
use app\models\User\Cellule;
use app\models\User\userrightapplication;

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
            'only' => ['logout','contact','resetpassword','login'],
            'rules' => [
                [
                    'actions' => ['logout','contact'],
                    'allow' => true,
                    'roles' => ['@'],
                ],
                [
                    'actions' => ['resetpassword','login'],
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

        //Si l'utilisateur est logger alors affiche la page principal
        if (!Yii::$app->user->isGuest) {

            return $this->render('index');
        }

        //Création du formulaire de login
        $model = new LoginForm();
    
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
        
                        //Vérifie que l'utilisateur ne doit pas renouveller son mot de passe
           $capuser =  Yii::$app->user->getIdentity();
           if($capuser->flagPassword)
           {
               //Lancement du formulaire de renouvellement de mot passe utilisateur
               $this->redirect('dashboard/firstlogin');
           }
           else
           {
            return $this->render('index');
           }
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
        $resultat  = $this->goHome();
        //Dans le cas d'une action d'autologin
        if (!Yii::$app->user->isGuest) {
            //Vérifie que l'utilisateur ne doit pas renouveller son mot de passe
           $capuser =  Yii::$app->user->getIdentity();
            if($capuser->flagPassword)
            {
                //Lancement du formulaire de renouvellement de mot passe utilisateur
                $this->redirect('dashboard/firstlogin');
            }
            else
            {
                $resultat = $this->goHome();
            }
        }
        else
        {
            $model = new LoginForm();
            if ($model->load(Yii::$app->request->post()) && $model->login())
            {
                
                
                //Vérifie que l'utilisateur ne doit pas renouveller son mot de passe
            $capuser =  Yii::$app->user->getIdentity();
                if($capuser->flagPassword)
                {
                    //Lancement du formulaire de renouvellement de mot passe utilisateur
                    $this->redirect('dashboard/firstlogin');
                }
                else
                {
                    $resultat = $this->goBack();
                }
            }
            else
            {

                $model->password = '';
                $resultat =  $this->render('login', [
                    'model' => $model,
                ]);
            }
        }
        return $resultat;

    }

    /**
     * Displays resetpassword page.
     *
     * @return Response|string
     */
    public function actionResetpassword()
    {

       {
            $model = new ForgetPasswordForm();
            if ($model->load(Yii::$app->request->post()) && $model->validate()) {
                $model->generatednewpassword();  
                return  $this->goHome();

            }
            return $this->render('ForgetPassword', [
                'model' => $model,
            ]);
       }
    }

    /**
     * Displays firstlogin page.
     *
     * @return Response|string
     */
    public function actionFirstlogin()
    {

       {
            $model = new FirstConnexionForm();
            if ($model->load(Yii::$app->request->post()) && $model->validate()) {
                $model->SaveNewpassword();  
                return  $this->goHome();

            }
            return $this->render('FirstConnexion', [
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
