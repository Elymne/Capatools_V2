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



   /**
    * Get list of the right
    */
    public static  function GetRight()
    {

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
       return ['Priorite' => 1,'Name' =>'RH',
        'items' => [ ['url' => 'RH/ActionName','label'=>'ooooo','icon'=>'show_chart'],
         ['url' =>'RH/nn;','label'=>'kkklisateur','icon'=>'show_chart']  ]    
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
