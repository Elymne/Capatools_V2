<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use app\models\login\LoginForm;
use app\models\login\ForgetPasswordForm;
use app\models\login\FirstConnexionForm;
use app\models\ContactForm;

/**
 * Classe contrôleur des vues et des actions de la partie Dashboard.
 * Attention au nom du contrôleur, il détermine le point d'entré de la route.
 * ex : pour notre contrôleur DashboardController -> dashboard/[*]
 * Chaque route généré par le controller provient des fonctions dont le nom commence par action******.
 * ex : actionIndex donnera la route suivante -> dashboard/index
 * ex : actionIndexDetails donnera la route suivante -> dashboard/index-details.
 * 
 * Ce contrôleur n'est actuellement pas fonctionnel et non prévu pour la v2.0 de capatools.
 * 
 * @version Capatools v2.0
 * @since Classe existante depuis la Release v2.0
 */
class DashboardController extends Controller
{

    /**
     * Utilisé pour déterminer les droits sur chaque action du contrôleur.
     * Dans la clé "rules", on défini un ou plusieurs rôles à une action du contrôleur.
     * 
     * @return array Un tableau de droits tel que Yii2 le défini.
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'resetpassword', 'login'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['resetpassword', 'login'],
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
     * Cette route est tout simplement la page d'accueil.
     * Si l'utilisateur est déjà loggé à l'application, elle redirige vers la page principale.
     * 
     * @return mixed
     */
    public function actionIndex()
    {
        // Si l'utilisateur est logger alors affiche la page principal, isGuest retourne true si personne n'est log sur l'app.
        if (!Yii::$app->user->isGuest) {
            return $this->render('index');
        }

        // Création du formulaire de login
        $model = new LoginForm();

        if ($model->load(Yii::$app->request->post()) && $model->login()) {

            //Vérifie que l'utilisateur ne doit pas renouveller son mot de passe
            $capuser =  Yii::$app->user->getIdentity();
            if ($capuser->flag_password) {
                //Lancement du formulaire de renouvellement de mot passe utilisateur
                $this->redirect('dashboard/firstlogin');
            } else {
                return $this->render('index');
            }
        }

        $model->password = '';

        // layout in /layouts folder (here login.php)
        $this->layout = "login";

        // render in Controller name folder (here dashboard/login.php)
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
            if ($capuser->flag_password) {
                //Lancement du formulaire de renouvellement de mot passe utilisateur
                $this->redirect('firstlogin');
            } else {
                $resultat = $this->goHome();
            }
        } else {
            $model = new LoginForm();
            if ($model->load(Yii::$app->request->post()) && $model->login()) {


                //Vérifie que l'utilisateur ne doit pas renouveller son mot de passe
                $capuser =  Yii::$app->user->getIdentity();
                if ($capuser->flag_password) {
                    //Lancement du formulaire de renouvellement de mot passe utilisateur
                    $this->redirect('firstlogin');
                } else {
                    $resultat = $this->goBack();
                }
            } else {

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
    { {
            $model = new ForgetPasswordForm();
            if ($model->load(Yii::$app->request->post()) && $model->validate()) {
                $model->generatednewpassword();
                return  $this->goHome();
            }
            $this->layout = "login";
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
    { {
            $model = new FirstConnexionForm();
            if ($model->load(Yii::$app->request->post()) && $model->validate()) {
                $model->SaveNewpassword();
                return  $this->goHome();
            }
            $this->layout = "login";
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
