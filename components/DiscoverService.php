<?php

namespace app\components;

use yii\helpers\FileHelper;
use Yii;
use yii\base\Component;

/**
 * Classe qui s'utilisera comme un singleton dans l'application.
 * Elle s'instancie dans le fichier config/web.php
 * L'utilité de cette classe est de proposer une fonction qui permet de récupérer le nom des contrôleurs présent dans l'application.
 * 
 * @version Capatools v2.0
 * @since Classe existante depuis la Release v2.0
 */
class discoverService extends Component
{


    /**
     * On utilise cette fonction pour retourner tous les contrôleurs sauf le dashboardController.
     * Elle est utilisé car pour permettre de créer le menu de gauche qui se créer à partir des contrôleurs.
     * 
     * @return array
     */
    public function getServices()
    {
        $path = Yii::$app->getControllerPath();
        $data = array();
        $files = FileHelper::findFiles($path, array("fileTypes" => array("php")));

        foreach ($files as $file) {
            include_once $file;

            $filename = basename($file, '.php');

            if (($pos = strpos($filename, 'Controller')) > 0) {

                $class_name = $controllers[] = substr($filename, 0, $pos);

                if ($class_name != 'Dashboard') {
                    $class_name = 'app\controllers\\' . $class_name . 'Controller';
                    array_unshift($data, $class_name);
                }
            }
        }

        return $data;
    }
}
