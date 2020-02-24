<?php

/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use yii\console\Controller;
use yii\console\ExitCode;

use app\models\user\Cellule;
use app\models\Devis\Devis;
use app\models\Devis\Company;


/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class LoadDevisController extends Controller
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
                $berreur = false;
                $devis = new Devis();
                //Username Nom Prenom
                // $user->id =  $data[0];
                $devis->id_capa =  $data[0];
                ///Protection d'erreur indication de la ligne d'erreur
                $devis->cellule_id = Cellule::findByAXX($data[1])->id;
                if ($berreur) {
                    echo 'Erreur Id cellule inconue : ' . implode(';', $data);
                } else {
                    $devis->filename_first_upload = $data[2];
                    $devis->filename_last_upload =  $data[3];

                    $company = new Company();
                    $company->description = $data[5];
                    $company->name = $data[4];
                    $company->tva = $data[6];
                    $company->save();
                    $devis->company_id = $company->id;
                    $devis->internal_name = $data[7];
                    ///Protection d'erreur indication de la ligne d'erreur
                    echo $data[8];
                    //$devis->capaidentity_id = Capaidentity::findByUsername($data[8])->id;
                    if ($berreur) {
                        echo 'Erreur Responsable projet inconnu : ' . implode(';', $data);
                    }
                    $devis->service_duration = $data[9];
                    $devis->version = $data[10];
                    $devis->filename = $data[11];
                    $devis->save();
                }
            }
        } else {
            $bresult = ExitCode::NOINPUT;
        }




        return ExitCode::OK;
    }
}
