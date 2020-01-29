<?php

namespace app\controllers;


use yii\web\Controller;



class AdminstrationController extends Controller implements  ServiceInterface
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [      
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [ ];
    }



   /**
    * Get list of the right
    */
    public static  function GetRight()
    {
        return ['Aucun',
                'Responsable'];
    }

    /**
     * Get list of indicateur
     *
     */
    public static  function GetIndicateur($user)
    {

    }

    /**
     * Get Action for the user
     */
    public static  function GetActionUser($user)
    {
       // if($user->get)
        return ['Priorite' => 1,'Name' =>'Administration',
        'items' => [ ['Priorite' => 1,'url' => 'Administration/index','label'=>'Liste Utilisateur','icon'=>'show_chart'],
         ['Priorite' => 2,'url' =>'Administration/userform','label'=>'Ajouter utilisateur','icon'=>'show_chart']  ]    
        ];
    }



    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
  
    }

 
   

}
