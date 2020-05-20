<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

use app\models\Model;
use app\models\devis\Devis;
use app\models\devis\DevisStatus;
use app\models\companies\Company;
use app\models\devis\DeliveryType;
use app\models\devis\DevisCreateForm;
use app\models\devis\DevisUpdateForm;
use app\models\devis\DevisSearch;
use app\models\devis\Milestone;
use app\models\devis\MilestoneStatus;
use app\models\devis\UploadFile;
use app\helper\_clazz\DateHelper;
use app\helper\_clazz\MenuSelectorHelper;
use app\helper\_clazz\UploadFileHelper;
use app\helper\_enum\SubMenuEnum;
use app\helper\_enum\UserRoleEnum;
use app\components\ExcelExportService;
use app\helper\_clazz\UserRoleManager;
use app\helper\_enum\StringData;
use app\models\devis\Contributor;
use app\models\user\CapaUser;
use kartik\mpdf\Pdf;


/**
 * Classe contrôleur des vues et des actions de la partie devis.
 * Attention au nom du contrôleur, il détermine le point d'entré de la route.
 * ex : pour notre contrôleur DevisController -> devis/[*]
 * Chaque route généré par le controller provient des fonctions dont le nom commence par action******.
 * ex : actionIndex donnera la route suivante -> devis/index
 * ex : actionIndexDetails donnera la route suivante -> devis/index-details.
 * 
 * @version Capatools v2.0
 * @since Classe existante depuis la Release v2.0
 */
