<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

use app\components\ExcelExportService;
use app\models\Model;
use app\models\files\UploadFile;
use app\models\users\Cellule;
use app\models\projects\Project;
use app\models\parameters\DevisParameter;
use app\models\projects\ProjectSearch;
use app\models\projects\ProjectUpdateForm;
use app\models\projects\ProjectCreateForm;
use app\models\users\CapaUser;
use app\models\companies\Contact;
use app\models\companies\Company;
use app\models\projects\Lot;
use app\models\projects\LotCreateFirstStepForm;
use app\models\projects\ProjectCreateFirstStepForm;
use app\models\projects\ProjectCreateTaskForm;
use app\models\projects\Risk;
use app\models\projects\Task;
use app\models\projects\TaskGestionCreateTaskForm;
use app\models\projects\TaskLotCreateTaskForm;
use app\services\menuServices\MenuSelectorHelper;
use app\services\menuServices\SubMenuEnum;
use app\services\uploadFileServices\UploadFileHelper;
use app\services\userRoleAccessServices\PermissionAccessEnum;
use app\services\userRoleAccessServices\UserRoleEnum;
use app\services\userRoleAccessServices\UserRoleManager;
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
                        'Priorite' => 3,
                        'url' => 'project/index',
                        'label' => 'Liste des projets',
                        'subServiceMenuActive' => SubMenuEnum::PROJECT_LIST
                    ],
                    [
                        'Priorite' => 2,
                        'url' => 'project/create-first-step',
                        'label' => 'Créer un projet',
                        'subServiceMenuActive' => SubMenuEnum::PROJECT_CREATE
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
        // Instanciation de la classe ProjectSearch qui va nous permettre d'utiliser sa fonction search qui nous renvoie tous les projets.
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

        $model = new ProjectCreateForm();

        // On récupère tous les clients pour la liste déroulantes.
        $companiesNames = ArrayHelper::map(Company::find()->all(), 'id', 'name');
        $companiesNames = array_merge($companiesNames);

        // On récupère tous les clients pour la liste déroulantes.
        $contactsNames = ArrayHelper::map(Contact::find()->all(), 'id', ['surname', 'firstname']);
        $contactsNames = array_merge($companiesNames);

        // Validation du devis depuis la vue de création.
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
        }

        MenuSelectorHelper::setMenuProjectCreate();
        return $this->render(
            'create',
            [
                'model' => $model,
                'companiesNames' => $companiesNames,
                'contactsNames' => $contactsNames
            ]
        );
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

        // Get the models values from devis.
        $model =  ProjectUpdateForm::findOne($id);
        $model->company_name = $model->company->name;

        // Get file model.
        $fileModel = new UploadFile();

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

                // Load contributors into model.
                Model::loadMultiple($contributors, Yii::$app->request->post());

                // Get the company data with name insert in field.
                $company = Company::find()->where(['name' =>  $model->company_name])->one();

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

                MenuSelectorHelper::setMenuProjectNone();
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        MenuSelectorHelper::setMenuProjectNone();
        return $this->render(
            'update',
            [
                'model' => $model,
                'companiesNames' => $companiesNames,
                'usersNames' => $usersNames,
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
        $model = $this->findModel($id);

        if (
            UserRoleManager::hasRoles([
                UserRoleEnum::OPERATIONAL_MANAGER_DEVIS,
                UserRoleEnum::ACCOUNTING_SUPPORT_DEVIS
            ])
        ) $this->setStatus($model, $status);


        MenuSelectorHelper::setMenuProjectNone();
        return $this->render('view', [
            'model' => $this->findModel($id),
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

        Yii::$app->params['serviceMenuActive'] = SubMenuEnum::DEVIS;
        return $pdf->render();
    }

    /**
     * //TODO
     * Render view : null
     * Retournera une vue avec la liste de tous les affaires.
     * Dans les faits, cette vue aura pratiquement la même structure que la vue de la liste des devis/projets.
     * Un sous menu doit permettre de lancer cette route.
     * 
     * @return mixed
     * @throws NotFoundHttpException If the model is not found.
     */
    public function actionIndexBusiness()
    {
    }

    /**
     * //TODO
     * Render view : null
     * Retournera une vue avec la liste de tous les projets d'une affaire..
     * 
     * @return mixed
     * @throws NotFoundHttpException If the model is not found.
     */
    public function actionViewBusiness(int $id)
    {
    }

    /**
     * //TODO
     * Render view : null
     * Retournera une vue permettant de créer une affaire.
     *Le formulaire ne sera pas très complexe, un champ pour indiquer le nom du client et c'est tout.
     * 
     * @return mixed
     * @throws NotFoundHttpException If the model is not found.
     */
    public function actionCreateBusiness()
    {
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
     * @deprecated Cette fonction n'est plus utilisé
     */
    public static function getIndicator($user)
    {
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
        $lots =  [new LotCreateFirstStepForm()];

        // Envoi par méthode POST.
        if ($model->load(Yii::$app->request->post())) {

            // Préparation de tous les modèles de lots reçu depuis la vue.
            $lots = Model::createMultiple(LotCreateFirstStepForm::className(), $lots);
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
                $model->id_capa = $defaultValue;
                $model->internal_name = $defaultValue;
                $model->internal_reference = $defaultValue;
                $model->state = $defaultValue;
                $model->version = $defaultValue;
                $model->date_version = date('Y-m-d H:i:s');
                $model->creation_date = date('Y-m-d H:i:s');
                $model->id_capa = $defaultValue;

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
                $lotProscription = new Lot();
                $lotProscription->number = 0;
                $lotProscription->title = "Lot d'avant-projet";
                $lotProscription->status = Lot::STATE_IN_PROGRESS;
                $lotProscription->project_id = $model->id;
                $lotProscription->save();

                // Création des lots.
                // Création d'un lot par défaut si l'utilisateur ne souhaite pas créer son projet à partir d'une liste de lots.
                if ($lots[0]->combobox_lot_checked == 0) {
                    $lots = [new LotCreateFirstStepForm()];
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
        $tasksGestions = [new TaskGestionCreateTaskForm];
        $tasksOperational = [new TaskLotCreateTaskForm];
        $risk = risk::find()->all();
        $model->project_id = $project_id;
        $model->number = $number;

        //Recupération des membres de la cellule
        $idcellule = Yii::$app->user->identity->cellule_id;
        $cel = new Cellule();
        $cel->id = $idcellule;
        $celluleUsers = $cel->capaUser;
        if ($model->load(Yii::$app->request->post())) {
            echo 'modelvalid';
            $isValid = true;
            if ($number != 0) {
                // Préparation de tous les modèles de Task de gestion
                $tasksGestions = Model::createMultiple(TaskGestionCreateTaskForm::className(), $tasksGestions);
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
            $tasksOperational = Model::createMultiple(TaskLotCreateTaskForm::className(), $tasksOperational);
            Model::loadMultiple($tasksOperational, Yii::$app->request->post());


            foreach ($tasksOperational as $taskOperational) {
                if (!$taskOperational->validate()) {
                    $isValid = false;
                }
            }


            // Si tous les modèles de taches sont valides.
            if ($isValid) {
                echo 'task  valid';

                // Création d'un lot d'avant-projet.
                $lot = $model->GetCurrentLot();

                // Pour chaque lot, on lui attribut des valeurs par défaut.
                foreach ($tasksGestions as $key => $taskGestions) {
                    $taskGestions->number = $key;
                    $taskGestions->lot_id = $lot->id;

                    $taskriskduration = risk::find(['title' => $taskGestions->risk])->one();
                    echo $taskriskduration->coeficient;
                    $taskGestions->risk_duration  = $taskriskduration->coeficient;
                    $taskGestions->task_category = task::CATEGORY_MANAGEMENT;
                    $taskGestions->save();
                }


                // Pour chaque lot, on lui attribut des valeurs par défaut.
                foreach ($tasksOperational as $key => $taskOperational) {
                    $taskOperational->number = $key;
                    $taskOperational->lot_id = $lot->id;


                    $taskriskduration = risk::find(['title' => $taskOperational->risk])->one();
                    echo $taskriskduration->coeficient;

                    $taskOperational->risk_duration  = $taskriskduration->coeficient;
                    $taskOperational->task_category = task::CATEGORY_TASK;
                    $taskOperational->save();
                }

                /////TODO SACHA 
                ///redirect du lien
            }
        }
        MenuSelectorHelper::setMenuProjectCreate();
        return $this->render(
            'createTask',
            [
                'model' => $model,
                'celluleUsers' => $celluleUsers,
                'tasksGestions' => (empty($tasksGestions)) ? [new TaskGestionCreateTaskForm] : $tasksGestions,
                'tasksOperational' => (empty($tasksOperational)) ? [new TaskLotCreateTaskForm] : $tasksOperational,
                'risk' => $risk,

            ]
        );
    }
}
