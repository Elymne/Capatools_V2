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
use app\helper\_enum\PermissionAccessEnum;
use app\helper\_enum\SubMenuEnum;
use app\helper\_enum\UserRoleEnum;
use app\models\companies\Company;
use app\models\users\CapaUser;
use app\models\companies\CompanyCreateForm;
use app\models\companies\Contact;
use app\models\companies\ContactCreateForm;
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
                'only' => ['index', 'view', 'create', 'index-contacts', 'create-contact'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index'],
                        'roles' => [PermissionAccessEnum::COMPANY_INDEX],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['view'],
                        'roles' => [PermissionAccessEnum::COMPANY_VIEW],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['create'],
                        'roles' => [PermissionAccessEnum::COMPANY_CREATE],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['index-contacts'],
                        'roles' => [PermissionAccessEnum::COMPANY_CONTACT_INDEX],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['create-contact'],
                        'roles' => [PermissionAccessEnum::COMPANY_CONTACT_CREATE],
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
            UserRoleEnum::SUPER_ADMIN
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

        array_push($result, [
            'Priorite' => 3,
            'url' => 'company/index-contacts',
            'label' => 'Liste des contacts',
            'subServiceMenuActive' => SubMenuEnum::COMPANY_UPDATE_CONTACTS
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

    /**
     * Render view : devis/view.
     * Retourne la vue des détails d'une société.
     * 
     * @return mixed
     */
    public function actionView(int $id)
    {
        MenuSelectorHelper::setMenuCompanyNone();
        return $this->render('view', [
            'model' => $this->findModel($id)
        ]);
    }

    /**
     * Render view : company/create.
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

                $model->type = CompanyTypeEnum::COMPANY_TYPE[$model->type];

                $model->save(false);

                MenuSelectorHelper::setMenuProjectCreate();
                return $this->redirect(['company/index']);
            }
        }

        MenuSelectorHelper::setMenuCompanyCreate();
        return $this->render(
            'create',
            [
                'model' => $model
            ]
        );
    }

    /**
     * Render view : administration/view-contacts.
     * Cette méthode est utilisé pour retourner une vue affichant tous les contacts de l'application.
     * Ces contacts sont stockés de manière globale.
     * 
     * @return mixed
     */
    public function actionIndexContacts()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Contact::getAll(),
        ]);

        MenuSelectorHelper::setMenuCompanyContacts();
        return $this->render(
            'contactView',
            [
                'dataProvider' => $dataProvider
            ]
        );
    }

    /**
     * Render view : company/create-contact.
     * Cette méthode est utilisé pour retourner une vue permettant de créer un contact.
     * Le nouveau contact est stocké de manière globale.
     * 
     * @return mixed
     */
    public function actionCreateContact()
    {
        $model = new ContactCreateForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->save()) {
                MenuSelectorHelper::setMenuCompanyNone();
                return $this->redirect(['company/view-contacts']);
            }
        }

        MenuSelectorHelper::setMenuCompanyContacts();
        return $this->render('createContact', [
            'model' => $model
        ]);
    }

    /**
     * Méthode générale pour le contrôleur permettant de retourner une société.
     * Cette méthode est utilisé pour gérer le cas où l'utilisateur recherché n'existe pas, et donc gérer l'exception.
     * 
     * @param integer $id
     * @return CapaUser the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Company::findOne($id)) !== null) {
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
