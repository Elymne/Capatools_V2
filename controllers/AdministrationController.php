<?php

namespace app\controllers;

use yii\filters\AccessControl;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

use app\helper\_clazz\MenuSelectorHelper;
use app\helper\_clazz\UserRoleManager;
use app\helper\_enum\CompanyTypeEnum;
use app\helper\_enum\SubMenuEnum;
use app\helper\_enum\UserRoleEnum;
use app\models\user\CapaUser;
use app\models\user\CapaUserCreateForm;
use app\models\user\CapaUserSearch;
use app\models\user\CapaUserUpdateForm;
use app\models\user\Cellule;
use app\models\companies\CompanyCreateForm;


/**
 * Classe contrôleur des vues et des actions de la partie adminitration.
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
                'only' => ['index', 'view', 'create', 'update', 'delete'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index'],
                        'roles' => ['indexAdmin'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['create'],
                        'roles' => ['createAdmin'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['view'],
                        'roles' => ['viewAdmin'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['update'],
                        'roles' => ['updateAdmin'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['delete'],
                        'roles' => ['deleteAdmin'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['add-company'],
                        'roles' => ['addCompanyDevis'],
                    ]
                ],
            ],
        ];
    }

    /**
     * Implemented by : ServiceInterface.
     * Permet de créer les sous menus et d'associer chaque sous menu à une action du contrôleur.
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
            UserRoleEnum::ADMINISTRATOR,
            UserRoleEnum::SUPER_ADMINISTRATOR,
            UserRoleEnum::PROJECT_MANAGER_DEVIS
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
                UserRoleEnum::ADMINISTRATOR,
                UserRoleEnum::SUPER_ADMINISTRATOR
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
                UserRoleEnum::ADMINISTRATOR,
                UserRoleEnum::SUPER_ADMINISTRATOR,
                UserRoleEnum::PROJECT_MANAGER_DEVIS
            ])
        ) {
            array_push($result, [
                'Priorite' => 1,
                'url' => 'administration/add-company',
                'label' => 'Créer un client',
                'subServiceMenuActive' => SubMenuEnum::USER_ADD_COMPANY
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

    public function actionIndexFiltered($celluleName, $userName)
    {
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
            $model->setNewPassword($model->username);

            // Because dropdownlist is an array and begin at 0.
            $model->cellule_id += 1;

            if ($model->save()) {
                // Set roles for the new user.
                UserRoleManager::setDevisRole($model->id, UserRoleEnum::DEVIS_ROLE[$model->stored_role_devis]);
                UserRoleManager::setAdministrationRole($model->id, UserRoleEnum::ADMINISTRATION_ROLE[$model->stored_role_admin]);

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

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            // Because dropdownlist is an array.
            $model->cellule_id += 1;

            if ($model->save()) {

                // Remove all roles.
                UserRoleManager::removeRolesFromUser($model->id);

                // And then, we set updated roles for the user.
                UserRoleManager::setDevisRole($model->id, UserRoleEnum::DEVIS_ROLE[$model->stored_role_devis]);
                UserRoleManager::setAdministrationRole($model->id, UserRoleEnum::ADMINISTRATION_ROLE[$model->stored_role_admin]);

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
     * Render view : devis/add-company.
     * Méthode en deux temps :
     * - Si pas de méthode POST de trouvé, on retourne la vue de la création d'une société.
     * - Sinon, à partir de la méthode POST, on récupère toutes les informations de la nouvelle société, et ensuite à la vérification,
     * on créer celle-ci.
     * 
     * @return mixed
     */
    public function actionAddCompany()
    {
        $model = new CompanyCreateForm();

        if ($model->load(Yii::$app->request->post())) {

            if ($model->validate()) {

                // Transform data from droplist for database.
                $model->type = CompanyTypeEnum::COMPANY_TYPE[$model->type];

                $model->save();

                MenuSelectorHelper::setMenuDevisCreate();
                return $this->redirect(['devis/create']);
            }
        }

        MenuSelectorHelper::setMenuAdminAddCompany();
        return $this->render(
            'addCompany',
            [
                'model' =>  $model
            ]
        );
    }

    /**
     * Méthode générale pour le contrôleur permettant de retourner un utilisateur.
     * Cette méthode est utilisé pour gérer le cas où l'utilisateur recherché n'existe pas, et donc gérer l'exception.
     * 
     * @param integer $id
     * @return Devis the loaded model
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
     * 
     */
    public static function getIndicator(CapaUser $user)
    {
    }
}
