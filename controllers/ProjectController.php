<?php

namespace app\controllers;

#region imports

use app\models\companies\Company;
use app\models\companies\Contact;
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

use yii\web\UploadedFile;

use app\models\equipments\Equipment;
use app\models\equipments\EquipmentRepayment;
use app\models\laboratories\Laboratory;
use app\models\laboratories\LaboratoryContributor;
use app\models\projects\Consumable;
use app\models\projects\forms\ProjectCreateConsumableForm;
use app\models\projects\forms\ProjectCreateEquipmentRepaymentForm;
use app\models\projects\forms\ProjectCreateInvestForm;
use app\models\projects\forms\ProjectCreateFirstStepForm;
use app\models\projects\forms\ProjectCreateForm;
use app\models\projects\forms\ProjectCreateLaboratoryContributorForm;
use app\models\projects\forms\ProjectCreateLotForm;
use app\models\projects\forms\ProjectCreateGestionTaskForm;
use app\models\projects\forms\ProjectCreateLotTaskForm;
use app\models\projects\forms\ProjectCreateMilleStoneForm;
use app\models\projects\forms\ProjectCreateThirdStepForm;
use app\models\projects\Investment;
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
use phpDocumentor\Reflection\Types\Array_;
use yii\helpers\ArrayHelper;
#endregion

/**
 * Classe contrôleur des vues et des actions de la partie projet/devis.
 * Attention au nom du contrôleur, il détermine le point d'entré de la route.
 * ex : pour notre contrôleur ProjetController -> projet/[*]
 * 
 * Chaque route généré par le controller provient des fonctions dont le nom commence par action******.
 * ex : actionIndex donnera la route suivante -> devis/index
 * ex : actionIndexDetails donnera la route suivante -> devis/index-details.
 * 
 * @version Capatools v2.0.6
 * @since Classe existante depuis la Release v2.0.0
 */
class ProjectController extends Controller implements ServiceInterface
{

