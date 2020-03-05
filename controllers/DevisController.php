<?php

namespace app\controllers;

use yii\filters\AccessControl;
use Yii;
use app\models\Model;
use app\models\devis\Devis;
use app\models\devis\DevisStatus;
use app\models\devis\Company;
use app\models\devis\DeliveryType;
use app\models\devis\DevisCreateForm;
use app\models\devis\DevisUpdateForm;
use app\models\devis\CompanyCreateForm;
use app\models\devis\DevisSearch;
use app\models\devis\Milestone;
use app\helper\_clazz\DateHelper;
use app\helper\_enum\SubMenuEnum;
use app\helper\_enum\UserRoleEnum;
use app\widgets\SubMenuBar;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use Exception;

/**
 * Gestion des différentes routes liées au service Devis.
 */
class DevisController extends Controller implements ServiceInterface
{

    /**
     * Manage each controller access for users's role.
     * Check, for more information, the migrate file : m200800_000000_devis_rbac.
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'denyCallback' => function ($rule, $action) {
                    throw new \Exception('You are not allowed to access this page');
                },
                'only' => ['index', 'view', 'create', 'update', 'delete', 'add-client', 'update-status', 'validate-status'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index'],
                        'roles' => ['indexDevis'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['create'],
                        'roles' => ['createDevis'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['view'],
                        'roles' => ['viewDevis'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['add-company'],
                        'roles' => ['addCompanyDevis'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['update'],
                        'roles' => ['updateDevis'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['delete'],
                        'roles' => ['deleteDevis'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['update-status'],
                        'roles' => ['updateStatusDevis'],
                    ]
                ],
            ],
        ];
    }

    /**
     * Generate tabs in left menu view.
     */
    public static function getActionUser($user)
    {
        $result = [];

        if (
            Yii::$app->user->can('projectManagerDevis') ||
            Yii::$app->user->can('operationalManagerDevis') ||
            Yii::$app->user->can('accountingSupportDevis')
        ) {

            $result = [
                'priorite' => 3, 'name' => 'Devis',
                'items' => [
                    [
                        'Priorite' => 1,
                        'url' => 'devis/add-company',
                        'label' => 'Ajouter un client',
                        'active' => SubMenuEnum::DEVIS_ADD_COMPANY()
                    ],
                    [
                        'Priorite' => 2,
                        'url' => 'devis/create',
                        'label' => 'Créer un devis',
                        'active' => SubMenuEnum::DEVIS_CREATE()
                    ],
                    [
                        'Priorite' => 3,
                        'url' => 'devis/index',
                        'label' => 'Liste des devis',
                        'active' => SubMenuEnum::DEVIS_LIST()
                    ],
                ]
            ];
        }

        return $result;
    }


