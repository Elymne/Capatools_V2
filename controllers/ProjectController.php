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
use app\models\projects\MilestoneSearch;
use app\services\laboxyServices\IdLaboxyManager;
use app\services\menuServices\MenuSelectorHelper;
use app\services\menuServices\SubMenuEnum;
use app\services\userRoleAccessServices\PermissionAccessEnum;
use app\services\userRoleAccessServices\UserRoleEnum;
use app\services\userRoleAccessServices\UserRoleManager;
use app\services\helpers\TimeStringifyHelper;
use app\services\menuServices\LeftMenuCreator;
use kartik\mpdf\Pdf;
use yii\data\ActiveDataProvider;
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
                'only' => [
                    'index',
                    'index-draft',
                    'view',
                    'update-status',
                    'update-millestone-status',
                    'pdf',
                    'create-first-step',
                    'project-simulate',
                    'lot-simulate',
                    'update-task',
                    'update-dependencies-consumables',
                    'create-project',
                    'delete',
                ],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index'],
                        'roles' => [PermissionAccessEnum::PROJECT_INDEX],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['index-draft'],
                        'roles' => [PermissionAccessEnum::PROJECT_INDEX_DRAFT],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['view'],
                        'roles' => [PermissionAccessEnum::PROJECT_VIEW],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['update-status'],
                        'roles' => [PermissionAccessEnum::PROJECT_UPDATE_STATUS],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['update-millestone-status'],
                        'roles' => [PermissionAccessEnum::PROJECT_UPDATE_MILESTONE_STATUS],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['pdf'],
                        'roles' => [PermissionAccessEnum::PROJECT_PDF],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['create-first-step'],
                        'roles' => [PermissionAccessEnum::PROJECT_CREATE],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['project-simulate'],
                        'roles' => [PermissionAccessEnum::PROJECT_CREATE],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['lot-simulate'],
                        'roles' => [PermissionAccessEnum::PROJECT_CREATE],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['update-task'],
                        'roles' => [PermissionAccessEnum::PROJECT_CREATE],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['update-dependencies-consumables'],
                        'roles' => [PermissionAccessEnum::PROJECT_CREATE],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['create-project'],
                        'roles' => [PermissionAccessEnum::PROJECT_CREATE],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['delete'],
                        'roles' => [PermissionAccessEnum::PROJECT_CREATE],
                    ],

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

        $subMenu = new LeftMenuCreator(3, "Projets", SubMenuEnum::PROJECT, [
            UserRoleEnum::PROJECT_MANAGER, UserRoleEnum::ACCOUNTING_SUPPORT, UserRoleEnum::ADMIN, UserRoleEnum::SUPER_ADMIN
        ]);

        $subMenu->addSubMenu(4, "project/create-first-step", "Création d'un devis", SubMenuEnum::PROJECT_CREATE, [
            UserRoleEnum::PROJECT_MANAGER, UserRoleEnum::ADMIN, UserRoleEnum::SUPER_ADMIN
        ]);

        $subMenu->addSubMenu(3, "project/index-draft", "Liste des brouillons", SubMenuEnum::PROJECT_DRAFT, [
            UserRoleEnum::PROJECT_MANAGER, UserRoleEnum::ADMIN, UserRoleEnum::SUPER_ADMIN
        ]);

        $subMenu->addSubMenu(2, "project/index", "Liste des projets",  SubMenuEnum::PROJECT_LIST, []);

        $subMenu->addSubMenu(1, "project/index-milestones", "Liste des jalons", SubMenuEnum::PROJECT_MILESTONES, [
            UserRoleEnum::PROJECT_MANAGER, UserRoleEnum::ADMIN, UserRoleEnum::SUPER_ADMIN, UserRoleEnum::ACCOUNTING_SUPPORT
        ]);

        return $subMenu->getSubMenuCreated();
    }

    /**
     * Render view : projet/index
     * Retourne la vue de l'index Devis.
     * Liste de tous les projets présent dans la base de données qui ne sont pas à l'état de brouillon.
     * 
     * @return mixed 
     */
    function actionIndex()
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
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, true);

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
    public function actionUpdateStatus(int $id, string $status)
    {
        $project = project::getOneById($id);
        $currentstate = $project->state;
        $project->state = $status;

        if ($status == Project::STATE_DEVIS_SIGNED) {
            $project->signing_probability = 100;
            $project->id_laboxy = IdLaboxyManager::generateLaboxyId($project);
            foreach ($project->millestones as $millestone) {

                $millestone->statut = Millestone::STATUT_ENCOURS;
                $millestone->save();
            }
        }
        if ($status == Project::STATE_DEVIS_CANCELED &&  $currentstate == Project::STATE_DEVIS_SENDED) {
            $project->signing_probability = 0;
        }

        if ($status == Project::STATE_DEVIS_CANCELED || $status == Project::STATE_DEVIS_FINISHED) {
            foreach ($project->millestones as $millestone) {
                if ($millestone->statut == Millestone::STATUT_ENCOURS) {
                    $millestone->statut = Millestone::STATUT_CANCELED;
                    $millestone->save();
                }
            }
        }

        if ($status == Project::STATE_DRAFT) {
            $project->draft = true;
        }

        $project->save();

        if ($status == Project::STATE_DRAFT) {
            MenuSelectorHelper::setMenuProjectDraft();
            return Yii::$app->response->redirect(['project/project-simulate', 'project_id' => $project->id]);
        }

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
    public function actionUpdateMillestoneStatus(int $id, string $status, string $direct = 'view')
    {
        $jalon = Millestone::getOneById($id);
        $jalon->statut = $status;
        $jalon->last_update_date =  date("d-m-yy", strtotime("now"));
        $jalon->save();

        if ($direct == 'view') {
            MenuSelectorHelper::setMenuProjectIndex();

            return $this->render('view', [
                'model' => $this->findModel($jalon->project_id),
            ]);
        } else {
            Yii::$app->response->redirect(['project/index-milestones']);
        }
    }

    public function actionUpdateSigningProbability(int $id, int $probability)
    {
        $project = Project::getOneById($id);
        $project->signing_probability = $probability;
        $project->save();

        MenuSelectorHelper::setMenuProjectNone();
        return $this->render('view', [
            'model' => $this->findModel($id),
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
                'SetFooter' => "<img src=\"" . YII::$app->basePath . "/web/images/pdf/footer.png\">",
                'SetKeywords' => 'Krajee, Yii2, Export, PDF, MPDF, Output, Privacy, Policy, yii2-mpdf',
            ]
        ]);


        MenuSelectorHelper::setMenuProjectNone();
        return $pdf->render();
    }

    /**
     * Render view : projet/index-milestones
     * Route qui retourne une vue html composé de la liste des jalons en cours (et peut-être plus).
     * 
     * @return mixed
     */
    public function actionIndexMilestones()
    {

        // MilestoneSearch est une classe qui implémente Millestone. Elle dispose donc de toutes les méthodes ORM.
        $searchModel = new MilestoneSearch();
        // Mais elle possède surtout cette méthode qui permet de founir au gridView de la vue, des spécifivité permettant de d'ordonner par exemple certains éléments du gridView.
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $celluleNameList = array_map(function ($elem) {
            return $elem->name;
        }, Cellule::find()->all());

        MenuSelectorHelper::setMenuProjectMilestones();
        return $this->render(
            'indexMilestones',
            [
                'dataProvider' =>  $dataProvider,
                'celluleNameList' => $celluleNameList,
                'statusNameList' => Millestone::STATUT
            ]
        );
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

        $contactsEmail = ArrayHelper::map(Contact::find()->all(), 'id', 'email');
        $contactsEmail = array_merge($contactsEmail);

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
                $model->first_in = 0;

                // On récupère l'id de la cellule de l'utilisateur connecté.
                $model->cellule_id = Yii::$app->user->identity->cellule_id;
                // On inclu la clé étragère qui référence une donnée indéfini dans la table company.
                $model->company_id = Company::getOneByName($model->company_name)->id;
                // On inclu la clé étragère qui référence une donnée indéfini dans la table contact.
                $model->contact_id = Contact::getOneByEmail($model->contact_email)->id;
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

                $model->low_tjm_description = ' ';
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
                // Si aucun lot de créé, on en créé un par défaut.
                if (\sizeof($lots) == 0) {
                    $lots = [new ProjectCreateLotForm()];
                    $lots[0]->title = 'Lot par défaut';
                    $lots[0]->comment = 'Ceci est un lot qui a été généré automatiquement car le créateur ne souhaitait pas utiliser plusieurs lots';
                }

                // Pour chaque lot, on lui attribut des valeurs par défaut.
                foreach ($lots as $key => $lot) {
                    $lot->title = $lot->id_string . $lot->title;
                    $lot->number = $key + 1;
                    $lot->status = Lot::STATE_IN_PROGRESS;
                    $lot->project_id = $model->id;

                    $lot->save();
                }
                // On redirige vers la prochaine étape.
                return Yii::$app->response->redirect(['project/project-simulate', 'project_id' => $model->id]);
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
    public function actionProjectSimulate($project_id = 1, $sucess = null)
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

        $millestonesModif  = ProjectCreateMilleStoneForm::getAllByProject($project->id);
        if (!$millestonesModif) {
            $millestonesModif = [new ProjectCreateMilleStoneForm];
        }

        $isValid = true;

        $oldmillestonesIds = ArrayHelper::map($millestonesModif, 'id', 'id');
        $millestonesModif = Model::createMultiple(ProjectCreateMilleStoneForm::class, $millestonesModif);
        if (!ProjectCreateMilleStoneForm::loadMultiple($millestonesModif, Yii::$app->request->post())) {
            $isValid = false;
        }

        $deletedmillestonesModifIds = array_diff($oldmillestonesIds, array_filter(ArrayHelper::map($millestonesModif, 'id', 'id')));
        if ($isValid) {

            $SaveSucess = true;
            foreach ($millestonesModif as $Milestone) {


                $Milestone->project_id = $project->id;
                $Milestone->statut = Millestone::STATUT_NOT_STARTED;
                $Milestone->save();
            }
            if (!empty($deletedmillestonesModifIds)) {
                ProjectCreateMilleStoneForm::deleteAll(['id' => $deletedmillestonesModifIds]);
            }
        }


        $millestones = ProjectCreateMilleStoneForm::getAllByProject($project->id);

        if (count($millestones) == 0) {
            $advancepayement = new  ProjectCreateMilleStoneForm();
            $advancepayement->number = 0;

            if ($project->SellingPrice > 2000) {
                $advancepayement->comment = "Acompte";
                $advancepayement->pourcentage = 30.0;
                $advancepayement->price = (30.0 / 100) * $project->SellingPrice;
            }
            array_push($millestones, $advancepayement);
        }

        //check validity of the devis
        //1 A least for each lot TotalCostHuman != 0
        $Resultcheck = ['lots' => [], 'millestone' => true];
        $lotsCheck = [];
        foreach ($lots as $lot) {
            if ($lot->totalCostHuman == 0) {
                $validdevis = false;
                array_push($lotsCheck, ['Result' => false, 'number' => $lot->number]);
            } else {
                array_push($lotsCheck, ['Result' => true, 'number' => $lot->number]);
            }
        }
        $Resultcheck['lots'] = $lotsCheck;

        $laborarydepenses = array();

        $resultatLaboColabborator =  $project->coutlaboratoire;

        //Je parcours la maps des données
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
            $Resultcheck['millestone'] = false;
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
                'Resultcheck' => $Resultcheck,
                'SaveSucess' => $sucess,

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
        $SaveSucess = null;
        // Modèle du lot à updater. On s'en sert pour récupérer son id.
        $lot = LotSimulate::getOneByIdProjectAndNumber($project_id, $number);

        // Si renvoi de données par méthode POST sur l'élément unique, on va supposer que c'est un renvoi de formulaire.
        if ($lot->load(Yii::$app->request->post())) {
            $SaveSucess = true;
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
                'lot' =>  $lot,
                'SaveSucess' => $SaveSucess,
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

        $SaveSucess = false;
        // Modèle du lot à updater. On s'en sert pour récupérer son id.
        $model = new ProjectCreateTaskForm();
        $model->project_id = $project_id;
        $model->number = $number;
        $lot = $model->GetCurrentLot();

        ///Récupération des tâches gestions
        $tasksGestionsModif = ProjectCreateGestionTaskForm::getTypeTaskByLotId($lot->id, Task::CATEGORY_MANAGEMENT);
        if (!$tasksGestionsModif) {
            $tasksGestionsModif = [new ProjectCreateLotTaskForm()];
        }

        ///Récupération des tâches lots
        $tasksLotsModif = ProjectCreateLotTaskForm::getTypeTaskByLotId($lot->id, Task::CATEGORY_TASK);
        if (!$tasksLotsModif) {
            $tasksLotsModif = [new ProjectCreateLotTaskForm()];
        }

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
                //Trie sur la gestion

                $oldTasksGestionsModifIds = ArrayHelper::map($tasksGestionsModif, 'id', 'id');
                $tasksGestionsModif = Model::createMultiple(ProjectCreateGestionTaskForm::class, $tasksGestionsModif);

                ProjectCreateGestionTaskForm::loadMultiple($tasksGestionsModif, Yii::$app->request->post());

                $deletedTasksGestionsModifIds = array_diff($oldTasksGestionsModifIds, array_filter(ArrayHelper::map($tasksGestionsModif, 'id', 'id')));
            }

            //Trie sur la lot
            $oldTasksLotsModifIds = ArrayHelper::map($tasksLotsModif, 'id', 'id');
            $tasksLotsModif = Model::createMultiple(ProjectCreateLotTaskForm::class, $tasksLotsModif);

            if (!ProjectCreateLotTaskForm::loadMultiple($tasksLotsModif, Yii::$app->request->post())) {
                $isValid = false;
            }

            $deletedTasksLotsModifIds = array_diff($oldTasksLotsModifIds, array_filter(ArrayHelper::map($tasksLotsModif, 'id', 'id')));

            if ($isValid) {

                $SaveSucess = true;
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

                $project = $lot->project;
                $project->first_in = 1;
                $project->save();
                if (!empty($deletedTasksLotsModifIds)) {
                    ProjectCreateLotTaskForm::deleteAll(['id' => $deletedTasksLotsModifIds]);
                }
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
                'SaveSucess' => $SaveSucess,
            ]
        );
    }

    /**
     * Route : update-dependencies-consumables
     * Permet de modifier les dépenses et les consommables d'un lot.
     * @param integer $project_id - id du projet sur lequel se trouve le lot dans lequel on souhaite intégrer des éléments (matériels, intervenants ect...)
     * @param integer $number - numéro du lot sur lequel on souhaite intégrer des éléments (matériels, intervenants ect...)
     * @param bool $sucess - paramètre qui sert à définir si la modification/création/suppression des devis s'est correctement passé.
     * 
     * @return mixed|error
     */
    public function actionUpdateDependenciesConsumables($project_id, $number, $sucess = null)
    {
        // Modèle du lot à updater. On s'en sert pour récupérer son id.
        $lot = Lot::getOneByIdProjectAndNumber($project_id, $number);
        $model = new ProjectCreateThirdStepForm();
        $model->setLaboratorySelectedFromLaboID($lot->laboratory_id);

        // Error checker.
        if ($lot == null) {
            return $this->redirect([
                'error',
                'errorName' => 'Lot innexistant',
                'errorDescriptions' => ['Vous essayez actuellement de modifier une liste de matériels sur un lot/projet qui n\'existe pas.']
            ]);
        }

        // Récupérer les données existantes du lot spécifié en paramètre.
        $consumables = ProjectCreateConsumableForm::getAllConsummablesByLotID($lot->id);
        if ($consumables == null) {
            $consumables = [new ProjectCreateConsumableForm];
        }

        // Si lot 0, pas d'investissements.
        $invests = null;
        if ($number != 0) {
            $invests = ProjectCreateInvestForm::getAllByLotID($lot->id);
            if ($invests == null) {
                $invests = [new ProjectCreateInvestForm];
            }
        }

        // Récupération des équipements stockés.
        $equipmentsRepayment = ProjectCreateEquipmentRepaymentForm::getAllByLotID($lot->id);
        if ($equipmentsRepayment == null) {
            $equipmentsRepayment = [new ProjectCreateEquipmentRepaymentForm];
        }

        foreach ($equipmentsRepayment as $equipmentRepayment) {
            $equipmentRepayment->setSelectedRisk();
        }

        // Récupération des contributors.

        $contributors = ProjectCreateLaboratoryContributorForm::getAllByLotID($lot->id);
        if ($contributors == null) {
            $contributors = [new ProjectCreateLaboratoryContributorForm];
        }


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

            // Chargement des consommables, notons qu'on ne vérifie pas 
            $oldConsumablesIds = ArrayHelper::map($consumables, 'id', 'id');
            $consumables = Model::createMultiple(ProjectCreateConsumableForm::class, $consumables);
            Model::loadMultiple($consumables, Yii::$app->request->post());
            $deletedConsumablesIDs = array_diff($oldConsumablesIds, array_filter(ArrayHelper::map($consumables, 'id', 'id')));

            // Vérifications des investissements. On vérifie toujours qu'on est pas sur le laut 0.
            if ($number != 0) {
                $oldInvestsIds = ArrayHelper::map($invests, 'id', 'id');
                $invests = Model::createMultiple(ProjectCreateInvestForm::class, $invests);
                Model::loadMultiple($invests, Yii::$app->request->post());
                $deletedInvestsIDs = array_diff($oldInvestsIds, array_filter(ArrayHelper::map($invests, 'id', 'id')));
            }

            // Vérification des équipements de laboratoire et de leur utilisation.
            $oldEquipmentsRepaymentIds = ArrayHelper::map($equipmentsRepayment, 'id', 'id');
            $equipmentsRepayment = Model::createMultiple(ProjectCreateEquipmentRepaymentForm::class, $equipmentsRepayment);
            Model::loadMultiple($equipmentsRepayment, Yii::$app->request->post());
            $deletedEquipmentsRepaymentIDs = array_diff($oldEquipmentsRepaymentIds, array_filter(ArrayHelper::map($equipmentsRepayment, 'id', 'id')));

            // Vérification des intervenants.
            $oldContributorsIds = ArrayHelper::map($contributors, 'id', 'id');
            $contributors = Model::createMultiple(ProjectCreateLaboratoryContributorForm::class, $contributors);
            Model::loadMultiple($contributors, Yii::$app->request->post());
            $deletedContributorsIDs = array_diff($oldContributorsIds, array_filter(ArrayHelper::map($contributors, 'id', 'id')));

            if ($isValid) {

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
                 * On associe les consommables au lot actuel, puis on les sauvegardes. Notons que si le lot est égal à 0, on enregistre aucun investissement.
                 * Quand le lot est égal à 0, il n'y a pas d'investissements. Le fonctionement du widget DynamicForm nous 
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


                // On associe les matériels au lot actuel, puis on les sauvegardes.
                foreach ($equipmentsRepayment as $equipmentRepayment) {
                    $equipmentRepayment->lot_id = $lot->id;
                    $equipmentRepayment->risk_id = \intval($equipmentRepayment->riskSelected) + 1;
                    $equipmentRepayment->time_risk = TimeStringifyHelper::transformStringChainToHour($equipmentRepayment->timeRiskStringify);
                    $equipmentRepayment->laboratory_id = $lot->laboratory_id;
                    $equipmentRepayment->save();
                }
                if (!empty($deletedEquipmentsRepaymentIDs)) {
                    EquipmentRepayment::deleteAll(['id' => $deletedEquipmentsRepaymentIDs]);
                }

                // On associe les intervenants de laboratoire au lot actuel, puis ont les sauvegardes.
                foreach ($contributors as $contributor) {
                    $contributor->laboratory_id = $lot->laboratory_id;
                    $contributor->lot_id = $lot->id;
                    $contributor->risk_id = intval($contributor->riskSelected) + 1;
                    $contributor->time_risk = TimeStringifyHelper::transformStringChainToHour($contributor->timeRiskStringify);
                    $contributor->save();
                }
                if (!empty($deletedContributorsIDs)) {
                    LaboratoryContributor::deleteAll(['id' => $deletedContributorsIDs]);
                }

                $project = $lot->project;
                $project->first_in = 1;
                $project->save();
                // project_id, $number, $sucess = false
                return $this->redirect([
                    'update-dependencies-consumables',
                    'project_id' => $project_id,
                    'number' => $number,
                    'sucess' => true
                ]);
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
                'contributors' => $contributors,
                'sucess' => $sucess,
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

        $model = ProjectCreateForm::getOneById($id); // On récupère le modèle formulaire de données de projet avec l'id.
        $celluleUsers = ArrayHelper::map(Cellule::getOneById(Yii::$app->user->identity->cellule_id)->capaUsers, 'id', 'email');

        if ($model->company->country) {
            $TVA = 20;
        } else {
            $TVA = 0;
        }

        if ($model->load(Yii::$app->request->post())) {
            // Préparation du fichier.
            $model->pdfFile = UploadedFile::getInstances($model, 'pdfFile');

            // Si le fichier est bien upload, on procède à l'enregistrement du projet.
            if ($model->upload()) {

                $finalModel = Project::getOneById($model->id);

                $finalModel->state = Project::STATE_DEVIS_SENDED;
                $finalModel->signing_probability = $model->signing_probability;
                $finalModel->draft = false;
                $finalModel->capa_user_id = $model->projectManagerSelectedValue;
                $finalModel->file_name = $model->file_name;
                $finalModel->file_path = $model->file_path;
                $finalModel->thematique = $model->thematique;

                $finalModel->save();

                MenuSelectorHelper::setMenuProjectDraft();

                return Yii::$app->response->redirect(['project/view', 'id' => $model->id]);
            }
        }

        MenuSelectorHelper::setMenuProjectDraft();
        return $this->render('createProject', [
            'model' => $model,
            'celluleUsers' => $celluleUsers,
            'TVA' => $TVA
        ]);
    }

    public function actionDeleteDraftProject(int $id)
    {
        $model = Project::getOneById($id);
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

    public function actionTest($id)
    {
        return IdLaboxyManager::generateNumberFromId($id);
    }
}
