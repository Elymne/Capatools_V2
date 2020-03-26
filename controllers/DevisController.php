<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

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

use app\models\devis\MilestoneStatus;

use Exception;
use kartik\mpdf\Pdf;

/**
 * Gestion des différentes routes liées au service Devis.
 */
class DevisController extends Controller implements ServiceInterface
{

    /**
     * Manage each controller access for current users's role.
     * Check the migrate file : m200800_000000_devis_rbac for more information.
     * 
     * @return Array All data with router access permission.
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
                        // Nom de la route, (actionIndex).
                        'actions' => ['index'],
                        // Nom du rôle que tu as créé.
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
     * Implemented by : ServiceInterface.
     * Use to create sub-menu in the LeftMenuBar widget.
     * 
     * @param User $user : Not used anymore.
     * @return Array All data about sub menu links. Used in LeftMenuBar widget.
     */
    public static function getActionUser($user)
    {
        $result = [];

        // Yii::$app->user->can(UserRoleEnum::PROJECT_MANAGER_DEVIS) retourne un booléen.
        // Si il retourne true, c'est que ton user local possède le droit.
        // UserRoleEnum::PROJECT_MANAGER_DEVIS est une ENUM, il retourne le nom du rôle que j'ai créé dans le dossier migrate.
        // Ca permet d'avoir un code plus robuste.

        if (
            Yii::$app->user->can(UserRoleEnum::PROJECT_MANAGER_DEVIS) ||
            Yii::$app->user->can(UserRoleEnum::OPERATIONAL_MANAGER_DEVIS) ||
            Yii::$app->user->can(UserRoleEnum::ACCOUNTING_SUPPORT_DEVIS)
        ) {

            $result = [
                'priorite' => 3,
                'name' => 'Devis',
                // serviceMenuActive est à un moyen très peu efficace, je vais essayer de l'oter, j'ai fais ça car je savais pas trop comment gérer
                // les actives bar du menu à gauche.
                'serviceMenuActive' => SubMenuEnum::DEVIS,
                'items' => [
                    [
                        'Priorite' => 3,
                        'url' => 'devis/index',
                        'label' => 'Liste des devis',
                        'subServiceMenuActive' => SubMenuEnum::DEVIS_LIST
                    ],
                    [
                        'Priorite' => 2,
                        'url' => 'devis/create',
                        'label' => 'Créer un devis',
                        'subServiceMenuActive' => SubMenuEnum::DEVIS_CREATE
                    ],
                    [
                        'Priorite' => 1,
                        'url' => 'devis/add-company',
                        'label' => 'Ajouter un client',
                        'subServiceMenuActive' => SubMenuEnum::DEVIS_ADD_COMPANY
                    ]
                ]
            ];
        }

        return $result;
    }


