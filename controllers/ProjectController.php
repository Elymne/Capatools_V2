<?php

namespace app\controllers;

#region imports
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use app\models\Model;
use app\models\users\Cellule;
use app\models\projects\Project;
use app\models\parameters\DevisParameter;
use app\models\projects\ProjectSearch;
use app\models\projects\ProjectCreateTaskForm;
use app\models\projects\ProjectSimulate;
use app\models\projects\Risk;
use app\models\projects\Millestone;
use app\models\projects\Task;
use app\models\projects\forms\ProjectCreateThridStepForm;



use app\models\equipments\Equipment;
use app\models\laboratories\Laboratory;
use app\models\laboratories\LaboratoryContributor;
use app\models\projects\Consumable;
use app\models\projects\forms\ProjectCreateConsumableForm;
use app\models\projects\forms\ProjectCreateEquipmentRepaymentForm;
use app\models\projects\forms\ProjectCreateInvestForm;
use app\models\projects\forms\ProjectCreateFirstStepForm;
use app\models\projects\forms\ProjectCreateLaboratoryContributorForm;
use app\models\projects\forms\ProjectCreateLotForm;
use app\models\projects\forms\ProjectCreateRepaymentForm;
use app\models\projects\forms\ProjectCreateGestionTaskForm;
use app\models\projects\forms\ProjectCreateLotTaskForm;
use app\models\projects\forms\ProjectCreateMilleStoneForm;
use app\models\projects\Lot;
use app\models\projects\LotSimulate;
use app\services\laboxyServices\IdLaboxyManager;
use app\services\menuServices\MenuSelectorHelper;
use app\services\menuServices\SubMenuEnum;
use app\services\userRoleAccessServices\PermissionAccessEnum;
use app\services\userRoleAccessServices\UserRoleEnum;
use app\services\userRoleAccessServices\UserRoleManager;
use app\services\helpers\TimeStringifyHelper;
use kartik\mpdf\Pdf;
use yii\helpers\ArrayHelper;
#endregion

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
class ProjectController extends Controller implements ServiceInterface
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
                'only' => ['index', 'view', 'create', 'update', 'delete', 'update-status'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index'],
                        'roles' => [PermissionAccessEnum::PROJECT_INDEX],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['create'],
                        'roles' => [PermissionAccessEnum::PROJECT_CREATE],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['view'],
                        'roles' => [PermissionAccessEnum::PROJECT_VIEW],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['update'],
                        'roles' => [PermissionAccessEnum::PROJECT_UPDATE],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['delete'],
                        'roles' => [PermissionAccessEnum::PROJECT_DELETE],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['update-status'],
                        'roles' => [PermissionAccessEnum::PROJECT_UPDATE_STATUS],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['pdf'],
                        'roles' => [PermissionAccessEnum::PROJECT_PDF],
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
                UserRoleEnum::PROJECT_MANAGER,
                UserRoleEnum::CELLULE_MANAGER,
                UserRoleEnum::SUPPORT,
                UserRoleEnum::ADMIN,
                UserRoleEnum::SUPER_ADMIN
            ])
        ) {

            $result = [
                'priorite' => 3,
                'name' => 'Projets',
                // serviceMenuActive est à un moyen très peu efficace, je vais essayer de l'oter, j'ai fais ça car je savais pas trop comment gérer
                // les actives bar du menu à gauche.
                'serviceMenuActive' => SubMenuEnum::PROJECT,
                'items' => [
                    [
                        'Priorite' => 1,
                        'url' => 'project/index',
                        'label' => 'Liste des projets',
                        'subServiceMenuActive' => SubMenuEnum::PROJECT_LIST
                    ],
                    [
                        'Priorite' => 2,
                        'url' => 'project/index-draft',
                        'label' => 'Liste des brouillons',
                        'subServiceMenuActive' => SubMenuEnum::PROJECT_NONE
                    ],
                    [
                        'Priorite' => 3,
                        'url' => 'project/create-first-step',
                        'label' => 'Créer un projet',
                        'subServiceMenuActive' => SubMenuEnum::PROJECT_CREATE
                    ],
                    [
                        'Priorite' => 4,
                        'url' => 'project/lot-simulate',
                        'label' => 'Simulation  de lot',
                        'subServiceMenuActive' => SubMenuEnum::PROJECT_CREATE
                    ],
                    [
                        'Priorite' => 5,
                        'url' => 'project/project-simulate',
                        'label' => 'Simulation  Projet',
                        'subServiceMenuActive' => SubMenuEnum::PROJECT_CREATE
                    ],
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
        // Instanciation de la classe ProjectSearch qui va nous permettre d'utiliser la fonction search qui nous renvoie tous les projets.
        $searchModel = new ProjectSearch();
        // Nous aurons donc tous les models et en plus la possibilité d'ordonner ces données dans un gridview.
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        // Récupération des noms de companies des devis de manière distincte.
        $companiesName = array_unique(array_map(function ($value) {
            return $value->company->name;
        }, ProjectSearch::find('company.name')->all()));

        MenuSelectorHelper::setMenuProjectIndex();

        return $this->render('index', [
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
        MenuSelectorHelper::setMenuProjectNone();
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Render view : project/create.
     * Méthode en deux temps :
     * - Si pas de méthode POST de trouvé, retourne la vue de la création d'un devis.
     * - Sinon, à partir de la méthode POST, on récupère toutes les informations du nouvel devis rentrées, et suite à la vérification,
     * on les stocke en base de données.
     * 
     * @return mixed
     */
    public function actionCreate()
    {
    }

    /**
     * Render view : project/createView.
     * Méthode qui permet de prévisualiser les lots et tâches depuis la première partie de la création d'un projet.
     * Un tableau est rendu.
     * 
     * @return mixed
     */
    public function actionViewCreate()
    {
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

        MenuSelectorHelper::setMenuProjectNone();
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
    }

    /**
     * Utilisé pour modifier le devis d'un objet Devis.
     * On sauvgarde/modifie ensuite cet objet dans la base de données.
     * 
     * @param Devis Un objet devis dont on veut modifier le status.
     * @param integer Le type de status du devis à modifier.
     */
    private function setStatus(Project $model, int $status)
    {
        if ($model) {
            $model->status_id = $status;
            $model->save();
        }
    }

    /**
     * Utilisé pour télécharger le fichier uploadé d'un devis.
     * 
     * @param int $id
     */
    public function actionDownloadFile(int $id)
    {
        // $fileModel = UploadFile::getByDevis($id);

        // if ($fileModel != null) {
        //     $pathFile = $fileModel->name . '.' . $fileModel->type;
        //     UploadFileHelper::downloadFile($pathFile);
        // }
    }

    /**
     * Utilisé pour générer sous format excel les informations d'un devis.
     * 
     * @param int $id
     */
    public function actionDownloadExcel(int $id)
    {
        // $model = $this->findModel($id);
        // if ($model != null) ExcelExportService::exportModelDataToExcel($model, ExcelExportService::DEVIS_TYPE);
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
            'model' => $model
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

        Yii::$app->params['serviceMenuActive'] = SubMenuEnum::PROJECT;
        return $pdf->render();
    }

    /**
     * @deprecated Cette fonction n'est plus utilisé
     */
    public function actionViewpdf($id)
    {

        Yii::$app->params['serviceMenuActive'] = SubMenuEnum::PROJECT_NONE;

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

    /**
     *  Nouvelle route pour la création d'un projet sur l'application Capatool.
     *  Celle-ci retourne une vue et créer un brouillon du projet.
     *  Elle correspond à la première étape de la création d'un projet.
     * 
     *  @return mixed
     */
    public function actionCreateFirstStep()
    {
        $model = new ProjectCreateFirstStepForm();
        $lots =  [new ProjectCreateLotForm()];

        // Envoi par méthode POST.
        if ($model->load(Yii::$app->request->post())) {

            // Préparation de tous les modèles de lots reçu depuis la vue.
            $lots = Model::createMultiple(ProjectCreateLotForm::className(), $lots);
            Model::loadMultiple($lots, Yii::$app->request->post());

            // Vérification de la validité de chaque modèle de lot.
            $isLotsValid = true;
            foreach ($lots as $lot) {
                $lot->combobox_lot_checked = $model->combobox_lot_checked;
                if (!$lot->validate()) $isLotsValid = false;
            }

            // Si tous les modèles de lots et le modèle de projet sont valides.
            if ($model->validate() && $isLotsValid) {

                // Pré-remplissage des valeurs par défaut. Celle-ci seront complétés plus tard dans le projet.
                $defaultValue = "indéfini";
                $model->internal_reference = $defaultValue;
                $model->version = $defaultValue;
                $model->date_version = date('Y-m-d H:i:s');
                $model->creation_date = date('Y-m-d H:i:s');
                $model->id_capa = IdLaboxyManager::generateDraftId($model->internal_name);
                $model->state = Project::STATE_DRAFT;

                // On récupère l'id de la cellule de l'utilisateur connecté.
                $model->cellule_id = Yii::$app->user->identity->cellule_id;
                // On inclu la clé étragère qui référence une donnée indéfini dans la table company.
                $model->company_id = -1;
                // On inclu la clé étragère qui référence une donnée indéfini dans la table contact.
                $model->contact_id = -1;
                // On inclu la clé étragère qui référence une donnée indéfini dans la table capa_user.
                $model->capa_user_id = -1;
                $model->type = Project::TYPES[$model->combobox_type_checked];
                // On recopie le management rate
                $rate  = DevisParameter::getParameters();

                switch (Project::TYPES[$model->combobox_type_checked]) {
                    case  Project::TYPE_PRESTATION: {
                            $model->management_rate = $rate->rate_management;
                        }
                    case  Project::TYPE_OUTSOURCING_UN: {
                            $model->management_rate = $rate->rate_management;
                        }
                    case  Project::TYPE_OUTSOURCING_AD: {
                            $model->management_rate = $rate->delegate_rate_management;
                        }
                    case  Project::TYPE_INTERNAL: {
                            $model->management_rate = $rate->internal_rate_management;
                        }
                    default: {
                            $model->management_rate = $rate->rate_management;
                        }
                }

                $model->draft = true;
                $model->laboratory_repayment = ($model->combobox_repayment_checked == 1) ? true : false;

                // Sauvgarde du projet en base de données, permet de générer une clé primaire que l'on va utiliser pour ajouter le ou les lots.
                $model->save();

                // Création d'un lot d'avant-projet.
                $lotProspection = new Lot();
                $lotProspection->number = 0;
                $lotProspection->title = "Lot d'avant-projet";
                $lotProspection->status = Lot::STATE_IN_PROGRESS;
                $lotProspection->project_id = $model->id;
                $lotProspection->save();

                // Création des lots.
                // Création d'un lot par défaut si l'utilisateur ne souhaite pas créer son projet à partir d'une liste de lots.
                if ($lots[0]->combobox_lot_checked == 0) {
                    $lots = [new ProjectCreateLotForm()];
                    $lots[0]->title = 'Lot par défaut';
                    $lots[0]->comment = 'Ceci est un lot qui a été généré automatiquement car le créateur ne souhaitait pas utiliser plusieurs lots';
                }

                // Pour chaque lot, on lui attribut des valeurs par défaut.
                foreach ($lots as $key => $lot) {
                    $lot->number = $key + 1;
                    $lot->status = Lot::STATE_IN_PROGRESS;
                    $lot->project_id = $model->id;

                    $lot->save();
                }
                // On redirige vers la prochaine étape.
                Yii::$app->response->redirect(['project/task', 'number' => 0, 'project_id' => $model->id]);
            }
        }

        MenuSelectorHelper::setMenuProjectCreate();
        return $this->render(
            'createFirstStep',
            [
                'model' => $model,
                'lots' => $lots
            ]
        );
        $project = ProjectSimulate::getOneById(1);
        $lotavp = $project->getLotaventprojet();
        $lots = $project->lots;

        $millestones = [new ProjectCreateMilleStoneForm];
    }

    /**
     *  Nouvelle route pour la création de tâche d'un lot d'un projet sur l'application Capatool.
     *  Celle-ci retourne une vue et créer un brouillon du projet.
     *  Elle correspond à la première étape de la création d'un projet.
     * 
     *  @return mixed
     */
    public function actionTask($number, $project_id)
    {
        $model = new ProjectCreateTaskForm();
        $tasksGestions = [new ProjectCreateGestionTaskForm];
        $tasksOperational = [new ProjectCreateLotTaskForm];
        $risk = Risk::find()->all();
        $model->project_id = $project_id;
        $model->number = $number;

        //Recupération des membres de la cellule
        $idcellule = Yii::$app->user->identity->cellule_id;
        $cel = new Cellule();
        $cel->id = $idcellule;
        $celluleUsers = $cel->capaUsers;

        if ($model->load(Yii::$app->request->post())) {
            $isValid = true;

            if ($number != 0) {
                // Préparation de tous les modèles de Task de gestion
                $tasksGestions = Model::createMultiple(ProjectCreateGestionTaskForm::className(), $tasksGestions);
                Model::loadMultiple($tasksGestions, Yii::$app->request->post());

                if (!empty($tasksGestions)) {
                    $isValid = false;
                } else {
                    foreach ($tasksGestions as $taskGestions) {
                        if (!$taskGestions->validate()) {
                            $isValid = false;
                        }
                    }
                }
            }

            // Préparation de tous les modèles de Task operationel
            $tasksOperational = Model::createMultiple(ProjectCreateLotTaskForm::className(), $tasksOperational);
            Model::loadMultiple($tasksOperational, Yii::$app->request->post());


            foreach ($tasksOperational as $taskOperational) {
                if (!$taskOperational->validate()) {
                    $isValid = false;
                }
            }

            // Si tous les modèles de taches sont valides.
            if ($isValid) {

                // Création d'un lot d'avant-projet.
                $lot = $model->GetCurrentLot();

                // Pour chaque lot, on lui attribut des valeurs par défaut.
                foreach ($tasksGestions as $key => $taskGestions) {
                    $taskGestions->number = $key;
                    $taskGestions->lot_id = $lot->id;

                    $taskriskduration = risk::find(['title' => $taskGestions->risk])->one();
                    echo $taskriskduration->coefficient;
                    $taskGestions->risk_duration  = $taskriskduration->coefficient;
                    $taskGestions->task_category = task::CATEGORY_MANAGEMENT;
                    $taskGestions->save();
                }


                // Pour chaque lot, on lui attribut des valeurs par défaut.
                foreach ($tasksOperational as $key => $taskOperational) {
                    $taskOperational->number = $key;
                    $taskOperational->lot_id = $lot->id;


                    $taskriskduration = risk::find(['title' => $taskOperational->risk])->one();
                    echo $taskriskduration->coefficient;

                    $taskOperational->risk_duration  = $taskriskduration->coefficient;
                    $taskOperational->task_category = task::CATEGORY_TASK;
                    $taskOperational->save();
                }

                // On redirige vers la prochaine étape.
                Yii::$app->response->redirect(['project/create-third-step', 'number' => $number, 'project_id' => $project_id]);
            }
        }
        MenuSelectorHelper::setMenuProjectCreate();
        return $this->render(
            'createTask',
            [
                'model' => $model,
                'celluleUsers' => $celluleUsers,
                'tasksGestions' => (empty($tasksGestions)) ? [new ProjectCreateGestionTaskForm] : $tasksGestions,
                'tasksOperational' => (empty($tasksOperational)) ? [new ProjectCreateLotTaskForm] : $tasksOperational,
                'risk' => $risk,
            ]
        );
    }

    /**
     * Route : create-third-step
     * Permet de gérer la gestion des consomables et matériels utilisés pour un lot spécifique d'un projet.
     * 
     * @param integer $project_id : id du projet sur lequel se trouve le lot dans lequel on souhaite intégrer des éléments (matériels, intervenants ect...)
     * @param integer $number : numéro du lot sur lequel on souhaite intégrer des éléments (matériels, intervenants ect...)
     * 
     * @return mixed|error
     */
    public function actionCreateThirdStep($project_id = 0, $number = 0)
    {

        // Modèle du lot à updater. On s'en sert pour récupérer son id.
        $lot = Lot::getOneByIdProjectAndNumber($project_id, $number);

        if ($lot == null) {
            return $this->redirect([
                'error',
                'errorName' => 'Lot innexistant',
                'errorDescriptions' => ['Vous essayez actuellement de gérer une liste de matériels sur un lot qui n\'existe pas.']
            ]);
        }

        // Modèles à sauvegarder.
        $consumables = [new ProjectCreateConsumableForm()];
        $expenses = [new ProjectCreateInvestForm()];
        $equipmentsRepayment = [new ProjectCreateEquipmentRepaymentForm()];
        $contributors = [new ProjectCreateLaboratoryContributorForm()];
        $form = new ProjectCreateThridStepForm();
        // Import de données depuis la bdd.
        $cellule = Cellule::getOneById(Yii::$app->user->identity->cellule_id);
        $laboratoriesData = $cellule->laboratories;
        $equipmentsData = [new Equipment()];
        foreach ($laboratoriesData as $laboratory) {
            //   echo $laboratory->name;
            array_merge($equipmentsData, $laboratory->equipments);
        }

        $risksData = Risk::getAll();

        // Si renvoi de données par méthode POST sur l'élément unique, on va supposer que c'est un renvoi de formulaire.
        /* if ($repayment->load(Yii::$app->request->post())) {
            // Variable de vérification de validité des données lors du renvoi par méthode POST.
            $isValid = true;

            $consumables = Model::createMultiple(ProjectCreateConsumableForm::className(), $consumables);
            if (!Model::loadMultiple($consumables, Yii::$app->request->post())) $isValid = false;
            $expenses = Model::createMultiple(ProjectCreateExpenseForm::className(), $expenses);
            if (!Model::loadMultiple($expenses, Yii::$app->request->post())) $isValid = false;
            $equipmentsRepayment = Model::createMultiple(ProjectCreateEquipmentRepaymentForm::className(), $equipmentsRepayment);
            if (!Model::loadMultiple($equipmentsRepayment, Yii::$app->request->post())) $isValid = false;
            $contributors = Model::createMultiple(ProjectCreateLaboratoryContributorForm::className(), $contributors);
            if (!Model::loadMultiple($contributors, Yii::$app->request->post())) $isValid = false;

            /*  if ($isValid) {

                $repayment->lot_id = $lot->id;
                $repayment->laboratory_id = $laboratoriesData[$repayment->laboratorySelected]->id;
                $repayment->save();

                // On associe les consommables au lot actuel, puis on les sauvegardes.
                foreach ($consumables as $consumable) {
                    $consumable->lot_id = $lot->id;
                    $consumable->type = Consumable::TYPES[$consumable->type];
                    $consumable->save();
                }

                // On associe les consommables au lot actuel, puis on les sauvegardes.
                foreach ($expenses as $expense) {
                    $expense->lot_id = $lot->id;
                    $expense->save();
                }

                // On récupère la liste de matériels lié au choix du labo fait précédement. Utilisé pour récupérer le bon matériel sélectionné.
                $id_laboratory = $repayment->laboratory_id;
                $equipmentsDataFilteredByLabo = array_values(
                    array_filter($equipmentsData, function ($equipment) use ($id_laboratory) {
                        return ($equipment->laboratory_id == $id_laboratory);
                    })
                );

                // On associe les matériels au lot actuel, puis on les sauvegardes.
                foreach ($equipmentsRepayment as $equipmentRepayment) {
                    $equipmentRepayment->equipment_id = $equipmentsDataFilteredByLabo[$equipmentRepayment->equipmentSelected]->id;
                    $equipmentRepayment->repayment_id = $repayment->id;
                    $equipmentRepayment->risk_id = $equipmentRepayment->riskSelected + 1;
                    $equipmentRepayment->time_risk = TimeStringifyHelper::transformStringChainToHour($equipmentRepayment->timeRiskStringify);
                    $equipmentRepayment->save();
                }

                // On associe les intervenants de laboratoire au lot actuel, puis ont les sauvegardes.
                foreach ($contributors as $contributor) {
                    $contributor->type = LaboratoryContributor::TYPES[$contributor->type];
                    $contributor->laboratory_id = $id_laboratory;
                    $contributor->repayment_id = $repayment->id;
                    $contributor->risk_id = $contributor->riskSelected + 1;
                    $contributor->time_risk = TimeStringifyHelper::transformStringChainToHour($contributor->timeRiskStringify);
                    $contributor->save();
                }
                Yii::$app->response->redirect(['project/lot-simulate', 'project_id' => $project_id]);
            }
        
        }*/

        MenuSelectorHelper::setMenuProjectNone();
        return $this->render(
            'createThirdStep',
            [
                'number' => $number,
                'laboratoriesData' => $laboratoriesData,
                'equipmentsData' => $equipmentsData,
                'risksData' => $risksData,
                'consumables' => $consumables,
                'formulaire' =>  $form,
                'expenses' => $expenses,
                'equipments' => $equipmentsRepayment,
                'contributors' => $contributors
            ]
        );
    }

    /**
     * Route : create-lot-simulate
     * Permet de modifier les marges d'un lot
     * 
     * @param integer $project_id : id du projet sur lequel se trouve le lot dans lequel on souhaite intégrer des éléments (matériels, intervenants ect...)
     * @param integer $number : numéro du lot sur lequel on souhaite intégrer des éléments (matériels, intervenants ect...)
     * 
     * @return mixed|error
     */
    public function actionLotSimulate($project_id = 1, $number = 1)
    {

        // Modèle du lot à updater. On s'en sert pour récupérer son id.
        $lot = LotSimulate::getOneByIdProjectAndNumber($project_id, $number);

        if ($lot == null) {
            return $this->redirect([
                'error',
                'errorName' => 'Lot innexistant',
                'errorDescriptions' => ['Vous essayez actuellement de modifier un lot qui n\'existe pas.']
            ]);
        }


        // Modèles à sauvegarder.
        $lotsimulation = new LotSimulate();

        // Si renvoi de données par méthode POST sur l'élément unique, on va supposer que c'est un renvoi de formulaire.
        if ($lotsimulation->load(Yii::$app->request->post())) {

            $lotsimulation->save();

            $millestones = [new ProjectCreateConsumableForm()];
            $project = $lot->project;
            $ListeLot = $project->lots;
            $number++;
            if ($number == $project->nblot) {
                // On redirige vers la prochaine étape.
                Yii::$app->response->redirect(['project/project-simulate', 'project_id' => $project_id]);
            } else {
                // On redirige vers la prochaine étape.
                Yii::$app->response->redirect(['project/task', 'number' => $number, 'project_id' => $project_id]);
            }
        }

        MenuSelectorHelper::setMenuProjectNone();
        return $this->render(
            'lotSimulation',
            [
                'lot' =>  $lot
            ]

        );
    }

    /**
     * Route : create-lot-simulate
     * Permet de modifier les marges d'un lot
     * 
     * @param integer $project_id : id du projet sur lequel se trouve le lot dans lequel on souhaite intégrer des éléments (matériels, intervenants ect...)
     * @param integer $number : numéro du lot sur lequel on souhaite intégrer des éléments (matériels, intervenants ect...)
     * 
     * @return mixed|error
     */
    public function actionProjectSimulate($project_id = 1)
    {

        // Modèle du projet à updater. On s'en sert pour récupérer son id.
        $project = Project::getOneById($project_id);
        $lotavp = $project->lotaventprojet;
        $lots = $project->lots;
        $millestones = $project->millestones;
        if ($project == null) {
            return $this->redirect([
                'error',
                'errorName' => 'projet innexistant',
                'errorDescriptions' => ['Vous essayez actuellement de modifier un projet qui n\'existe pas.']
            ]);
        }


        // Modèles à sauvegarder.
        $projetsimulation = new ProjectSimulate();

        // Si renvoi de données par méthode POST sur l'élément unique, on va supposer que c'est un renvoi de formulaire.
        if ($projetsimulation->load(Yii::$app->request->post())) {

            $projetsimulation->save();

            $millestones = [new ProjectCreateMilleStoneForm()];
            $project = $lot->project;
            $ListeLot = $project->lots;
        }

        MenuSelectorHelper::setMenuProjectNone();
        return $this->render(
            'projectSimulation',
            [
                'project' =>  $project,
                'lotavp' => $lotavp,
                'lots' => $lots,
                'millestones' => (empty($millestones)) ? [new ProjectCreateMilleStoneForm()] : $millestones,
            ]

        );
    }


    /**
     * A faire.
     */
    public function actionUpdateTask($number, $project_id)
    {
    }

    /**
     * Route : index-draft
     * Permet d'afficher la liste des tous les brouillons, c'est-à-dire les devis qui n'ont pas été finalisés.
     * 
     * @return mixed|error
     */
    public function actionIndexDraft()
    {
        // Instanciation de la classe ProjectSearch qui va nous permettre d'utiliser la fonction search qui nous renvoie tous les projets. 
        // Nous récupérerons les brouillons à l'aide une option.
        $searchModel = new ProjectSearch();
        // Nous aurons donc tous les models et en plus la possibilité d'ordonner ces données dans un gridview.
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, ProjectSearch::GET_DRAFT_QUERY_OPTION);

        MenuSelectorHelper::setMenuProjectNone();
        return $this->render(
            'index-draft',
            [
                'dataProvider' => $dataProvider
            ]
        );
    }

    /**
     * Route : update-first-step
     * Retourne la vue de la première étape de la création d'un projet. On utilise celle-ci pour modifier un projet existant.
     * Les modifications sur cette vue concernent : Le titre, les lots (à ôter, un lot ne doit pas être détruisable).
     * Cette vue va probablement ne plus servir à grand chose.
     */
    public function actionUpdateFirstStep(int $id)
    {
        // Récupération du projet brouillon.
        $model = ProjectCreateFirstStepForm::getOneById($id);
        $lots = ProjectCreateLotForm::getAllByIdProject($id);

        // Check si il y a bien plus d'un lot attaché au projet (un lot d'avant-projet et un lot principal).
        if (count($lots) <= 1) {
            return $this->redirect([
                'error',
                'errorName' => 'Incohérence de lot',
                'errorDescriptions' => [
                    "Le projet que vous essayer de modifier présente une incohérence au niveau des lots.",
                    "Il devrait avoir un nombre de lots supérieur ou égale à 2 or ce n'est pas le cas ici."
                ]
            ]);
        }

        // Retire le lot n°0 qui correspond à l'avant-projet.
        unset($lots[0]);
        $lots = array_values($lots);

        if ($lots[0]->title == "Lot par défaut") $model->combobox_lot_checked = 0;
        else $model->combobox_lot_checked = 1;

        switch ($model->type) {
            case Project::TYPE_PRESTATION:
                $model->combobox_type_checked = 0;
                break;
            case Project::TYPE_OUTSOURCING_AD:
                $model->combobox_type_checked = 1;
                break;
            case Project::TYPE_OUTSOURCING_UN:
                $model->combobox_type_checked = 2;
                break;
            case Project::TYPE_INTERNAL:
                $model->combobox_type_checked = 3;
                break;
        }


        // Envoi par méthode POST.
        if ($model->load(Yii::$app->request->post())) {

            // Préparation de tous les modèles de lots reçu depuis la vue.
            $oldIds = ArrayHelper::map($lots, 'id', 'id');
            $lots = Model::createMultiple(ProjectCreateLotForm::className(), $lots);
            Model::loadMultiple($lots, Yii::$app->request->post());
            $deletedIDs = array_diff($oldIds, array_filter(ArrayHelper::map($lots, 'id', 'id')));

            // Vérification de la validité de chaque modèle de lot.
            $isLotsValid = true;
            foreach ($lots as $lot) {
                $lot->combobox_lot_checked = $model->combobox_lot_checked;
                if (!$lot->validate()) $isLotsValid = false;
            }

            // Si tous les modèles de lots et le modèle de projet sont valides.
            if ($model->validate() && $isLotsValid) {

                // On met à jour la date de modification.
                $model->date_version = date('Y-m-d H:i:s');

                // On met à jour le type de projet.
                $model->type = Project::TYPES[$model->combobox_type_checked];

                // On met à jour l'option labo.
                $model->laboratory_repayment = ($model->combobox_repayment_checked == 1) ? true : false;

                // On récupère les paramètres de taux de gestion pour les appliquer au projet en cours de modification.
                $rate  = DevisParameter::getParameters();
                switch (Project::TYPES[$model->combobox_type_checked]) {
                    case  Project::TYPE_PRESTATION: {
                            $model->management_rate = $rate->rate_management;
                        }
                    case  Project::TYPE_OUTSOURCING_UN: {
                            $model->management_rate = $rate->rate_management;
                        }
                    case  Project::TYPE_OUTSOURCING_AD: {
                            $model->management_rate = $rate->delegate_rate_management;
                        }
                    case  Project::TYPE_INTERNAL: {
                            $model->management_rate = $rate->internal_rate_management;
                        }
                    default: {
                            $model->management_rate = $rate->rate_management;
                        }
                }

                // Sauvgarde du projet en base de données, permet de générer une clé primaire que l'on va utiliser pour ajouter le ou les lots.
                $model->save();

                // Création des lots.
                // Si il a été décidé que ce projet ne devait plus avoir de lot, on récupère le lot n°1 pour en faire un lot par défaut.
                if ($lots[0]->combobox_lot_checked == 0) {
                    $lots = [$lots[0]];
                    $lots[0]->title = 'Lot par défaut';
                    $lots[0]->comment = 'Ceci est un lot qui a été généré automatiquement car le créateur ne souhaitait pas utiliser plusieurs lots';
                }

                // Suppression des lots dans la bdd.
                if (!empty($deletedIDs)) {
                    Lot::deleteAll(['id' => $deletedIDs]);
                }

                // Pour chaque lot, on lui attribut des valeurs par défaut.
                foreach ($lots as $key => $lot) {
                    $lot->number = $key + 1;
                    $lot->status = Lot::STATE_IN_PROGRESS;
                    $lot->project_id = $model->id;

                    $lot->save();
                }
                // On redirige vers la prochaine étape.
                //Yii::$app->response->redirect(['project/task', 'number' => 0, 'project_id' => $model->id]);
            }
        }

        MenuSelectorHelper::setMenuProjectNone();
        return $this->render(
            'createFirstStep',
            [
                'model' => $model,
                'lots' => $lots
            ]
        );
    }

    public function actionUpdateThirdStep($project_id, $number)
    {
        // Modèle du lot à updater. On s'en sert pour récupérer son id.
        $lot = Lot::getOneByIdProjectAndNumber($project_id, $number);

        if ($lot == null) {
            return $this->redirect([
                'error',
                'errorName' => 'Lot innexistant',
                'errorDescriptions' => ['Vous essayez actuellement de modifier une liste de matériels sur un lot/projet qui n\'existe pas.']
            ]);
        }

        // Récupérer les données existantes du lot spécifié en paramètre.
        $repayment = ProjectCreateRepaymentForm::getOneByLotID($lot->id);
        $consumables =  ProjectCreateConsumableForm::getAllConsummablesByLotID($lot->id);
        $expenses = ProjectCreateExpenseForm::getAllExpensesByLotID($lot->id);
        $equipmentsRepayment = ProjectCreateEquipmentRepaymentForm::getAllByRepaymentID($repayment->id);
        $contributors = ProjectCreateLaboratoryContributorForm::getAllByLaboratoryID($repayment->laboratory_id);

        // Import de données depuis la bdd.
        $laboratoriesData = Laboratory::getAll();
        $equipmentsData = Equipment::getAll();
        $risksData = Risk::getAll();

        MenuSelectorHelper::setMenuProjectNone();
        return $this->render(
            'createThirdStep',
            [
                'number' => $number,
                'laboratoriesData' => $laboratoriesData,
                'equipmentsData' => $equipmentsData,
                'risksData' => $risksData,
                'repayment' => $repayment,
                'consumables' => $consumables,
                'expenses' => $expenses,
                'equipments' => $equipmentsRepayment,
                'contributors' => $contributors
            ]
        );
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
        if (($model = Project::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Le devis n\'existe pas.');
    }

    /**
     * Fonction qui rend une page d'erreur.
     * @param string $errorName - Le titre de l'erreur que vous souhaitez afficher.
     * @param array $errorDescription - Une liste de chaîne de caractères avec des détails précis sur l'erreur en question.
     */
    public function actionError(string $errorName, array $errorDescriptions)
    {
        MenuSelectorHelper::setMenuProjectNone();
        return $this->render(
            'error',
            [
                'errorName' => $errorName,
                'errorDescriptions' => $errorDescriptions
            ]
        );
    }

    /**
     * @deprecated Cette fonction n'est plus utilisé
     */
    public static function getIndicator($user)
    {
    }
}
