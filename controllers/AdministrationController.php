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
use app\services\menuServices\MenuSelectorHelper;
use app\services\menuServices\SubMenuEnum;
use app\services\uploadFileServices\UploadFileHelper;
use app\services\userRoleAccessServices\PermissionAccessEnum;
use app\services\userRoleAccessServices\UserRoleEnum;
use app\services\userRoleAccessServices\UserRoleManager;
use yii\data\ActiveDataProvider;
use yii\web\UploadedFile;

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
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
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
                        'actions' => ['index-equipments'],
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
                    'serviceMenuActive' => SubMenuEnum::USER,
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
                'subServiceMenuActive' => SubMenuEnum::USER_LIST
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
                'subServiceMenuActive' => SubMenuEnum::USER_UPDATE_DEVIS_PARAMETERS
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
                'url' => 'administration/index-equipments',
                'label' => 'Liste des matériels',
                'icon' => 'show_chart',
                'subServiceMenuActive' => SubMenuEnum::USER_UPDATE_EQUIPMENTS
            ]);
        }

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

        // Get cellule data used for our form.
        $cellules = ArrayHelper::map(Cellule::getAll(), 'id', 'name');
        $cellules = array_merge($cellules);

        UserRoleManager::setRoleToModelForm($model);

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            // +1 car le dropdown est un tableau et son index commence à 0. L'id lui commence à 1.
            $model->cellule_id += 1;

            if ($model->save()) {

                // Remove all roles.
                UserRoleManager::removeRolesFromUser($model->id);

                // And then, we set updated roles for the user.
                UserRoleManager::setRolesFromUserUpdateForm($model);

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
     * Render view : devis/manage-devis-parameters.
     * Méthode en deux temps :
     * - Si pas de méthode POST de trouvé, on retourne la vue de la modification des paramètres devis.
     * - Sinon, à partir de la méthode POST, on récupère toutes les informations des nouveaux param-tres devis, et ensuite à la vérification,
     * on change celle-ci.
     * 
     * @return mixed
     */
    public function actionUpdateDevisParameters()
    {

        $model = DevisParameterUpdateForm::getParameters();

        // Get file model.
        $fileCguFrModel = new UploadFile();

        // Get file model.
        $fileCguEnModel = new UploadFile();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            $fileCguFrModel->file = UploadedFile::getInstance($fileCguFrModel, 'cguFrFile');
            UploadFileHelper::uploadCguFrFile($fileCguFrModel);

            $fileCguEnModel->file = UploadedFile::getInstance($fileCguEnModel, 'cguEnFile');
            UploadFileHelper::uploadCguEnFile($fileCguEnModel);

            $model->save();

            MenuSelectorHelper::setMenuDevisParameters();
            return $this->redirect(['administration/view-devis-parameters']);
        }

        MenuSelectorHelper::setMenuDevisParameters();
        return $this->render(
            'devisParametersUpdate',
            [
                'model' => $model,
                'fileCguFrModel' => $fileCguFrModel,
                'fileCguEnModel' => $fileCguEnModel
            ]
        );
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
    public function actionIndexEquipments()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Equipment::getAllDataProvider(),
        ]);

        MenuSelectorHelper::setMenuEquipments();
        return $this->render(
            'equipmentIndex',
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
                MenuSelectorHelper::setMenuAdminNone();
                return $this->redirect(['administration/view-equipments']);
            }
        }

        MenuSelectorHelper::setMenuEquipments();
        return $this->render('createEquipment', [
            'model' => $model,
            'laboratoriesName' => $laboratoriesName
        ]);
    }

    /**
     * //TODO
     * Render view : aucune pour l'instant.
     * Cette méthode retournera une liste avec toutes les cellules disponible ainsi que le prix de gestation de projet par cellule.
     * Il sera donc possible à travers cette vue d'accéder à un formulaire pour modifier cette valeur de gestation.
     */
    public function actionIndexCellules()
    {
    }

    /**
     * //TODO
     * Render view : aucune pour l'instant.
     * Cette méthode retournera un formulaire permettant de modifier le prix de gestation d'une cellule.
     */
    public function actionUpdateCellule(int $id)
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
