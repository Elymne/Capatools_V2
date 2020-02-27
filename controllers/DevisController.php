<?php

namespace app\controllers;

use yii\filters\AccessControl;
use Yii;
use app\models\devis\Devis;
use app\models\devis\DevisStatus;
use app\models\devis\Company;
use app\models\devis\DevisCreateForm;
use app\models\devis\DevisUpdateForm;
use app\models\devis\DevisSearch;
use app\models\devis\DeliveryType;
use app\models\devis\Milestone;
use app\helper\DateHelper;
use app\models\Model;

use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * DevisController implements the CRUD actions for Devis model.
 */
class DevisController extends Controller implements ServiceInterface
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['Index', 'View', 'Create', 'Update', 'Delete'],
                'rules' => [
                    [
                        'actions' => ['Index', 'View', 'Create', 'Update', 'Delete'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Devis models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModelAvantContrat = new DevisSearch();
        $searchModelAvantContrat->statusSearch = 'Avant contrat';
        $dataProviderAvantContrat = $searchModelAvantContrat->search(Yii::$app->request->queryParams);

        $searchModelAttenteop = new DevisSearch();
        $searchModelAttenteop->statusSearch = 'Attente validation Opérationel';
        $dataProviderAttenteop  = $searchModelAttenteop->search(Yii::$app->request->queryParams);

        $searchModelAttenteClient = new DevisSearch();
        $searchModelAttenteClient->statusSearch = 'Attente validation client';
        $dataProviderAttenteClient  = $searchModelAttenteClient->search(Yii::$app->request->queryParams);

        $searchModelEncours = new DevisSearch();
        $searchModelEncours->statusSearch = 'Projet en cours';
        $dataProviderEncours  = $searchModelEncours->search(Yii::$app->request->queryParams);

        $searchModelTerminer = new DevisSearch();
        $searchModelTerminer->statusSearch = 'Projet terminé';
        $dataProviderTerminer  = $searchModelTerminer->search(Yii::$app->request->queryParams);

        $searchModelAnnule = new DevisSearch();
        $searchModelAnnule->statusSearch = 'Projet annulé';
        $dataProviderAnnule  = $searchModelAnnule->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModelAvantContrat' => $searchModelAvantContrat,
            'dataProviderAvantContrat' => $dataProviderAvantContrat,

            'searchModelAttenteop' => $searchModelAttenteop,
            'dataProviderAttenteop' => $dataProviderAttenteop,

            'searchModelAttenteClient' => $searchModelAttenteClient,
            'dataProviderAttenteClient' => $dataProviderAttenteClient,

            'searchModelEncours' => $searchModelEncours,
            'dataProviderEncours' => $dataProviderEncours,

            'searchModelTerminer' => $searchModelTerminer,
            'dataProviderTerminer' => $dataProviderTerminer,

            'searchModelAnnule' => $searchModelAnnule,
            'dataProviderAnnule' => $dataProviderAnnule,
        ]);
    }

    /**
     * Displays a single Devis model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Displays a single Devis model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionViewpdf($id)
    {
        $model =  $this->findModel($id);
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
     * Deletes an existing Devis model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }


    #region Devis Avant contrat


    /**
     * Creates a new Devis model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new DevisCreateForm();
        $deliveryTypeModel = DeliveryType::getDeliveryTypes();
        if ($model->load(Yii::$app->request->post())) {

            //Gestion de la company
            $company = Company::find()->where(['name' => $model->company_name, 'tva' => $model->company_tva])->one();

            if ($company == null) {
                $company = new Company();
                $company->name = $model->company_name;
                $company->tva = $model->company_tva;
                $company->save();
            }

            ///Format ex : AROBOXXXX donc XXXX est fixe avec l'id
            $model->id_capa = yii::$app->user->identity->cellule->identity . printf('%04d', $model->id);
            $model->id_laboxy = $model->id_capa . ' - ' . $company->name;
            $model->company_id =  $company->id;
            $model->capa_user_id = yii::$app->user->identity->id;
            $model->cellule_id =  yii::$app->user->identity->cellule->id;
            $model->status_id = DevisStatus::AVANTPROJET;
            if ($model->save())
                return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render(
            'create',
            [
                'model' => $model,
                'delivery_type' =>  $deliveryTypeModel
            ]
        );
    }

    /**
     * Updates an existing Devis avant contrat devis models.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdateavcontrat($id)
    {


        $devis =  DevisUpdateForm::findOne($id);
        $milestones =  $devis->milestones;

        // if : empty(milestones) = true then milestones == [] = true.
        // Don't know the use of this.
        if (empty($milestones)) {
            $milestones = [];
        }

        $deliveryTypeModel = DeliveryType::getDeliveryTypes();
        if ($devis->load(Yii::$app->request->post())) {

            //Je créer l'array avec les éléments présent dans le post + les élements déjà présent
            $milestones = Model::createMultiple(Milestone::classname(), $milestones);
            //Charge les jalons

            $tptp = Yii::$app->request->post();

            //JE charge les données dans mon models
            Model::loadMultiple($milestones, Yii::$app->request->post());

            // Company management.
            $array = Yii::$app->request->post('DevisUpdateForm')['company'];

            $company = Company::find()->where(['name' => $array['name'], 'tva' => $array['tva']])->one();

            if ($company == null) {
                $company = new Company();
                $company->name = $array['name'];
                $company->tva = $array['tva'];
                $company->save();
            }

            $devis->company_id = $company->id;
            $transaction = \Yii::$app->db->beginTransaction();

            try {
                $devis->save(false);

                foreach ($milestones as $milestone) {
                    // Format date for sql insertion.
                    $milestone->devis_id = $devis->id;
                    $milestone->delivery_date = DateHelper::formatDateTo_Ymd($milestone->delivery_date);

                    if (!($flag = $milestone->save(false))) {
                        $transaction->rollBack();
                        break;
                    }
                }

                $transaction->commit();
            } catch (Exception $e) {
                $transaction->rollBack();
            }

            return $this->redirect(['view', 'id' => $devis->id]);
        }

        return $this->render('update', [
            'model' => $devis, 'delivery_type' =>  $deliveryTypeModel,
            'milestones' => (empty($milestones)) ? [new Milestone] : $milestones
        ]);
    }


    /**
     * valide a devis and change state avantcontrat to Attente validation Opérationel
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionValidationavcontrat($id)
    {
        $model = $this->findModel($id);

        if ($model) {

            //Attente validation Opérationel statut =4
            $model->staut_id = DevisStatus::ATTENTEVALIDATIONOP;;

            $model->save();
        }

        return $this->redirect(['index']);
    }


    #endregion




    /**
     * Finds the Devis model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Devis the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Devis::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }


    public static function GetRight()
    {
        return  [
            'name' => 'Administration',
            'right' => [
                'none' => 'none',
                'Responsable' => 'Responsable'
            ]
        ];
    }


    public static function GetIndicateur($user)
    {

        return  ['label' => 'NbDevis', 'value' => Devis::getGroupbyStatus()];
    }


    public static function GetActionUser($user)
    {
        $result = [];

        $result = [
            'priorite' => 3, 'name' => 'Devis',
            'items' => [
                ['Priorite' => 1, 'url' => 'devis/index', 'label' => 'Liste des devis', 'icon' => 'show_chart'],
                ['Priorite' => 2, 'url' => 'devis/create', 'label' => 'Ajouter un devis', 'icon' => 'show_chart']
            ]
        ];

        return $result;
    }
}