    /**
     * Lists all Devis models.
     * @return mixed
     */
    public function actionIndex()
    {

        $searchModel = new DevisSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        Yii::$app->params['activeMenu'] = SubMenuEnum::DEVIS_LIST();
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

        Yii::$app->params['activeMenu'] = SubMenuEnum::DEVIS_NONE();
        return $this->render('view', [
            'model' => $this->findModel($id),
            'milestones' => Milestone::find()->where(['devis_id' => $id])->all()
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

        Yii::$app->params['activeMenu'] = SubMenuEnum::DEVIS_NONE();

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
     * Creates a new Devis model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {

        $model = new DevisCreateForm();

        // Get data that we wish to use on our view.
        $deliveryType = DeliveryType::getDeliveryTypes();

        // Here we type a specific requetst because we only want names of clients.
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
                Yii::$app->params['activeMenu'] = SubMenuEnum::DEVIS_LIST();
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        Yii::$app->params['activeMenu'] = SubMenuEnum::DEVIS_CREATE();
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
     * route : devis/add-client
     * 
     * @return mixed
     */
    public function actionAddCompany()
    {

        $model = new CompanyCreateForm();

        if ($model->load(Yii::$app->request->post())) {

            if ($model->validate()) {

                $model->name = $model->name;
                $model->tva =  $model->tva;
                $model->description = $model->description;

                $model->save();
                Yii::$app->params['activeMenu'] = SubMenuEnum::CREATE();
                return $this->redirect(['create']);
            }
        }

        Yii::$app->params['activeMenu'] = SubMenuEnum::DEVIS_ADD_COMPANY();
        return $this->render(
            'addCompany',
            [
                'model' =>  $model
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

        // Get the models values from devis.
        $model =  DevisUpdateForm::findOne($id);
        $model->company_name = $model->company->name;

        // Get all delivery types.
        $deliveryType = DeliveryType::getDeliveryTypes();

        // Seperate the relationnal object from devis.
        $milestones = $model->milestones;

        // Here we type a specific request because we only want names of clients.
        $companiesNames = ArrayHelper::map(Company::find()->all(), 'id', 'name');
        $companiesNames = array_merge($companiesNames);


        if ($model->load(Yii::$app->request->post())) {

            if ($model->validate()) {

                // Map the new milestones with existants one.
                $milestones = Model::createMultiple(Milestone::classname(), $milestones);

                // Load milestones into model.
                Model::loadMultiple($milestones, Yii::$app->request->post());

                // Get the company data with name insert in field.
                $company = Company::find()->where(['name' =>  $model->company_name])->one();

                $transaction = \Yii::$app->db->beginTransaction();

                try {

                    // Save the company inserted.
                    $company->save(false);
                    $model->company_id = $company->id;

                    foreach ($milestones as $milestone) {

                        // Format date for sql insertion.
                        $milestone->devis_id = $model->id;
                        $milestone->delivery_date = DateHelper::formatDateTo_Ymd($milestone->delivery_date);

                        // Insert the milestone.
                        $milestone->save(false);
                    }

                    // Save the Devis change.
                    $model->save(false);

                    // Confirm all the changes on db.
                    $transaction->commit();

                    Yii::$app->params['activeMenu'] = SubMenuEnum::DEVIS_NONE();
                    return $this->redirect(['view', 'id' => $model->id]);
                } catch (Exception $e) {

                    // If exception occur, rollback all changes.
                    $transaction->rollBack();
                }
            }
        }

        Yii::$app->params['activeMenu'] = SubMenuEnum::DEVIS_LIST();
        return $this->render(
            'update',
            [
                'model' => $model,
                'delivery_type' =>  $deliveryType,
                'companiesNames' => $companiesNames,
                'milestones' => (empty($milestones)) ? [new Milestone] : $milestones
            ]
        );
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

        Yii::$app->params['activeMenu'] = SubMenuEnum::DEVIS_LIST();
        return $this->redirect(['index']);
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

        switch ($status) {
            case 1:
                $this->setStatus($model, $status);
                break;
            case 2:
                $this->setStatus($model, $status);
                break;
            case 3:
                if (
                    Yii::$app->user->can('operationalManagerDevis') ||
                    Yii::$app->user->can('accountingSupportDevis')
                ) $this->setStatus($model, $status);
                break;
            case 4:
                if (
                    Yii::$app->user->can('operationalManagerDevis') ||
                    Yii::$app->user->can('accountingSupportDevis')
                ) $this->setStatus($model, $status);
                break;
            case 5 || 6:
                if (
                    Yii::$app->user->can('operationalManagerDevis') ||
                    Yii::$app->user->can('accountingSupportDevis')
                ) $this->setStatus($model, $status);
                break;
        }

        Yii::$app->params['activeMenu'] = SubMenuEnum::DEVIS_LIST();
        return $this->redirect(['index']);
    }

    private function setStatus($model, $status)
    {
        if ($model) {
            $model->status_id = $status;
            $model->save();
        }
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


    public static function getIndicator($user)
    {
        return  ['label' => 'NbDevis', 'value' => Devis::getGroupbyStatus()];
    }
}
