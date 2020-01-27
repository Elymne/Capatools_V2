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
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
  
    }

 
   

}
