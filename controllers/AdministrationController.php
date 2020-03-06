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
     * Implemented by : ServiceInterface.
     * Use to create sub-menu in the LeftMenuBar widget.
     * 
     * @param User $user : Not used anymore.
     * @return Array All data about sub menu links. Used in LeftMenuBar widget.
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
     * Render view : administration/index
     * List of all User in administration/index view.
     * 
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
     * Render view : administration/view?id=?
     * Single User in administration/view view get by ID.
     * 
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException If the model is not found.
     */
    public function actionView($id)
    {
        $userRoles = Yii::$app->authManager->getRolesByUser($id);

        return $this->render('view', [
            'model' => $this->findModel($id), 'userRoles' => $userRoles,
        ]);
    }

    /**
     * Render view : administration/create.
     * Creates a new user.
     * 
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
     * Render view : administration/update.
     * Update a user.
     * Directed view : administration/index.
     * 
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException If the model cannot be found.
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
     * Render view : 
     * Deletes an existing user..
     * Redirected view : administration/index.
     * 
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
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * 
     * @param integer $id
     * @return Devis the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CapaUser::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * NOT USED.
     */
    public static function getIndicator($user)
    {
    }
}
