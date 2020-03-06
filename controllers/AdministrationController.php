<?php

namespace app\controllers;

use app\helper\_enum\SubMenuEnum;
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
                'denyCallback' => function ($rule, $action) {
                    throw new \Exception('You are not allowed to access this page');
                },
                'only' => ['index', 'view', 'create', 'update', 'delete'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index'],
                        'roles' => ['indexAdmin'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['create'],
                        'roles' => ['createAdmin'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['view'],
                        'roles' => ['viewAdmin'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['update'],
                        'roles' => ['updateAdmin'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['delete'],
                        'roles' => ['deleteAdmin'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Used to send to sideNavbar, informations about our router.
     */
    public static function getActionUser($user)
    {
        $result = [];

        if (Yii::$app->user->can('administrator')) {
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
                            'icon' => 'show_chart',
                            'active' => SubMenuEnum::USER_LIST()
                        ]
                    ]
                ];
        }

        return   $result;
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
        $userRoles = Yii::$app->authManager->getRolesByUser($id);

        return $this->render('view', [
            'model' => $this->findModel($id), 'userRoles' => $userRoles,
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
     * Get list of indicateur.
     */
    public static function getIndicator($user)
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
