<?php

namespace app\controllers;

use yii\filters\AccessControl;
use Yii;
use app\models\devis\Devis;
use app\models\devis\DevisStatus;
use app\models\devis\Company;
use app\models\devis\DevisCreateForm;
use app\models\devis\DevisUpdateForm;
use app\models\devis\DevisSearch;
use app\models\devis\DeliveryType;
use app\models\devis\Milestone;
use app\helper\_clazz\DateHelper;
use app\models\Model;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * Gestion des différentes routes liées au service Devis.
 */
class DevisController extends Controller implements ServiceInterface
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
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
     * Lists all Devis models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DevisSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider
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
     * Displays a single Devis model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionViewpdf($id)
    {
        $model =  $this->findModel($id);
        if ($model) {
            $filepath = 'uploads/' . $model->id_capa . '/' . $model->filename;
            if (file_exists($filepath)) {

                // Set up PDF headers 
                header('Content-type: application/pdf');
                header('Content-Disposition: inline; filename="' . $model->filename . '"');
                // Render the file
                readfile($filepath);
            } else {
                // PDF doesn't exist so throw an error or something
            }
        }
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
     * Creates a new Devis model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new DevisCreateForm();

        // Get data that we wish to use on our view.
        $deliveryType = DeliveryType::getDeliveryTypes();

        // Here we type a specific requets because we only want names of clients.
        $companiesNames = ArrayHelper::map(Company::find()->all(), 'id', 'name');
        $companiesNames = array_merge($companiesNames);

        // Validation du devis depuis la vue de création.
        if ($model->load(Yii::$app->request->post())) {

            if ($model->validate()) {

                // Vérification pour savoir si le client existe déjà en base de données, si il n'existe pas, on retourne une erreur.
                $company = Company::find()->where(['name' => $model->company_name])->one();
                if ($company == null) {
                    return null;
                }

                // Préparation du modèle de devis à sauvegarder.
                $model->id_capa = yii::$app->user->identity->cellule->identity . printf('%04d', $model->id);
                $model->id_laboxy = $model->id_capa . ' - ' . $company->name;
                $model->company_id =  $company->id;
                $model->capa_user_id = yii::$app->user->identity->id;
                $model->cellule_id =  yii::$app->user->identity->cellule->id;
                $model->status_id = DevisStatus::AVANT_PROJET;

                $model->save();
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render(
            'create',
            [
                'model' => $model,
                'delivery_type' => $deliveryType,
                'companiesNames' => $companiesNames
            ]
        );
    }

    /**
     * Updates an existing Devis avant contrat devis models.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {

        $devis =  DevisUpdateForm::findOne($id);
        $deliveryType = DeliveryType::getDeliveryTypes();

        $milestones = $devis->milestones;

        if ($devis->load(Yii::$app->request->post())) {

            // Map the new milestones with existants one.
            $milestones = Model::createMultiple(Milestone::classname(), $milestones);

            // Load milestones into model.
            Model::loadMultiple($milestones, Yii::$app->request->post());

            // Set the maximum price of all milestones to check values.
            $totalMilestonesPrice = 0;
            foreach ($milestones as $milestone) {
                $totalMilestonesPrice += $milestone->price;
            }

            // Load data from company fields.
            $companyData = Yii::$app->request->post('DevisUpdateForm')['company'];

            $company = Company::find()->where(['name' => $companyData['name'], 'tva' => $companyData['tva']])->one();

            if ($company == null) {
                $company = new Company();
                $company->name = $companyData['name'];
                $company->tva = $companyData['tva'];
            }

            $company->save();

            $devis->company_id = $company->id;
            $transaction = \Yii::$app->db->beginTransaction();

            try {
                $devis->save(false);

                foreach ($milestones as $milestone) {

                    // Format date for sql insertion.
                    $milestone->devis_id = $devis->id;
                    $milestone->delivery_date = DateHelper::formatDateTo_Ymd($milestone->delivery_date);

                    // Verify the integrity of each Milestone.

                    if (!($flag = $milestone->save(false))) {
                        $transaction->rollBack();
                        break;
                    }
                }

                $transaction->commit();
            } catch (Exception $e) {
                $transaction->rollBack();
            }

            return $this->redirect(['view', 'id' => $devis->id]);
        }

        return $this->render(
            'update',
            [
                'model' => $devis, 'delivery_type' =>  $deliveryType,
                'milestones' => (empty($milestones)) ? [new Milestone] : $milestones,
            ]
        );
    }


    /**
     * Change the status of devis, not sure if this route should be used like this. We'll see.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @param integer $status Static value of DevisStatus
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdateStatus($id, $status)
    {
        $model = $this->findModel($id);

        if ($model) {
            $model->status_id = $status;
            $model->save();
        }

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
            'name' => 'Administration',
            'right' => [
                'none' => 'none',
                'Responsable' => 'Responsable'
            ]
        ];
    }


    public static function GetIndicateur($user)
    {

        return  ['label' => 'NbDevis', 'value' => Devis::getGroupbyStatus()];
    }


    public static function GetActionUser($user)
    {
        $result = [];

        $result = [
            'priorite' => 3, 'name' => 'Devis',
            'items' => [
                ['Priorite' => 1, 'url' => 'devis/index', 'label' => 'Liste des devis', 'icon' => 'show_chart'],
                ['Priorite' => 2, 'url' => 'devis/create', 'label' => 'Ajouter un devis', 'icon' => 'show_chart']
            ]
        ];

        return $result;
    }
}
