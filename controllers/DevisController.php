<?php

namespace app\controllers;

use yii\bootstrap\Alert;

use yii\bootstrap\Modal;

use yii\filters\AccessControl;
use Yii;
use app\models\devis\Devis;
use app\models\devis\DevisStatut;
use app\models\devis\Company;
use app\models\devis\DevisCreateForm;
use app\models\devis\DevisUpdateForm;
use app\models\devis\DevisSearch;
use app\models\devis\Typeprestation;


use yii\web\UploadedFile;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

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
        $searchModelAvantContrat->statutsearch = 'Avant contrat';
        $dataProviderAvantContrat = $searchModelAvantContrat->search(Yii::$app->request->queryParams);


        $searchModelAttenteop = new DevisSearch();
        $searchModelAttenteop->statutsearch = 'Attente validation Opérationel';
        $dataProviderAttenteop  = $searchModelAttenteop->search(Yii::$app->request->queryParams);

        $searchModelAttenteClient = new DevisSearch();
        $searchModelAttenteClient->statutsearch = 'Attente validation client';
        $dataProviderAttenteClient  = $searchModelAttenteClient->search(Yii::$app->request->queryParams);


        $searchModelEncours = new DevisSearch();
        $searchModelEncours->statutsearch = 'Projet en cours';
        $dataProviderEncours  = $searchModelEncours->search(Yii::$app->request->queryParams);


        $searchModelTerminer = new DevisSearch();
        $searchModelTerminer->statutsearch = 'Projet terminé';
        $dataProviderTerminer  = $searchModelTerminer->search(Yii::$app->request->queryParams);

        $searchModelAnnule = new DevisSearch();
        $searchModelAnnule->statutsearch = 'Projet annulé';
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
        if($model)
        {
        $filepath = 'uploads/'.$model->id_capa.'/'.$model->filename ;
          if(file_exists($filepath))
          {
             
              // Set up PDF headers 
              header('Content-type: application/pdf');
              header('Content-Disposition: inline; filename="' . $model->filename . '"');
              // Render the file
              readfile($filepath);
          }
          else
          {
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
        $modeltypeprestation = Typeprestation::getlisteTypePrestation();
        if ($model->load(Yii::$app->request->post())) {
          
            //Gestion de la company
            $modelcompany = Company::find()->where(['name'=>$model->companyname,'tva'=> $model->companytva])->one();
            
            if($modelcompany == null)
            {
                $modelcompany = new Company();
                $modelcompany->name=$model->companyname;
                $modelcompany->tva=$model->companytva;
                $modelcompany->save();
            }



            ///Format ex : AROBOXXXX donc XXXX est fixe avec l'id
            $model->id_capa = yii::$app->user->identity->cellule->identifiant.printf('%04d',$model->id) ;
            $model->id_laboxy = $model->id_capa.' - '. $modelcompany->name ;
            $model->company_id =  $modelcompany->id ;
            $model->capaidentity_id = yii::$app->user->identity->id;
            $model->cellule_id =  yii::$app->user->identity->cellule->id;
            $model->statut_id = Devisstatut::AVANTPROJET;
            if ($model->save())
                return $this->redirect(['view', 'id' => $model->id]);
        }


        return $this->render('create', [
            'model' => $model,'prestationtypelist' =>  $modeltypeprestation
        ]);
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
        $model = $this->findModel($id);

        $modeltypeprestation = Typeprestation::getlisteTypePrestation();

       $modelDevis =  DevisUpdateForm::findOne($id);
        if ($modelDevis->load(Yii::$app->request->post()))
        {
            $modelDevis->upfilename = UploadedFile::getInstance($modelDevis, 'upfilename');
            $modelDevis->upload();
            $modelDevis->upfilename='';
               //Gestion de la company
              // var_dump( $modelDevis);
              $array = Yii::$app->request->post('DevisUpdateForm')['company'];
              

               $modelcompany = Company::find()->where(['name'=>$array['name'],'tva'=>$array['tva']])->one();
            
               if($modelcompany == null)
               {
                   $modelcompany = new Company();
                   $modelcompany->name=$array['name'];
                   $modelcompany->tva=$array['tva'];
                   $modelcompany->save();

               }
               $modelDevis->company_id=$modelcompany->id;
            $modelDevis->save(false);

           
           return $this->redirect(['view', 'id' => $model->id]);
            
        }
  
        return $this->render('update', [
            'model' => $modelDevis,'prestationtypelist' =>  $modeltypeprestation,
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
            $model->staut_id = Devisstatut::ATTENTEVALIDATIONOP;;

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
                'Aucun' => 'Aucun',
                'Responsable' => 'Responsable'
            ]
        ];
    }


    public static function GetIndicateur($user)
    {
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
