<?php

namespace app\controllers;

use yii\filters\AccessControl;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

use app\models\users\CapaUser;
use app\models\users\CapaUserCreateForm;
use app\models\users\CapaUserSearch;
use app\models\users\CapaUserUpdateForm;
use app\models\users\Cellule;
use app\models\projects\UploadFile;
use app\models\parameters\DevisParameter;
use app\models\parameters\DevisParameterUpdateForm;
use app\models\equipments\Equipment;
use app\models\equipments\EquipmentCreateForm;
use app\models\laboratories\Laboratory;
use app\models\laboratories\LaboratoryCreateForm;
use app\models\administrativeDocuments\AdministrativeDocument;
use app\services\menuServices\MenuSelectorHelper;
use app\services\menuServices\SubMenuEnum;
use app\services\uploadFileServices\UploadFileHelper;
use app\services\userRoleAccessServices\PermissionAccessEnum;
use app\services\userRoleAccessServices\UserRoleEnum;
use app\services\userRoleAccessServices\UserRoleManager;
use yii\data\ActiveDataProvider;

/**
 * Classe contrôleur des vues et des actions de la partie adminitration.
 * Attention au nom du contrôleur, il détermine le point d'entré de la route.
 * ex : pour notre contrôleur AdministrationController -> administration/[*]
 * Chaque route généré par le controller provient des fonctions dont le nom commence par action******.
 * ex : actionIndex donnera la route suivante -> administration/index
 * ex : actionIndexDetails donnera la route suivante -> administration/index-details.
 * 
 * @version Capatools v2.0
 * @since Classe existante depuis la Release v2.0
 */
