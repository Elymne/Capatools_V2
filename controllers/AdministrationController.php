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
use yii\helpers\VarDumper;
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
     * before action for a controller
     */
    public function beforeAction($action)
    {
        //Verifie les Behavior
        $result = parent::beforeAction($action);
        if ($result) {
            $capa_user = Yii::$app->user->identity;

            if ($capa_user->getUserRole()->where(['Application' => 'Administration'])->exists()) {
                $rights = $capa_user->getUserRole()->where(['Application' => 'Administration'])->select('Credential')->one();
                if ($rights->Credential == 'Aucun') {
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
        $query = userrightapplication::find()->where(['Userid' => $id]);

        $Rightprovider = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $this->render('view', [
            'model' => $this->findModel($id), 'Rightprovider' => $Rightprovider,
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
            $array = Yii::$app->request->post('CapaUser')['userrightapplication'];
            $arraykey = array_keys($array);
            foreach ($arraykey as $Service) {

                $Rightmodel = new userrightapplication();


                $Rightmodel = new userrightapplication();
                $Rightmodel->Userid = $id;
                $Rightmodel->Application = $Service;

                $Rightmodel->Credential = $array[$Service];
                $Rightmodel->Save();
            }

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

            $array = Yii::$app->request->post('CapaUser')['userrightapplication'];
            $arraykey = array_keys($array);
            foreach ($arraykey as $Service) {

                $Rightmodel = new userrightapplication();
                $Existmodel = userrightapplication::find()->where(['Application' => $Service, 'Userid' => $id])->exists();

                //Je vérifie si l'enregistrement existe sinon je le créé.
                if (!$Existmodel) {
                    $Rightmodel = new userrightapplication();
                    $Rightmodel->Userid = $id;
                    $Rightmodel->Application = $Service;
                } else {
                    $Rightmodel =  userrightapplication::findOne(['Application' => $Service, 'Userid' => $id]);
                }
                $Rightmodel->Credential = $array[$Service];
                $Rightmodel->Save();
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
            $Rightmodels = userrightapplication::findAll(['Userid' => $id]);
            foreach ($Rightmodels as $Rightmodel) {
                $Rightmodel->delete();
            }
            $this->findModel($id)->delete();
        }
        return $this->redirect(['index']);
    }

    /**
     * Get list of the right
     */
    public static function GetRight()
    {
        return  ['name' => 'Administration', 'right' => [
            'Aucun' => 'Aucun',
            'Responsable' => 'Responsable'
        ]];
    }

    /**
     * Get list of indicateur
     *
     */
    public static function GetIndicateur($user)
    {
    }

    /**
     * Get Action for the user
     */
    public static function GetActionUser($user)
    {
        $result = [];
        //Je verifie qu'il possède au moin un droit sur le service administration
        if ($user->identity->getuserrightapplication()->where(['Application' => 'Administration'])->exists()) {
            //Je récupère le service administration
            $rights = $user->identity->getuserrightapplication()->where(['Application' => 'Administration'])->select('Credential')->one();

            //Je verifie qu'il est reponsable
            if ($rights->Credential == 'Responsable') {
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
    protected function findModel($id)
    {
        if (($model = CapaUser::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
