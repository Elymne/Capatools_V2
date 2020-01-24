<?php

namespace app\controllers;


use yii\web\Controller;



class RHController extends Controller implements  ServiceInterface
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



   
    public static  function GetRight()
    {

    }
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
