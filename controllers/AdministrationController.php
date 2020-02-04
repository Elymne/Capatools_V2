<?php

namespace app\controllers;

use Yii;
use app\models\User\Capaidentity;
use app\models\User\Capaidentitysearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\VarDumper;
/**
 * AdministrationController implements the CRUD actions for Capaidentity model.
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
        ];
    }

    /**
     * Lists all Capaidentity models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new Capaidentitysearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Capaidentity model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Capaidentity model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Capaidentity();

        if ($model->load(Yii::$app->request->post()))
        {
            $model->generatePasswordAndmail();
            if( $model->save()) {
                 return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Capaidentity model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Capaidentity model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
   /**
    * Get list of the right
    */
    public static  function GetRight()
    {
        return ['Aucun',
                'Responsable'];
    }

    /**
     * Get list of indicateur
     *
     */
    public static  function GetIndicateur($user)
    {

    }

    /**
     * Get Action for the user
     */
    public static  function GetActionUser($user)
    {
       // if($user->get)
        return ['Priorite' => 1,'Name' =>'Administration',
        'items' => [ ['Priorite' => 1,'url' => 'administration/index','label'=>'Liste Utilisateur','icon'=>'show_chart'],
         ['Priorite' => 2,'url' =>'administration/userform','label'=>'Ajouter utilisateur','icon'=>'show_chart']  ]    
        ];
    }

    /**
     * Finds the Capaidentity model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Capaidentity the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Capaidentity::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
