<?php

/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use yii\console\Controller;
use yii\console\ExitCode;


use app\models\user\CapaUser;
use app\models\user\Cellule;


/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class LoadUserController extends Controller
{

    public $file = '';
    public $NonAdm = '';
    public $PrenonAdm = '';

    public function options($actionID)
    {
        return ['file'];
    }
    public function optionAliases()
    {
        return ['f' => 'file'];
    }

    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     * @return int Exit code
     */
    public function actionIndex()
    {
        echo $this->file . "\n";
        $bresult = ExitCode::OK;

        if (($readfile = fopen($this->file, "r")) !== FALSE) {
            //Lecture de l'entête
            $data = fgetcsv($readfile, 10000, ';');

            //Lecture des donnéess
            while (($data = fgetcsv($readfile, 10000, ';')) !== FALSE) {
                $user = new CapaUser();
                //Username Nom Prenom
                $user->username =  $data[1] . ' ' . $data[0];
                $user->email =  $data[2];

                $user->Celluleid = Cellule::findByAXX($data[3])->id;
                $user->generatePasswordAndmail();
                $user->save();
            }
        } else {
            $bresult = ExitCode::NOINPUT;
        }




        return ExitCode::OK;
    }
}