    /**
     * Render view : devis/index
     * List of all Devis in devis/index view.
     * 
     * @return mixed 
     */
    public function actionIndex()
    {

        $searchModel = new DevisSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        Yii::$app->params['subServiceMenuActive'] = SubMenuEnum::DEVIS_LIST;
        Yii::$app->params['serviceMenuActive'] = SubMenuEnum::DEVIS;
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider
        ]);
    }

    /**
     * Render view : devis/view?id=?
     * Single Devis in devis/view view get by ID.
     * 
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException If the model is not found.
     */
    public function actionView($id)
    {

        Yii::$app->params['subServiceMenuActive'] = SubMenuEnum::DEVIS_NONE;
        Yii::$app->params['serviceMenuActive'] = SubMenuEnum::DEVIS;
        return $this->render('view', [
            'model' => $this->findModel($id),
            'milestones' => Milestone::find()->where(['devis_id' => $id])->all()
        ]);
    }

    /**
     * Render view : devis/pdf?id=?
     * Generate PDF and show it.
     * 
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException If the model is not found.
     */
    public function actionPdf($id)
    {

        $model = $this->findModel($id);

        $css = [
            '' . Yii::getAlias('@web') . 'app-assets/vendors/vendors.min.css',
            '' . Yii::getAlias('@web') . 'app-assets/css/themes/vertical-dark-menu-template/materialize.min.css',
            '' . Yii::getAlias('@web') . 'app-assets/css/themes/vertical-dark-menu-template/style.min.css',
            '' . Yii::getAlias('@web') . 'app-assets/css/pages/dashboard.min.css',
            '' . Yii::getAlias('@web') . 'css/custom.css'
        ];

        $filename = $model->internal_name . '_pdf_' . date("r");

        $content = $this->renderPartial('pdf', [
            'model' => $model,
            'milestones' => Milestone::find()->where(['devis_id' => $id])->all()
        ]);

        $pdf = new Pdf([
            'mode' => Pdf::MODE_CORE,
            'format' => Pdf::FORMAT_LEDGER,
            'orientation' => Pdf::ORIENT_PORTRAIT,
            'destination' => Pdf::DEST_BROWSER,
            'content' => $content,
            'filename' => $filename,
            'cssFile' => $css,

            'options' => [],
            'methods' => [
                'SetTitle' => 'Fiche de devis - TEST',
                'SetSubject' => 'Generating PDF files',
                'SetHeader' => ['Fiche Devis - ' . $model->internal_name . ' || Generated On: ' . date("r")],
                'SetKeywords' => 'Krajee, Yii2, Export, PDF, MPDF, Output, Privacy, Policy, yii2-mpdf',
            ]
        ]);

        Yii::$app->params['serviceMenuActive'] = SubMenuEnum::DEVIS;
        return $pdf->render();
    }



    /**
     * Render view : devis/create.
     * Creates a new devis.
     * 
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

                Yii::$app->params['serviceMenuActive'] = SubMenuEnum::DEVIS;
                Yii::$app->params['subServiceMenuActive'] = SubMenuEnum::DEVIS_LIST;
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        Yii::$app->params['serviceMenuActive'] = SubMenuEnum::DEVIS;
        Yii::$app->params['subServiceMenuActive'] = SubMenuEnum::DEVIS_CREATE;
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
     * Render view : devis/add-company.
     * Create a new Company.
     * Directed view : devis/view?id=?.
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

                Yii::$app->params['serviceMenuActive'] = SubMenuEnum::DEVIS;
                Yii::$app->params['subServiceMenuActive'] = SubMenuEnum::DEVIS_CREATE;
                return $this->redirect(['create']);
            }
        }

        Yii::$app->params['serviceMenuActive'] = SubMenuEnum::DEVIS;
        Yii::$app->params['subServiceMenuActive'] = SubMenuEnum::DEVIS_ADD_COMPANY;
        return $this->render(
            'addCompany',
            [
                'model' =>  $model
            ]
        );
    }

    /**
     * Render view : devis/update.
     * Update a devis.
     * Directed view : devis/index.
     * 
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException If the model cannot be found.
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

                        // Set default milestone status (in progress).
                        $milestone->milestone_status_id = 1;

                        // Insert the milestone.
                        $milestone->save(false);
                    }

                    // Save the Devis change.
                    $model->save(false);

                    // Confirm all the changes on db.
                    $transaction->commit();

                    Yii::$app->params['serviceMenuActive'] = SubMenuEnum::DEVIS;
                    Yii::$app->params['subServiceMenuActive'] = SubMenuEnum::DEVIS_NONE;
                    return $this->redirect(['view', 'id' => $model->id]);
                } catch (Exception $e) {

                    // If exception occur, rollback all changes.
                    $transaction->rollBack();
                }
            }
        }

        Yii::$app->params['serviceMenuActive'] = SubMenuEnum::DEVIS;
        Yii::$app->params['subServiceMenuActive'] = SubMenuEnum::DEVIS_LIST;
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
     * Render view : 
     * Deletes an existing devis.
     * Redirected view : devis/index.
     * 
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        Yii::$app->params['serviceMenuActive'] = SubMenuEnum::DEVIS;
        Yii::$app->params['subServiceMenuActive'] = SubMenuEnum::DEVIS_LIST;
        return $this->redirect(['index']);
    }

    /**
     * Render view :
     * Change the status of devis.
     * Redirected view : devis/index.
     * 
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
                    Yii::$app->user->can(UserRoleEnum::OPERATIONAL_MANAGER_DEVIS) ||
                    Yii::$app->user->can(UserRoleEnum::ACCOUNTING_SUPPORT_DEVIS)
                ) $this->setStatus($model, $status);
                break;
            case 4:
                if (
                    Yii::$app->user->can(UserRoleEnum::OPERATIONAL_MANAGER_DEVIS) ||
                    Yii::$app->user->can(UserRoleEnum::ACCOUNTING_SUPPORT_DEVIS)
                ) $this->setStatus($model, $status);
                break;
            case 5 || 6:
                if (
                    Yii::$app->user->can(UserRoleEnum::OPERATIONAL_MANAGER_DEVIS) ||
                    Yii::$app->user->can(UserRoleEnum::ACCOUNTING_SUPPORT_DEVIS)
                ) $this->setStatus($model, $status);
                break;
        }

        Yii::$app->params['serviceMenuActive'] = SubMenuEnum::DEVIS;
        Yii::$app->params['subServiceMenuActive'] = SubMenuEnum::DEVIS_LIST;
        return $this->redirect(['index']);
    }

    private function setStatus($model, $status)
    {
        if ($model) {
            $model->status_id = $status;
            $model->save();
        }
    }

    public function actionUpdateMilestoneStatus($id, $status, $id_devis)
    {

        if (Yii::$app->user->can(UserRoleEnum::ACCOUNTING_SUPPORT_DEVIS)) {
            if ($status == MilestoneStatus::ENCOURS || $status == MilestoneStatus::FACTURATIONENCOURS) {
                Milestone::setStatusById($id, $status + 1);
            }
        }

        Yii::$app->params['subServiceMenuActive'] = SubMenuEnum::DEVIS_NONE;
        Yii::$app->params['serviceMenuActive'] = SubMenuEnum::DEVIS;
        return $this->render('view', [
            'model' => $this->findModel($id_devis),
            'milestones' => Milestone::find()->where(['devis_id' => $id_devis])->all()
        ]);
    }

    /**
     * Finds the Devis model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * 
     * @param integer $id
     * @return Devis the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Devis::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Le devis n\'existe pas.');
    }

    /**
     * NOT USED.
     */
    public static function getIndicator($user)
    {
        return  ['label' => 'NbDevis', 'value' => Devis::getGroupbyStatus()];
    }

    /**
     * NOT USED.
     */
    public function actionViewpdf($id)
    {

        Yii::$app->params['serviceMenuActive'] = SubMenuEnum::DEVIS_NONE;

        $model = $this->findModel($id);
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
}