    /**
     * Utilisé pour déterminer les droits sur chaque action du contrôleur.
     * Dans la clé "rules", on défini un ou plusieurs rôles à une action du contrôleur.
     * 
     * On utilise une classe d'énumération pour les noms de rôle pour éviter des erreurs de code : PermissionAccessEnum.
     * 
     * @return array Un tableau de règles de comportements.
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
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
     * - priorité : L'ordre de priorité de position du menu Projet.
     * - name : Texte du menu Projet.
     * - serviceMenuActive : Paramètre utilisé pour permettre de déplier le menu Devis lorsque l'utilisateur est actuellement sur une vue Devis.
     * - items : Les sous-menus.
     * 
     * @return Array Un tableau de données relatif au menu Devis.
     */
    public static function getActionUser()
    {
        $result = [];
        if (UserRoleManager::hasRoles([
            UserRoleEnum::PROJECT_MANAGER,
            UserRoleEnum::CELLULE_MANAGER,
            UserRoleEnum::SUPPORT,
            UserRoleEnum::ADMIN,
            UserRoleEnum::SUPER_ADMIN
        ])) {

            $result = [
                'priorite' => 3,
                'name' => 'Projets',
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
                        'subServiceMenuActive' => SubMenuEnum::PROJECT_DRAFT
                    ],
                    [
                        'Priorite' => 3,
                        'url' => 'project/create-first-step',
                        'label' => 'Création d\'un devis',
                        'subServiceMenuActive' => SubMenuEnum::PROJECT_CREATE
                    ]
                ]
            ];
        }

        return $result;
    }

    /**
     * Render view : projet/index
     * Retourne la vue de l'index Devis.
     * Liste de tous les projets présent dans la base de données qui ne sont pas à l'état de brouillon.
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
     * Route : projet/index-draft
     * Permet d'afficher la liste des tous les brouillons, c'est-à-dire les devis qui n'ont pas été finalisés, qui sont à l'état de brouillon.
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

        MenuSelectorHelper::setMenuProjectDraft();
        return $this->render(
            'index-draft',
            [
                'dataProvider' => $dataProvider
            ]
        );
    }

    /**
     * Render view : project/view?id=?
     * Retourne la vue détaillé d'un projet par rapport à l'id rentré en paramètre.
     * @param integer $id
     * 
     * @return mixed
     * @throws NotFoundHttpException If the model is not found.
     */
    public function actionView(int $id)
    {
        MenuSelectorHelper::setMenuProjectIndex();
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Render view : none
     * Redirected view : project/view?id=?.
     * Modifie le status d'un projet. Si le projet est signé, sa proba de signature passe à 100%.
     * @param integer $id
     * @param integer $status Static value of DevisStatus
     * 
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdateStatus($id, $status)
    {
        $project = project::getOneById($id);
        $project->state = $status;

        if (Project::STATE_DEVIS_SIGNED || Project::STATE_FINISHED) {
            $project->signing_probability = 100;
            $project->id_laboxy = IdLaboxyManager::generateLaboxyId($project);
        }


        $project->save();

        MenuSelectorHelper::setMenuProjectNone();
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Render view : none
     * Redirected view : project/view?id=?.
     * Modifie le status d'un jalon d'un projet.
     * @param integer $id
     * @param String $status Static value of DevisStatus
     * 
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdateMillestoneStatus($id, $status)
    {
        $jalon = Millestone::getOneById($id);
        $jalon->statut = $status;
        $jalon->save();

        MenuSelectorHelper::setMenuProjectIndex();
        return $this->render('view', [
            'model' => $this->findModel($jalon->project_id),
        ]);
    }

    /**
     * Render view : devis/pdf?id=?
     * Permet de générer une vue html sous format pdf des informations d'un devis, permet aussi de le télécharger.
     * @param integer $id
     * 
     * @return mixed
     * @throws NotFoundHttpException If the model is not found.
     */
    public function actionPdf(int $id)
    {

        $model = $this->findModel($id);

        $css = [
            '' . Yii::getAlias('@web') . 'css/materialize_pdf.min.css',
            '' . Yii::getAlias('@web') . 'css/projects/pdf.css'
        ];

        $filename = $model->internal_name . '_pdf_' . date("r");

        $content = $this->renderPartial('pdf', [
            'model' => $model
        ]);

        $pdf = new Pdf([
            'mode' => Pdf::MODE_CORE,
            'format' => Pdf::FORMAT_TABLOID,
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

        MenuSelectorHelper::setMenuProjectNone();
        return $pdf->render();
    }

    // /!\ CREATION DE DEVIS-PROJET /!\

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

        $companiesNames = ArrayHelper::map(Company::find()->all(), 'id', 'name');
        $companiesNames = array_merge($companiesNames);
        unset($companiesNames[0]); // On supprime la première company qui représente la company "indéfini".

        $contactsEmail = ArrayHelper::map(Contact::find()->all(), 'id', 'email');
        $contactsEmail = array_merge($contactsEmail);
        unset($contactsEmail[0]); // On supprime le premier contact qui est en "indéfini".

        // Envoi par méthode POST.
        if ($model->load(Yii::$app->request->post())) {

            // Préparation de tous les modèles de lots reçu depuis la vue.
            $lots = Model::createMultiple(ProjectCreateLotForm::class, $lots);
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
                $model->internal_reference = $model->internal_name;
                $model->version = $defaultValue;
                $model->date_version = date('Y-m-d H:i:s');
                $model->creation_date = date('Y-m-d H:i:s');
                $model->id_capa = IdLaboxyManager::generateDraftId($model);
                $model->id_laboxy = IdLaboxyManager::generateLaboxyDraftId($model);
                $model->state = Project::STATE_DRAFT;

                // On récupère l'id de la cellule de l'utilisateur connecté.
                $model->cellule_id = Yii::$app->user->identity->cellule_id;
                // On inclu la clé étragère qui référence une donnée indéfini dans la table company.
                $model->company_id = Company::getOneByName($model->company_name)->id;
                // On inclu la clé étragère qui référence une donnée indéfini dans la table contact.
                $model->contact_id = Contact::getOneByEmail($model->contact_email)->id;
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
                Yii::$app->response->redirect(['project/project-simulate', 'project_id' => $model->id]);
            }
        }

        MenuSelectorHelper::setMenuProjectCreate();
        return $this->render(
            'createFirstStep',
            [
                'model' => $model,
                'lots' => $lots,
                'companiesNames' => \array_values($companiesNames),
                'contactsEmail' => \array_values($contactsEmail)
            ]
        );
    }

    /**
     * Route : project/project-simulate.
     * Action qui renvoie vers la page de simulation de projet, c'est à partir de la vue retourné par cette action que l'on peut 
     * modifier les tâches, investissements ect d'un projet brouillon.
     * @param integer $project_id : id du projet.
     * 
     * @return mixed|error
     */
    public function actionProjectSimulate($project_id = 1)
    {

        // Modèle du projet à updater. On s'en sert pour récupérer son id.
        $project = ProjectSimulate::getOneById($project_id);
        if ($project == null) {
            return $this->redirect([
                'error',
                'errorName' => 'projet innexistant',
                'errorDescriptions' => ['Vous essayez actuellement de modifier un projet qui n\'existe pas.']
            ]);
        }

        $validdevis = true;
        $lotavp = $project->lotaventprojet;
        $lots = $project->lots;
        $millestones = $project->millestones;



        // Modèles à sauvegarder.

        if ($project->load(Yii::$app->request->post())) {
            $project->save();
        }
        // Si renvoi de données par méthode POST sur l'élément unique, on va supposer que c'est un renvoi de formulaire.
        $millestonesModif = [new ProjectCreateMilleStoneForm()];
        $millestonesModif =  Model::createMultiple(ProjectCreateMilleStoneForm::className(), $millestonesModif);
        $isValid = true;
        Model::loadMultiple($millestonesModif, Yii::$app->request->post());
        if (!empty($millestonesModif)) {

            foreach ($millestonesModif as $Millestone) {
                if (!$Millestone->validate()) {
                    $isValid = false;
                }
            }
        } else {
            $isValid = false;
        }
        // Si tous les Jalons sont valides
        if ($isValid) {

            $MillestoneArray = ArrayHelper::index($millestones,  function ($element) {
                return $element->number;
            });
            $millestonesModifArray = ArrayHelper::index($millestonesModif,   function ($element) {
                return $element->number;
            });
            //Suppression des tâches enlevées par l'utilisateur;
            foreach ($MillestoneArray as $Millestone) {

                if (!array_key_exists($Millestone->number, $millestonesModifArray)) {
                    $Millestone->delete();
                }
            }
            //Ajout et modification des données.
            foreach ($millestonesModif as $millestoneModif) {
                $millestoneNew = null;

                if (!empty($MillestoneArray)) {
                    if (array_key_exists(intval($millestoneModif->number), $MillestoneArray)) {
                        //Si la tâche existe MAJ de la tâche
                        $millestoneNew =  $MillestoneArray[$millestoneModif->number];
                    } else {
                        //Si elle n'existe pas alors ajout de la tâche
                        $millestoneNew = new ProjectCreateMilleStoneForm();
                        $millestoneNew->number = $millestoneModif->number;
                    }
                } else {
                    //Si elle n'existe pas alors ajout de la tâche
                    $millestoneNew = new ProjectCreateMilleStoneForm();
                    $millestoneNew->number = $millestoneModif->number;
                }

                $millestoneNew->comment = $millestoneModif->comment;
                $millestoneNew->project_id = $project->id;
                $millestoneNew->pourcentage = $millestoneModif->pourcentage;
                $millestoneNew->price = $millestoneModif->price;
                $millestoneNew->statut = Millestone::STATUT_ENCOURS;
                $millestoneNew->save();
            }
        }

        $millestones = ProjectCreateMilleStoneForm::getAllByProject($project->id);

        if (count($millestones) == 0  &&  $project->SellingPrice > 2000) {
            $advancepayement = new  ProjectCreateMilleStoneForm();
            $advancepayement->number = 0;
            $advancepayement->comment = "Acompte";
            $advancepayement->pourcentage = 30.0;
            $advancepayement->price = (30.0 / 100) * $project->SellingPrice;
            array_push($millestones, $advancepayement);
        }

        //check validity of the devis
        //1 A least for each lot TotalCostHuman != 0
        foreach ($lots as $lot) {
            if ($lot->totalCostHuman == 0) {
                $validdevis = false;
                break;
            }
        }


        $laborarydepenses = array();

        $resultatLaboColabborator =  $project->coutlaboratoire;

        //Je parcour la maps des données
        foreach ($resultatLaboColabborator as $Labo) {
            $couttotal = 0;
            $laboid = $Labo[0]->id;
            foreach ($Labo as $l) {
                $couttotal = $couttotal + $l->total;
            }
            $laborarydepenses = $laborarydepenses + array($laboid => array('labo_id' => $laboid, 'total' => $couttotal));
        }


        $resultatLaboEquipement = $project->coutequipementlaboratoire;
        $ids = ArrayHelper::getColumn($resultatLaboEquipement, 'labo_id');

        //Je parcour la maps des données
        foreach ($resultatLaboEquipement as $Labo) {
            $couttotal = 0;
            $laboid = $Labo[0]->id;
            foreach ($Labo as $l) {
                $couttotal = $couttotal + $l->total;
            }
            if (array_key_exists(intval($laboid), $laborarydepenses)) {
                $laborarydepenses[$laboid]['total'] = $laborarydepenses[$laboid]['total'] + $couttotal;
            } else {
                $laborarydepenses = $laborarydepenses + array($laboid => array('labo_id' => $laboid, 'total' => $couttotal));
            }
        }



        $laboratorylist = Laboratory::getAll();

        $laboratorylistArray = ArrayHelper::map($laboratorylist, 'id', 'name');



        $listExternalDepense = $project->coutExternalDepense;
        $listInternalDepense = $project->coutInternalDepense;



        //Sum of pourcent millestone = 100%
        $totalPoucent  = 0;
        foreach ($millestones as $millestone) {
            $totalPoucent  = $totalPoucent  + $millestone->pourcentage;
        }
        if ($totalPoucent != 100) {
            $validdevis = false;
        }

        $tjmstat = false;
        if ($project->tjmWithRisk < 700 || $project->tjm < 700) {
            $tjmstat = true;
        }


        MenuSelectorHelper::setMenuProjectDraft();
        return $this->render(
            'projectSimulation',
            [
                'tjmstatut' => $tjmstat,
                'validdevis' => $validdevis,
                'project' =>  $project,
                'lotavp' => $lotavp,
                'lots' => $lots,
                'millestones' => (empty($millestones)) ? [new ProjectCreateMilleStoneForm()] : $millestones,
                'laboratorydepenses' => $laborarydepenses,
                'laboratorylistArray' => $laboratorylistArray,
                'listExternalDepense' => $listExternalDepense,
                'listInternalDepense' => $listInternalDepense,

            ]

        );
    }

    /**
     * Route : create-lot-simulate
     * Permet de modifier les marges d'un lot
     * @param integer $project_id : id du projet sur lequel se trouve le lot.
     * @param integer $number : numéro du lot.
     * 
     * @return mixed|error
     */
    public function actionLotSimulate($project_id = 1, $number = 1)
    {

        // Modèle du lot à updater. On s'en sert pour récupérer son id.
        $lot = LotSimulate::getOneByIdProjectAndNumber($project_id, $number);

        // Si renvoi de données par méthode POST sur l'élément unique, on va supposer que c'est un renvoi de formulaire.
        if ($lot->load(Yii::$app->request->post())) {

            $lot->save();
        }

        if ($lot == null) {
            return $this->redirect([
                'error',
                'errorName' => 'Lot innexistant',
                'errorDescriptions' => ['Vous essayez actuellement de modifier un lot qui n\'existe pas.']
            ]);
        }
        MenuSelectorHelper::setMenuProjectDraft();
        return $this->render(
            'lotSimulation',
            [
                'lot' =>  $lot
            ]

        );
    }

    /**
     * Route : update-task
     * Permet de modifier les tâches d'un lot de projet.
     * @param integer $project_id : id du projet sur lequel se trouve le lot.
     * @param integer $number : numéro du lot.
     * 
     * @return mixed|error
     */
    public function actionUpdateTask($number, $project_id)
    {

        // Modèle du lot à updater. On s'en sert pour récupérer son id.
        $model = new ProjectCreateTaskForm();
        $model->project_id = $project_id;
        $model->number = $number;
        $lot = $model->GetCurrentLot();

        $tasksGestionsModif = ProjectCreateGestionTaskForm::getTypeTaskByLotId($lot->id, Task::CATEGORY_MANAGEMENT)
            ? ProjectCreateGestionTaskForm::getTypeTaskByLotId($lot->id, Task::CATEGORY_MANAGEMENT) : [new ProjectCreateGestionTaskForm()];

        $tasksLotsModif = ProjectCreateLotTaskForm::getTypeTaskByLotId($lot->id, Task::CATEGORY_TASK)
            ? ProjectCreateLotTaskForm::getTypeTaskByLotId($lot->id, Task::CATEGORY_TASK) : [new ProjectCreateLotTaskForm()];


        $tasksGestions = ProjectCreateGestionTaskForm::getTypeTaskByLotId($lot->id, Task::CATEGORY_MANAGEMENT);
        $tasksOperational = ProjectCreateLotTaskForm::getTypeTaskByLotId($lot->id, Task::CATEGORY_TASK);

        //Recupération des membres de la cellule
        $idcellule = Yii::$app->user->identity->cellule_id;
        $cel = new Cellule();
        $cel->id = $idcellule;
        $celluleUsers = $cel->capaUsers;
        $risk = Risk::find()->all();

        if ($model->load(Yii::$app->request->post())) {
            $isValid = true;

            if ($number != 0) {
                $oldTasksGestionsModifIds = ArrayHelper::map($tasksGestionsModif, 'id', 'id');
                $tasksGestionsModif = Model::createMultiple(ProjectCreateGestionTaskForm::class, $tasksGestionsModif);
                if (!ProjectCreateGestionTaskForm::loadMultiple($tasksGestionsModif, Yii::$app->request->post())) $isValid = false;
                $deletedTasksGestionsModifIds = array_diff($oldTasksGestionsModifIds, array_filter(ArrayHelper::map($tasksGestionsModif, 'id', 'id')));
            }

            $oldTasksLotsModifIds = ArrayHelper::map($tasksLotsModif, 'id', 'id');
            $tasksLotsModif = Model::createMultiple(ProjectCreateLotTaskForm::class, $tasksLotsModif);
            if (!ProjectCreateLotTaskForm::loadMultiple($tasksLotsModif, Yii::$app->request->post())) $isValid = false;
            $deletedTasksLotsModifIds = array_diff($oldTasksLotsModifIds, array_filter(ArrayHelper::map($tasksLotsModif, 'id', 'id')));

            if ($isValid) {

                if ($number != 0) {
                    //Ajout et modification des données.
                    foreach ($tasksGestionsModif as $taskGestionModif) {
                        $taskGestionModif->lot_id = $lot->id;
                        $taskGestionModif->number = $lot->number;
                        $taskGestionModif->task_category = Task::CATEGORY_MANAGEMENT;
                        $taskGestionModif->save();
                    }
                    if (!empty($deletedTasksGestionsModifIds)) {
                        ProjectCreateGestionTaskForm::deleteAll(['id' => $deletedTasksGestionsModifIds]);
                    }
                }

                //Ajout et modification des données.
                foreach ($tasksLotsModif as $taskOperationalModif) {
                    $taskOperationalModif->lot_id = $lot->id;
                    $taskOperationalModif->number = $lot->number;
                    $taskOperationalModif->task_category = Task::CATEGORY_TASK;
                    $taskOperationalModif->save();
                }
                if (!empty($deletedTasksLotsModifIds)) {
                    ProjectCreateLotTaskForm::deleteAll(['id' => $deletedTasksLotsModifIds]);
                }

                Yii::$app->response->redirect(['project/update-task', 'project_id' => $project_id, 'number' => $number]);
            }
        }

        $tasksGestions = ProjectCreateGestionTaskForm::getTypeTaskByLotId($lot->id, Task::CATEGORY_MANAGEMENT);
        $tasksOperational = ProjectCreateLotTaskForm::getTypeTaskByLotId($lot->id, Task::CATEGORY_TASK);

        MenuSelectorHelper::setMenuProjectDraft();
        return $this->render(
            'createTask',
            [
                'update' => true,
                'model' => $model,
                'celluleUsers' => $celluleUsers,
                'tasksGestions' => (empty($tasksGestions)) ? [new ProjectCreateGestionTaskForm] : $tasksGestions,
                'tasksOperational' => (empty($tasksOperational)) ? [new ProjectCreateLotTaskForm] : $tasksOperational,
                'risk' => $risk,
            ]
        );
    }

    /**
     * Route : update-dependencies-consumables
     * Permet de modifier les dépenses et les consommables d'un lot.
     * @param integer $project_id : id du projet sur lequel se trouve le lot dans lequel on souhaite intégrer des éléments (matériels, intervenants ect...)
     * @param integer $number : numéro du lot sur lequel on souhaite intégrer des éléments (matériels, intervenants ect...)
     * 
     * @return mixed|error
     */
    public function actionUpdateDependenciesConsumables($project_id, $number)
    {
        // Modèle du lot à updater. On s'en sert pour récupérer son id.
        $lot = Lot::getOneByIdProjectAndNumber($project_id, $number);
        $model = new ProjectCreateThirdStepForm();

        $model->setLaboratorySelectedFromLaboID($lot->laboratory_id);

        if ($lot == null) {
            return $this->redirect([
                'error',
                'errorName' => 'Lot innexistant',
                'errorDescriptions' => ['Vous essayez actuellement de modifier une liste de matériels sur un lot/projet qui n\'existe pas.']
            ]);
        }

        // Récupérer les données existantes du lot spécifié en paramètre.
        $consumables = ProjectCreateConsumableForm::getAllConsummablesByLotID($lot->id)
            ? ProjectCreateConsumableForm::getAllConsummablesByLotID($lot->id) : [new ProjectCreateConsumableForm];

        $invests = ProjectCreateInvestForm::getAllByLotID($lot->id)
            ? ProjectCreateInvestForm::getAllByLotID($lot->id) : [new ProjectCreateInvestForm];

        $equipmentsRepayment = ProjectCreateEquipmentRepaymentForm::getAllByLotID($lot->id)
            ? ProjectCreateEquipmentRepaymentForm::getAllByLotID($lot->id) : [new ProjectCreateEquipmentRepaymentForm];
        $equipmentByID = Equipment::getAllByLaboratoryID($lot->laboratory_id);
        foreach ($equipmentsRepayment as $equipmentRepayment) {
            $equipmentRepayment->setSelectedEquipment($equipmentByID);
            $equipmentRepayment->setSelectedRisk();
        }

        if ($lot->laboratory_id != null)
            $contributors = ProjectCreateLaboratoryContributorForm::getAllByLaboratoryID($lot->laboratory_id)
                ? ProjectCreateLaboratoryContributorForm::getAllByLaboratoryID($lot->laboratory_id) : [new ProjectCreateLaboratoryContributorForm];
        else
            $contributors = [new ProjectCreateLaboratoryContributorForm];
        foreach ($contributors as $contributor) {
            $contributor->setSelectedRisk();
        }

        // Import de données depuis la bdd.
        $laboratoriesData = Laboratory::getAllThatHasEquipments();
        $equipmentsData = Equipment::getAll();
        $risksData = Risk::getAll();

        // Si renvoi de données par méthode POST sur l'élément unique, on va supposer que c'est un renvoi de formulaire.
        if ($model->load(Yii::$app->request->post())) {
            // Variable de vérification de validité des données lors du renvoi par méthode POST.
            $isValid = true;

            // Vérification des consommables.
            $oldConsumablesIds = ArrayHelper::map($consumables, 'id', 'id');
            $consumables = Model::createMultiple(ProjectCreateConsumableForm::class, $consumables);
            if (!Model::loadMultiple($consumables, Yii::$app->request->post())) $isValid = false;
            $deletedConsumablesIDs = array_diff($oldConsumablesIds, array_filter(ArrayHelper::map($consumables, 'id', 'id')));

            // Vérifications des investissements.
            $oldInvestsIds = ArrayHelper::map($invests, 'id', 'id');
            $invests = Model::createMultiple(ProjectCreateInvestForm::class, $invests);
            if (!Model::loadMultiple($invests, Yii::$app->request->post())) $isValid = false;
            $deletedInvestsIDs = array_diff($oldInvestsIds, array_filter(ArrayHelper::map($invests, 'id', 'id')));

            // Vérification des équipements de laboratoire et de leur utilisation.
            $oldEquipmentsRepaymentIds = ArrayHelper::map($equipmentsRepayment, 'id', 'id');
            $equipmentsRepayment = Model::createMultiple(ProjectCreateEquipmentRepaymentForm::class, $equipmentsRepayment);
            if (!Model::loadMultiple($equipmentsRepayment, Yii::$app->request->post())) $isValid = false;
            $deletedEquipmentsRepaymentIDs = array_diff($oldEquipmentsRepaymentIds, array_filter(ArrayHelper::map($equipmentsRepayment, 'id', 'id')));

            // Vérification des intervenants.
            $oldContributorsIds = ArrayHelper::map($contributors, 'id', 'id');
            $contributors = Model::createMultiple(ProjectCreateLaboratoryContributorForm::class, $contributors);
            if (!Model::loadMultiple($contributors, Yii::$app->request->post())) $isValid = false;
            $deletedContributorsIDs = array_diff($oldContributorsIds, array_filter(ArrayHelper::map($contributors, 'id', 'id')));

            if ($isValid) {

                // Sauvegarde du laboratoire sélectionné dans le lot.
                $lot->laboratory_id = $laboratoriesData[$model->laboratoryselected - 1]->id;
                $lot->save();

                // On associe les consommables au lot actuel, puis on les sauvegardes.
                foreach ($consumables as $consumable) {
                    $consumable->lot_id = $lot->id;
                    $consumable->type = Consumable::TYPES[$consumable->type];
                    $consumable->save();
                }
                if (!empty($deletedConsumablesIDs)) {
                    Consumable::deleteAll(['id' => $deletedConsumablesIDs]);
                }

                /**
                 * On associe les consommables au lot actuel, puis on les sauvegardes. Notons que si le lot est égale à 0, on enregistre aucuns investissements.
                 * Quand le lot est égale à 0, il n'y a pas d'investissements. Le fonctionement du widget DynamicForm nous 
                 * oblige tout de même à garder un objet Invest dans la liste $invtests.
                 * On ne doit donc pas le prendre en compte lors de la validation du formulaire.
                 */
                if ($number != 0) {
                    foreach ($invests as $invest) {
                        $invest->lot_id = $lot->id;
                        $invest->save();
                    }
                    if (!empty($deletedInvestsIDs)) {
                        Investment::deleteAll(['id' => $deletedInvestsIDs]);
                    }
                }

                // On récupère la liste de matériels lié au choix du labo fait précédement. Utilisé pour récupérer le bon matériel sélectionné.
                $id_laboratory = $lot->laboratory_id;
                $equipmentsDataFilteredByLabo = array_values(
                    array_filter($equipmentsData, function ($equipment) use ($id_laboratory) {
                        return ($equipment->laboratory_id == $id_laboratory);
                    })
                );

                // On associe les matériels au lot actuel, puis on les sauvegardes.
                foreach ($equipmentsRepayment as $equipmentRepayment) {
                    $equipmentRepayment->equipment_id = $equipmentsDataFilteredByLabo[$equipmentRepayment->equipmentSelected]->id;
                    $equipmentRepayment->lot_id = $lot->id;
                    $equipmentRepayment->risk_id = \intval($equipmentRepayment->riskSelected) + 1;
                    $equipmentRepayment->time_risk = TimeStringifyHelper::transformStringChainToHour($equipmentRepayment->timeRiskStringify);
                    $equipmentRepayment->save();
                }
                if (!empty($deletedEquipmentsRepaymentIDs)) {
                    EquipmentRepayment::deleteAll(['id' => $deletedEquipmentsRepaymentIDs]);
                }

                // On associe les intervenants de laboratoire au lot actuel, puis ont les sauvegardes.
                foreach ($contributors as $contributor) {
                    $contributor->type = LaboratoryContributor::TYPES[$contributor->type];
                    $contributor->laboratory_id = $id_laboratory;
                    $contributor->lot_id = $lot->id;
                    $contributor->risk_id = intval($contributor->riskSelected) + 1;
                    $contributor->time_risk = TimeStringifyHelper::transformStringChainToHour($contributor->timeRiskStringify);
                    $contributor->save();
                }
                if (!empty($deletedContributorsIDs)) {
                    LaboratoryContributor::deleteAll(['id' => $deletedContributorsIDs]);
                }

                Yii::$app->response->redirect(['project/update-dependencies-consumables', 'project_id' => $project_id, 'number' => $number]);
            }
        }

        MenuSelectorHelper::setMenuProjectDraft();
        return $this->render(
            'createThirdStep',
            [
                'number' => $number,
                'project_id' => $project_id,

                'laboratoriesData' => $laboratoriesData,
                'equipmentsData' => $equipmentsData,
                'risksData' => $risksData,

                'model' => $model,
                'consumables' => $consumables,
                'invests' => $invests,
                'equipments' => $equipmentsRepayment,
                'contributors' => $contributors
            ]
        );
    }


    /**
     * Route : none.
     * Redirect : project/view?id=?
     * Permet de transformer un brouillon en projet.
     * @param integer $id : id du projet.
     * 
     * @return mixed|error
     */
    public function actionCreateProject(int $id = 1)
    {
        MenuSelectorHelper::setMenuProjectNone();
        //Recupération des membres de la cellule
        $idcellule = Yii::$app->user->identity->cellule_id;
        $cel = new Cellule();
        $cel->id = $idcellule;
        $celluleUsers = $cel->capaUsers;

        $model = ProjectCreateForm::getOneById($id);
        $company = $model->company;
        $TVA = 0;

        if ($company->country == 'France') {
            $TVA = 20;
        }

        if (Yii::$app->request->isPost) {
            $model->upfilename = UploadedFile::getInstances($model, 'upfilename');

            if ($model->upload(Yii::$app->request->post())) {
                $post = Yii::$app->request->post();
                $postform = $post["ProjectCreateForm"];

                // file is uploaded successfully
                $project = Project::getOneById($id);
                $project->state = Project::STATE_DEVIS_SENDED;
                $project->file_path = $model->file_path;
                $project->file_name = $model->file_name;
                $project->thematique = $postform["thematique"];
                $project->save();

                Yii::$app->response->redirect(['project/view', 'id' => $project->id]);
            }
        }

        return $this->render('createProject', [
            'model' => ProjectCreateForm::getOneById($id),
            'celluleUsers' => $celluleUsers,
            'TVA' => $TVA
        ]);
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


    /**
     * /!\ TRASHBOX /!\
     * Methodes inutilisées - cassées
     */

    /**
     * //TODO TO DELETE : not used anymore.
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
     * //TODO TO KEEP : just need an update.
     */
    public function actionDownloadExcel(int $id)
    {
        // $model = $this->findModel($id);
        // if ($model != null) ExcelExportService::exportModelDataToExcel($model, ExcelExportService::DEVIS_TYPE);
    }

    /**
     * //TODO TO DELETE : useless.
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
     * //TODO TO DELETE : useless.
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

        MenuSelectorHelper::setMenuProjectDraft();
        return $this->render(
            'createFirstStep',
            [
                'model' => $model,
                'lots' => $lots
            ]
        );
    }

    public function actionTest($id)
    {
        return IdLaboxyManager::generateNumberFromId($id);
    }
}
