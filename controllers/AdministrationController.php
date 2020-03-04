<?php

namespace app\controllers;

use yii\filters\AccessControl;
use Yii;
use app\models\user\CapaUser;
use app\models\user\UserRole;
use app\models\user\CapaUserSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;

/**
 * AdministrationController implements the CRUD actions for CapaUser model.
 */
class AdministrationController extends Controller
{

    /**
     * {@inheritdoc}
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
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['Index', 'View', 'Create', 'Update', 'Delete'],
                'rules' => [
                    [
                        'actions' => ['Index', 'View', 'Create', 'Update', 'Delete'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Get list of the right
     */
    public static function GetRight()
    {
        return  [
            'name' => 'Administration',
            'right' => [
                'none' => 'none',
                'Responsable' => 'Responsable'
            ]
        ];
    }

    /**
     * Used to send to sideNavbar, informations about our router.
     */
    public static function getActionUser($user)
    {
        $result = [];
        //Je verifie qu'il possède au moins un droit sur le service administration
        if ($user->identity->GetUserRole()->where(['service' => 'Administration'])->exists()) {
            //Je récupère le service administration
            $role = $user->identity->getUserRole()->where(['service' => 'Administration'])->select('role')->one();

            //Je verifie qu'il est reponsable
            if ($role->role == 'Responsable') {
                $result =
                    [
                        'priorite' => 1,
                        'name' => 'Administration',
                        'items' =>
                        [
                            [
                                'priorite' => 1,
                                'url' => 'administration/index',
                                'label' => 'Liste des salariés',
                                'icon' => 'show_chart'
                            ],
                            [
                                'priorite' => 2,
                                'url' => 'administration/userform',
                                'label' => 'Ajouter un salarié',
                                'icon' => 'show_chart'
                            ]
                        ]
                    ];
            }
        }

        return   $result;
    }

    /**
     * before action for a controller
     */
    public function beforeAction($action)
    {
        //Verifie les Behavior
        $result = parent::beforeAction($action);
        if ($result) {
            $capa_user = Yii::$app->user->identity;

            if ($capa_user->getUserRole()->where(['service' => 'Administration'])->exists()) {
                $userRole = $capa_user->getUserRole()->where(['service' => 'Administration'])->select('role')->one();
                if ($userRole->role == 'none') {
                    $result = false;
                }
            } else {
                $result = false;
            }
        }

        return $result;
    }
    /**
     * Lists all CapaUser models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CapaUserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single CapaUser model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $query = UserRole::find()->where(['user_id' => $id]);

        $rightProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $this->render('view', [
            'model' => $this->findModel($id), 'rightProvider' => $rightProvider,
        ]);
    }

    /**
     * Creates a new CapaUser model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new CapaUser();

        if ($model->load(Yii::$app->request->post())) {

            $array = Yii::$app->request->post('CapaUser')['userRole'];
            $arrayKey = array_keys($array);

            foreach ($arrayKey as $key) {

                $userRole = new UserRole();

                $userRole->role = $key;
                $userRole->role = $array[$key];
                $userRole->Save();
            }
            $model->flag_active = true;
            $model->generatePasswordAndmail();
            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing CapaUser model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            $array = Yii::$app->request->post('CapaUser')['userRole'];
            $arrayKey = array_keys($array);
            foreach ($arrayKey as $key) {

                $hasUserRole = UserRole::find()->where(['role' => $key, 'user_id' => $id])->exists();

                //Je vérifie si l'enregistrement existe sinon je le créé.
                if (!$hasUserRole) {
                    $userRole = new UserRole();
                    $userRole->user_id = $id;
                    $userRole->role = $key;
                } else {
                    $userRole = UserRole::findOne(['role' => $key, 'user_id' => $id]);
                }
                $userRole->role = $array[$key];
                $userRole->Save();
            }

            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing CapaidCapaUserentity model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        //on empêche l'auto suppression
        if (Yii::$app->user->identity->id != $id) {
            $user =  $this->findModel($id);
            $userRoles = $user->userRole;
            foreach ($userRoles as $userRole) {
                $userRole->delete();
            }
            $user->flag_active = false;
            $user->save();
        }
        return $this->redirect(['index']);
    }

    /**
     * Get list of indicateur
     *
     */
    public static function GetIndicateur($user)
    {
    }


    protected function findModel($id)
    {
        if (($model = CapaUser::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
