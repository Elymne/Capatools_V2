<?php

namespace app\controllers;

use yii\filters\AccessControl;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use app\helper\_clazz\MenuSelectorHelper;
use app\helper\_clazz\UserRoleManager;
use app\helper\_enum\CompanyTypeEnum;
use app\helper\_enum\SubMenuEnum;
use app\helper\_enum\UserRoleEnum;
use app\models\companies\Company;
use app\models\users\CapaUser;
use app\models\companies\CompanyCreateForm;
use yii\data\ActiveDataProvider;

/**
 * Classe contrôleur des vues et des actions de la partie société.
 * Attention au nom du contrôleur, il détermine le point d'entré de la route.
 * ex : pour notre contrôleur CompanyController -> company/[*] 
 * Hélas je ne peux pas respecter la règle de nommage qui voudrait que company soit au pluriel car elle prend le nom du contrôleur qui lui 
 * ne doit pas être au pluriel (merci Yii2).
 * Chaque route généré par le controller provient des fonctions dont le nom commence par action[une action].
 * ex : actionIndex donnera la route suivante -> administration/index
 * ex : actionIndexDetails donnera la route suivante -> administration/index-details.
 * 
 * @version Capatools v2.0
 * @since Classe existante depuis la Release v2.0
 */
class CompanyController extends Controller
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
                'only' => ['index', 'create'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index'],
                        'roles' => ['indexCompany'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['create'],
                        'roles' => ['createCompany'],
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
                    'name' => 'Sociétés',
                    'serviceMenuActive' => SubMenuEnum::COMPANY,
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

        array_push($result, [
            'Priorite' => 1,
            'url' => 'company/create',
            'label' => 'Créer un client',
            'subServiceMenuActive' => SubMenuEnum::COMPANY_CREATE
        ]);

        array_push($result, [
            'Priorite' => 2,
            'url' => 'company/index',
            'label' => 'Liste des clients',
            'subServiceMenuActive' => SubMenuEnum::COMPANY_INDEX
        ]);

        return $result;
    }

    /**
     * Render view : devis/index.
     * Retourne la vue de liste de toutes les sociétés enrengistrées en bdd.
     * 
     * @return mixed
     */
    public function actionIndex()
    {

        $dataProvider = new ActiveDataProvider([
            'query' => Company::getAll(),
        ]);

        MenuSelectorHelper::setMenuCompanyIndex();
        return $this->render(
            'index',
            [
                'dataProvider' =>  $dataProvider
            ]
        );
    }

    //TODO
    public function actionView(int $id)
    {
    }

    /**
     * Render view : devis/create.
     * Méthode en deux temps :
     * - Si pas de méthode POST de trouvé, on retourne la vue de la création d'une société.
     * - Sinon, à partir de la méthode POST, on récupère toutes les informations de la nouvelle société, et ensuite à la vérification,
     * on créer celle-ci.
     * 
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new CompanyCreateForm();

        if ($model->load(Yii::$app->request->post())) {

            if ($model->validate()) {

                // Transform data from droplist for database.
                $model->type = CompanyTypeEnum::COMPANY_TYPE[$model->type];

                $model->save();

                MenuSelectorHelper::setMenuDevisCreate();
                return $this->redirect(['company/index']);
            }
        }

        MenuSelectorHelper::setMenuCompanyCreate();
        return $this->render(
            'create',
            [
                'model' =>  $model
            ]
        );
    }

    //TODO
    public function actionSetContact(int $id)
    {
    }

    //TODO
    public function actionAddContact(int $id)
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
