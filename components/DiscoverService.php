<?php

namespace app\components;


use yii\helpers\FileHelper;
use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;

class discoverService extends Component
{


    /**
     * Récupère la liste des services sauf le dashboard
     */
    public function getServices()
    {


        $path = Yii::$app->getControllerPath();

        $data = array();


        $files = FileHelper::findFiles($path, array("fileTypes" => array("php")));

        //Parcours du répeertoire contenant les controllers
        foreach ($files as $file) {
            include_once $file;

            $filename = basename($file, '.php');

            if (($pos = strpos($filename, 'Controller')) > 0) {

                $class_name = $controllers[] = substr($filename, 0, $pos);

                //On exclu le dashboard
                if ($class_name != 'Dashboard') {
                    $class_name = 'app\controllers\\' . $class_name . 'Controller';
                    array_unshift($data, $class_name);
                }
            }
        }

        return $data;
    }
}