class AdministrationController extends Controller
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
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::class,
                'denyCallback' => function ($rule, $action) {
                    throw new \Exception('You are not allowed to access this page');
                },
                'only' => ['index', 'view', 'create', 'update', 'delete', 'view-devis-parameters', 'update-devis-parameters', 'index-equipments', 'create-equipment'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index'],
                        'roles' => [PermissionAccessEnum::ADMIN_INDEX],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['create'],
                        'roles' => [PermissionAccessEnum::ADMIN_CREATE],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['view'],
                        'roles' => [PermissionAccessEnum::ADMIN_VIEW],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['update'],
                        'roles' => [PermissionAccessEnum::ADMIN_UPDATE],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['delete'],
                        'roles' => [PermissionAccessEnum::ADMIN_DELETE],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['view-devis-parameters'],
                        'roles' => [PermissionAccessEnum::ADMIN_DEVIS_PARAMETERS_VIEW]
                    ],
                    [
                        'allow' => true,
                        'actions' => ['update-devis-parameters'],
                        'roles' => [PermissionAccessEnum::ADMIN_DEVIS_PARAMETERS_UPDATE]
                    ],
                    [
                        'allow' => true,
                        'actions' => ['index-equipment'],
                        'roles' => [PermissionAccessEnum::ADMIN_EQUIPEMENT_INDEX]
                    ],
                    [
                        'allow' => true,
                        'actions' => ['create-equipment'],
                        'roles' => [PermissionAccessEnum::ADMIN_EQUIPEMENT_CREATE]
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
     * - priotite : L'ordre de priorité de position du menu Administration.
     * - name : Texte du menu Administration.
     * - serviceMenuActive : Paramètre utilisé pour permettre de déplier le menu administration 
     * lorsque l'utilisateur est actuellement sur une vue administration.
     * - items : Les sous-menus.
     * 
     * @return Array Un tableau de données relatif au menu Administration.
     */
    public static function getActionUser()
    {
        $result = [];

        if (UserRoleManager::hasRoles([
            UserRoleEnum::ADMIN,
            UserRoleEnum::SUPER_ADMIN,
            UserRoleEnum::HUMAN_RESSOURCES
        ])) {
            $result =
                [
                    'priorite' => 1,
                    'name' => 'Administration',
                    'serviceMenuActive' => SubMenuEnum::ADMIN,
                    'items' => self::getSubActionUser()
                ];
        }

        return $result;
    }

    /**
     * Utilisé dans la fonction getActionUser.
     * Retourne tous les sous-menus.
     * On utilise cette fonction pour permettre de filtrer les sous-menus visible selon les droits de l'utilisateur connecté.
     * 
     * @return Array Un tableau de données relatif aux sous-menus.
     */
    private static function getSubActionUser(): array
    {
        $result = [];

        if (
            UserRoleManager::hasRoles([
                UserRoleEnum::ADMIN,
                UserRoleEnum::SUPER_ADMIN,
                UserRoleEnum::HUMAN_RESSOURCES
            ])
        ) {
            array_push($result, [
                'priorite' => 2,
                'url' => 'administration/index',
                'label' => 'Salariés',
                'icon' => 'show_chart',
                'subServiceMenuActive' => SubMenuEnum::ADMIN_LIST_USER
            ]);
        }

        if (
            UserRoleManager::hasRoles([
                UserRoleEnum::ADMIN,
                UserRoleEnum::SUPER_ADMIN
            ])
        ) {
            array_push($result, [
                'priorite' => 1,
                'url' => 'administration/view-devis-parameters',
                'label' => 'Paramètres des devis',
                'icon' => 'show_chart',
                'subServiceMenuActive' => SubMenuEnum::ADMIN_UPDATE_DEVIS_PARAMETERS
            ]);
        }

        if (
            UserRoleManager::hasRoles([
                UserRoleEnum::ADMIN,
                UserRoleEnum::SUPER_ADMIN
            ])
        ) {
            array_push($result, [
                'priorite' => 1,
                'url' => 'administration/index-equipment',
                'label' => 'Liste des matériels',
                'icon' => 'show_chart',
                'subServiceMenuActive' => SubMenuEnum::ADMIN_LIST_EQUIPMENTS
            ]);
        }

        if (
            UserRoleManager::hasRoles([
                UserRoleEnum::ADMIN,
                UserRoleEnum::SUPER_ADMIN
            ])
        ) {
            array_push($result, [
                'priorite' => 1,
                'url' => 'administration/index-laboratory',
                'label' => 'Liste des laboratoires',
                'icon' => 'show_chart',
                'subServiceMenuActive' => SubMenuEnum::ADMIN_LIST_LABORATORIES
            ]);
        }

        array_push($result, [
            'priorite' => 2,
            'url' => 'administration/index-document',
            'label' => 'Documents administratifs',
            'icon' => 'library_books',
            'subServiceMenuActive' => SubMenuEnum::ADMIN_LIST_DOCUMENTS
        ]);

        return $result;
    }

    /**
     * Render view : administration/index
     * Retourne la vue de l'index Administration.
     * Liste de tous les utilisateurs présent dans la base de données.
     * 
     * @return mixed 
     */
    public function actionIndex()
    {

        $searchModel = new CapaUserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $cellulesName = array_map(function ($value) {
            return $value->name;
        }, Cellule::getAll());

        MenuSelectorHelper::setMenuAdminIndex();
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'cellulesNames' => $cellulesName
        ]);
    }

    /**
     * Render view : administration/view?id=?
     * Retourne la vue détaillé d'un utilisateur par rapport à l'id rentré en paramètre.
     * 
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException If the model is not found.
     */
    public function actionView(int $id)
    {
        $userRoles = Yii::$app->authManager->getRolesByUser($id);

        MenuSelectorHelper::setMenuAdminNone();
        return $this->render('view', [
            'model' => $this->findModel($id), 'userRoles' => $userRoles,
        ]);
    }

    /**
     * Render view : administration/create.
     * Méthode en deux temps :
     * - Si pas de méthode POST de trouvé, retourne la vue de la création d'un utilisateur.
     * - Sinon, à partir de la méthode POST, on récupère toutes les informations du nouvel utilisateur rentrées, et suite à la vérification,
     * on les stocke en base de données.
     * 
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new CapaUserCreateForm();

        $cellules = ArrayHelper::map(Cellule::getAll(), 'id', 'name');
        $cellules = array_merge($cellules);

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            $model->flag_active = true;
            //TODO Pensez à remettre ceci.
            //$model->generatePasswordAndmail();

            // Set hash password.
            $model->setNewPassword($model->firstname);

            // On ajoute +1 car la liste commence à 0 et l'id cellule à 1 (décalage de 1).
            $model->cellule_id += 1;

            if ($model->save()) {
                UserRoleManager::setRolesFromUserCreateForm($model);

                MenuSelectorHelper::setMenuAdminNone();
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        MenuSelectorHelper::setMenuAdminNone();
        return $this->render('create', [
            'model' => $model,
            'cellules' => $cellules
        ]);
    }

    /**
     * Render view : administration/update.
     * Redirected view : administration/index.
     * Méthode en deux temps :
     * - Si pas de méthode POST de trouvé, on retourne la vue de la modification d'un utilisateur.
     * - Sinon, à partir de la méthode POST, on récupère toutes les informations de l'utilisateur, et ensuite à la vérification,
     * on modifie celui-ci.
     * 
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException If the model cannot be found.
     */
    public function actionUpdate(int $id)
    {
        $model = CapaUserUpdateForm::findOne($id);
        $cellules = array_merge(ArrayHelper::map(Cellule::getAll(), 'id', 'name')); // Get cellule data used for our form.
        UserRoleManager::setRoleToModelForm($model);

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->cellule_id += 1; // +1 car le dropdown est un tableau et son index commence à 0. L'id lui commence à 1.

            if ($model->save()) {
                UserRoleManager::removeRolesFromUser($model->id); // Remove all roles.
                UserRoleManager::setRolesFromUserUpdateForm($model);  // And then, we set updated roles for the user.

                MenuSelectorHelper::setMenuAdminNone();
                return $this->redirect(['view', 'id' => $model->id]);
            }

            MenuSelectorHelper::setMenuAdminNone();
            return $this->redirect(['view', 'id' => $model->id]);
        }

        MenuSelectorHelper::setMenuAdminNone();
        return $this->render('update', [
            'model' => $model,
            'cellules' => $cellules
        ]);
    }

    /**
     * Render view : none.
     * Redirected view : administration/index.
     * Utilisé pour effacer un utilisateur de la base de données.
     * 
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete(int $id)
    {
        //on empêche l'auto suppression
        if (Yii::$app->user->identity->id != $id) {
            $user =  $this->findModel($id);
            $userRoles = $user->userRole;
            foreach ($userRoles as $userRole) {
                $userRole->delete();
            }
            $user->flag_active = false;
            $user->save();
        }

        MenuSelectorHelper::setMenuAdminIndex();
        return $this->redirect(['index']);
    }

    /**
     * Render view : devis/view-devis-parameters.
     * Cette méthode est utilisé pour retourner une vue affichant tous les paramètres devis de l'application.
     * Ces paramètres sont stockés de manière globale.
     * 
     * @return mixed
     */
    public function actionViewDevisParameters()
    {
        MenuSelectorHelper::setMenuDevisParameters();
        return $this->render('devisParametersView', [
            'model' => DevisParameter::getParameters()
        ]);
    }

    /**
     * Utilisé pour télécharger le fichier uploadé du CGU Français.
     * 
     */
    public function actionDownloadCguFrFile()
    {
        $pathFile = 'cgu/cguFrPdf.py';
        UploadFileHelper::downloadFile($pathFile);
    }

    /**
     * Utilisé pour télécharger le fichier uploadé du CGU Anglais.
     * 
     */
    public function actionDownloadCguEnFile()
    {
        $pathFile = 'cgu/cguEnPdf.py';
        UploadFileHelper::downloadFile($pathFile);
    }

    /**
     * Render view : administration/view-equipments.
     * Cette méthode est utilisé pour retourner une vue affichant tous les matériels de l'application.
     * Ces matériels sont stockés de manière globale.
     * 
     * @return mixed
     */
    public function actionIndexEquipment()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Equipment::getAllDataProvider(),
            'pagination' => [
                'pageSize' => -1,
            ],
        ]);

        MenuSelectorHelper::setMenuEquipments();
        return $this->render(
            'indexEquipment',
            [
                'dataProvider' => $dataProvider
            ]
        );
    }

    /**
     * Render view : administration/create-equipment.
     * Cette méthode est utilisé pour retourner une vue permettant de créer un équipement.
     * Le nouveau matériel est stocké de manière globale.
     * 
     * @return mixed
     */
    public function actionCreateEquipment()
    {
        $model = new EquipmentCreateForm();
        $laboratoriesName = ArrayHelper::map(Laboratory::getAll(), 'id', 'name');

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->save()) {
                MenuSelectorHelper::setMenuEquipments();
                return $this->redirect(['administration/index-equipments']);
            }
        }

        MenuSelectorHelper::setMenuEquipments();
        return $this->render('createEquipment', [
            'model' => $model,
            'laboratoriesName' => $laboratoriesName
        ]);
    }

    /**
     * Render view : administration/view-laboratories.
     * Cette méthode est utilisé pour retourner une vue affichant tous les matériels de l'application.
     * 
     * @return mixed
     */
    public function actionIndexLaboratory()
    {

        $dataProvider = new ActiveDataProvider([
            'query' => Laboratory::getAllDataProvider(),
            'pagination' => [
                'pageSize' => -1,
            ],
        ]);

        MenuSelectorHelper::setMenuLaboratories();
        return $this->render(
            'indexLaboratory',
            [
                'dataProvider' => $dataProvider
            ]
        );
    }

    /**
     * Render view : administration/create-laboratory.
     * Cette méthode est utilisé pour retourner une vue permettant de créer un laboratoire.
     * 
     * @return mixed
     */
    public function actionCreateLaboratory()
    {
        $model = new LaboratoryCreateForm();
        $cellulesName = ArrayHelper::map(Cellule::getAll(), 'id', 'name');

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->cellule_id = $model->celluleSelect;
            if ($model->save()) {
                MenuSelectorHelper::setMenuLaboratories();
                return $this->redirect(['administration/index-laboratory']);
            }
        }

        MenuSelectorHelper::setMenuLaboratories();
        return $this->render('createLaboratory', [
            'model' => $model,
            'cellulesName' => $cellulesName
        ]);
    }


    /**
     * Render view : administration/view-Documents.
     * Cette méthode est utilisé pour retourner une vue affichant tous les documents.
     * 
     * @return mixed
     */
    public function actionIndexDocument()
    {

        $dataProvider = new ActiveDataProvider([
            'query' => AdministrativeDocument::getAllDataProvider(),
            'pagination' => [
                'pageSize' => -1,
            ],
        ]);

        MenuSelectorHelper::setMenuDocuments();
        return $this->render(
            'indexdocument',
            [
                'dataProvider' => $dataProvider
            ]
        );
    }

    /**
     * Render view : administration/create-document.
     * Cette méthode est utilisé pour retourner une vue permettant d'ajouter un document adminstratif'.
     * 
     * @return mixed
     */
    public function actionCreateDocument()
    {
    }





    /**
     * Méthode générale pour le contrôleur permettant de retourner un utilisateur.
     * Cette méthode est utilisé pour gérer le cas où l'utilisateur recherché n'existe pas, et donc gérer l'exception.
     * 
     * @param integer $id
     * @return CapaUser the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CapaUser::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * @deprecated Cette fonction n'est plus utilisé
     */
    public static function getIndicator($user)
    {
    }
}
