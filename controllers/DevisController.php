<?php

namespace app\controllers;

use Yii;
use app\models\devis\Devis;
use app\models\devis\DevisSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DevisController implements the CRUD actions for Devis model.
 */
class DevisController extends Controller implements ServiceInterface
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'priorite' => 3,
            'name' => 'Devis',
            'items' => [
                [
                    'priorite' => 1,
                    'url' => 'devis/index',
                    'label' => 'Liste des devis',
                    'icon' => 'show_chart'
                ],
                [
                    'priorite' => 2,
                    'url' => 'devis/create',
                    'label' => 'Créer un devis',
                    'icon' => 'show_chart'
                ],
            ],
        ];
    }

    /**
     * Lists all Devis models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DevisSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Devis model.
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
     * Creates a new Devis model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Devis();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Devis model.
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
     * Deletes an existing Devis model.
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
     * Finds the Devis model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Devis the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Devis::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }


    public static function GetRight()
    {
        return  [
            'Name' => 'Administration',
            'Right' => [
                'Aucun' => 'Aucun',
                'Responsable' => 'Responsable'
            ]
        ];
    }


    public static function GetIndicateur($user)
    {
    }


    public static function GetActionUser($user)
    {
        $result = [];

        $result = [
            'Priorite' => 3, 'Name' => 'Devis',
            'items' => [
                ['Priorite' => 1, 'url' => 'devis/index', 'label' => 'Liste des devis', 'icon' => 'show_chart'],
                ['Priorite' => 2, 'url' => 'devis/create', 'label' => 'Ajouter un devis', 'icon' => 'show_chart']
            ]
        ];

        return $result;
    }
}