class DevisController extends Controller implements ServiceInterface
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
                    ],
                    [
                        'allow' => true,
                        'actions' => ['pdf'],
                        'roles' => ['pdfDevis'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['update-milestone-status'],
                        'roles' => ['updateMilestoneStatusDevis'],
                    ]
                ],
            ],
        ];
    }

    /**
     * Implemented by : ServiceInterface.
     * Permet de créer les sous menus et d'associer chaque sous menu à une action du contrôleur.
     * Si l'utilisateur connecté ne possède pas les bons droits, on retourne un tableau vide.
     * Cette méthode est utilisé par le composant suivant : widgets/LeftMenuBar.
     * 
     * - priotite : L'ordre de priorité de position du menu Devis.
     * - name : Texte du menu Devis.
     * - serviceMenuActive : Paramètre utilisé pour permettre de déplier le menu Devis 
     * lorsque l'utilisateur est actuellement sur une vue Devis.
     * - items : Les sous-menus.
     * 
     * @return Array Un tableau de données relatif au menu Devis.
     */
    public static function getActionUser()
    {
        $result = [];
        if (
            UserRoleManager::hasRoles([
                UserRoleEnum::PROJECT_MANAGER_DEVIS,
                UserRoleEnum::OPERATIONAL_MANAGER_DEVIS,
                UserRoleEnum::ACCOUNTING_SUPPORT_DEVIS
            ])
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
                    ]
                ]
            ];
        }

        return $result;
    }


    /**
     * Render view : devis/index
     * Retourne la vue de l'index Devis.
     * Liste de tous les devis présent dans la base de données.
     * 
     * @return mixed 
     */
    public function actionIndex()
    {

        $searchModel = new DevisSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        // Récupération des noms de companies des devis de manière distincte.
        $companiesName = array_unique(array_map(function ($value) {
            return $value->company->name;
        }, Devis::find('company.name')->all()));

        MenuSelectorHelper::setMenuDevisIndex();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'companiesName' => $companiesName
        ]);
    }

    /**
     * Render view : devis/view?id=?
     * Retourne la vue détaillé d'un devis par rapport à l'id rentré en paramètre.
     * 
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException If the model is not found.
     */
    public function actionView(int $id)
    {

        MenuSelectorHelper::setMenuDevisNone();
        return $this->render('view', [
            'model' => $this->findModel($id),
            'milestones' => Milestone::find()->where(['devis_id' => $id])->all(),
            'contributors' => Contributor::find()->where(['devis_id' => $id])->all(),
            'fileModel' => UploadFile::getByDevis($id)
        ]);
    }

    /**
     * Render view : devis/create.
     * Méthode en deux temps :
     * - Si pas de méthode POST de trouvé, retourne la vue de la création d'un devis.
     * - Sinon, à partir de la méthode POST, on récupère toutes les informations du nouvel devis rentrées, et suite à la vérification,
     * on les stocke en base de données.
     * 
     * @return mixed
     */
    public function actionCreate()
    {

        $model = new DevisCreateForm();

        // preload data variable for form.
        $model->payment_details = StringData::DEVIS_PAYMENT_DETAILS;
        $model->payment_conditions = StringData::DEVIS_PAYMENT_CONDITIONS;
        $model->validity_duration = 30;

        // Get data that we wish to use on our view.
        $delivery_types = DeliveryType::getDeliveryTypes();

        // Here we type a specific requetst because we only want names of clients.
        $companiesNames = ArrayHelper::map(Company::find()->all(), 'id', 'name');
        $companiesNames = array_merge($companiesNames);

        // Get file model.
        $fileModel = new UploadFile();

        // Validation du devis depuis la vue de création.
        if ($model->load(Yii::$app->request->post())) {

            if ($model->validate()) {

                // Vérification pour savoir si le client existe déjà en base de données, si il n'existe pas, on retourne une erreur.
                $company = Company::find()->where(['name' => $model->company_name])->one();
                if ($company == null) {
                    return null;
                }

                $model->company_id = $company->id;

                // Préparation du modèle de devis à sauvegarder.
                $model->id_capa = yii::$app->user->identity->cellule->identity . $model->id;
                $model->id_laboxy = $model->id_capa . ' - ' . $company->name;
                $model->capa_user_id = yii::$app->user->identity->id;
                $model->cellule_id =  yii::$app->user->identity->cellule->id;
                $model->status_id = DevisStatus::AVANT_PROJET;
                $model->creation_date = date_create()->format('Y-m-d H:i:s');
                $model->price = $model->unit_price * $model->quantity;
                $model->save();

                // Id has been generated by db so we can use it to create our capaID and save it.
                $model->id_capa = yii::$app->user->identity->cellule->identity . $model->id;

                // Store the file in uploads folder and his name in db.
                $fileModel->file = UploadedFile::getInstance($fileModel, 'file');
                UploadFileHelper::upload($fileModel, (string) $model->id_capa, $model->id);

                $model->save();

                MenuSelectorHelper::setMenuDevisIndex();
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        MenuSelectorHelper::setMenuDevisCreate();
        return $this->render(
            'create',
            [
                'model' => $model,
                'delivery_types' => $delivery_types,
                'companiesNames' => $companiesNames,
                'fileModel' => $fileModel
            ]
        );
    }

    /**
     * Render view : devis/update.
     * Redirected view : devis/index.
     * Méthode en deux temps :
     * - Si pas de méthode POST de trouvé, on retourne la vue de la modification d'un devis.
     * - Sinon, à partir de la méthode POST, on récupère toutes les informations du devis, et ensuite à la vérification,
     * on modifie celui-ci.
     * 
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException If the model cannot be found.
     */
    public function actionUpdate(int $id)
    {

        // Get the models values from devis.
        $model =  DevisUpdateForm::findOne($id);
        $model->company_name = $model->company->name;

        // Get file model.
        $fileModel = new UploadFile();

        // Get all delivery types.
        $deliveryTypes = DeliveryType::getDeliveryTypes();

        // Seperate the relationnal object from devis.
        $milestones = $model->milestones;

        // Separation de l'entité contributors du model devis.
        $contributors = $model->contributors;

        foreach ($contributors as $contributor) {
            $contributor->username = CapaUser::findOne(['id' => $contributor->capa_user_id])->username;
        }

        // Here we type a specific request because we only want names of clients.
        $companiesNames = ArrayHelper::map(Company::find()->all(), 'id', 'name');
        $companiesNames = array_merge($companiesNames);

        // Here we type a specific request because we only want names of users.
        $usersNames = ArrayHelper::map(CapaUser::find()->all(), 'id', 'username');
        $usersNames = array_merge($usersNames);

        // Setup the total price HT.
        $max_price = 0;


        if ($model->load(Yii::$app->request->post())) {

            if ($model->validate()) {

                // Map the new milestones with existants one.
                $milestones = Model::createMultiple(Milestone::classname(), $milestones);

                // Load milestones into model.
                Model::loadMultiple($milestones, Yii::$app->request->post());

                // Map the new contributors with existants one.
                $contributors = Model::createMultiple(Contributor::classname(), $contributors);

                // Load contributors into model.
                Model::loadMultiple($contributors, Yii::$app->request->post());

                // Get the company data with name insert in field.
                $company = Company::find()->where(['name' =>  $model->company_name])->one();

                // Save each milestone.
                foreach ($milestones as $milestone) {

                    $milestone->devis_id = $model->id;
                    // Cumulate the max priceHt.
                    $max_price = $max_price + $milestone->price;

                    // Insert the milestone.
                    $milestone->save();
                }

                // Save each contributor.
                foreach ($contributors as $contributor) {

                    $contributor->devis_id = $model->id;
                    $contributor->capa_user_id = CapaUser::findByUsername($contributor->username)->id;

                    $contributor->save();
                }

                // Store the file in uploads folder and his name in db.
                $fileModel->file = UploadedFile::getInstance($fileModel, 'file');
                UploadFileHelper::upload($fileModel, (string) $model->id_capa, $model->id);

                // Set all milestones prices to devis price.
                $model->price = $max_price;
                $model->company_id = $company->id;

                // Save the Devis change.
                $model->save();

                MenuSelectorHelper::setMenuDevisNone();
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        MenuSelectorHelper::setMenuDevisNone();
        return $this->render(
            'update',
            [
                'model' => $model,
                'delivery_types' =>  $deliveryTypes,
                'companiesNames' => $companiesNames,
                'usersNames' => $usersNames,
                'milestones' => (empty($milestones)) ? [new Milestone] : $milestones,
                'contributors' => (empty($contributors)) ? [new Contributor()] : $contributors,
                'fileModel' => $fileModel
            ]
        );
    }

    /**
     * Render view : none.
     * Redirected view : devis/index.
     * Utilisé pour effacer un devis de la base de données.
     * 
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete(int $id)
    {
        $this->findModel($id)->delete();

        MenuSelectorHelper::setMenuDevisNone();
        return $this->redirect(['index']);
    }

    /**
     * Render view : none
     * Redirected view : devis/index.
     * Modifie le status d'un devis.
     * 
     * @param integer $id
     * @param integer $status Static value of DevisStatus
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdateStatus(int $id, int $status)
    {
        $model = $this->findModel($id);


        if (
            UserRoleManager::hasRoles([
                UserRoleEnum::OPERATIONAL_MANAGER_DEVIS,
                UserRoleEnum::ACCOUNTING_SUPPORT_DEVIS
            ])
        ) $this->setStatus($model, $status);


        MenuSelectorHelper::setMenuDevisNone();
        return $this->render('view', [
            'model' => $this->findModel($id),
            'milestones' => Milestone::find()->where(['devis_id' => $id])->all(),
            'fileModel' => UploadFile::getByDevis($id)
        ]);
    }

    /**
     * Utilisé pour modifier le devis d'un objet Devis.
     * On sauvgarde/modifie ensuite cet objet dans la base de données.
     * 
     * @param Devis Un objet devis dont on veut modifier le status.
     * @param integer Le type de status du devis à modifier.
     */
    private function setStatus(Devis $model, int $status)
    {
        if ($model) {
            $model->status_id = $status;
            $model->save();
        }
    }

    /**
     * Utilisé pour attribuer un status à un jalon de devis.
     * Redirect view : devis/view.
     * 
     * @param int $id
     * @param string $status
     * @param int $id_devis
     * @return View
     */
    public function actionUpdateMilestoneStatus(int $id, string $status, int $id_devis)
    {

        if (UserRoleManager::hasRoles([UserRoleEnum::ACCOUNTING_SUPPORT_DEVIS])) {
            if ($status == MilestoneStatus::ENCOURS || $status == MilestoneStatus::FACTURATIONENCOURS) {
                Milestone::setStatusById($id, $status + 1);
            }
        }

        MenuSelectorHelper::setMenuDevisNone();
        return $this->render('view', [
            'model' => $this->findModel($id_devis),
            'milestones' => Milestone::find()->where(['devis_id' => $id_devis])->all(),
            'fileModel' => UploadFile::getByDevis($id)
        ]);
    }

    /**
     * Utilisé pour télécharger le fichier uploadé d'un devis.
     * 
     * @param int $id
     */
    public function actionDownloadFile(int $id)
    {
        $fileModel = UploadFile::getByDevis($id);

        if ($fileModel != null) {
            $pathFile = $fileModel->name . '.' . $fileModel->type;
            UploadFileHelper::downloadFile($pathFile);
        }
    }

    /**
     * Utilisé pour générer sous format excel les informations d'un devis.
     * 
     * @param int $id
     */
    public function actionDownloadExcel(int $id)
    {
        $model = $this->findModel($id);
        if ($model != null) ExcelExportService::exportModelDataToExcel($model, ExcelExportService::DEVIS_TYPE);
    }

    /**
     * Render view : devis/pdf?id=?
     * Permet de générer une vue html sous format pdf des informations d'un devis, permet aussi de le télécharger.
     * 
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException If the model is not found.
     */
    public function actionPdf(int $id)
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
            'milestones' => Milestone::find()->where(['devis_id' => $id])->all(),
            'fileModel' => UploadFile::getByDevis($id)
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
     * Méthode générale pour le contrôleur permettant de retourner un devis.
     * Cette méthode est utilisé pour gérer le cas où le devis recherché n'existe pas, et donc gérer l'exception.
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
     * @deprecated Cette fonction n'est plus utilisé
     */
    public static function getIndicator($user)
    {
        return  ['label' => 'NbDevis', 'value' => Devis::getGroupbyStatus()];
    }

    /**
     * @deprecated Cette fonction n'est plus utilisé
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
