<?php

namespace app\controllers;


use yii\web\Controller;


interface ServiceInterface 
{   
    public static  function GetRight();
    public static  function GetIndicateur($user);
    public static  function GetActionUser($user);
}
