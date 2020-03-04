<?php

use dosamigos\chartjs\ChartJs;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */

$this->title = 'CAPATOOLS V2.0';


$Ctrls =  Yii::$app->discoverService->getServices();
$IndicateurCtrl = array();

//Pour chaque controller service on récupére la listes des actions filtrer par droit d'utilisateur (nom du service, priorité d'affichage, liste des actions)
foreach ($Ctrls as &$ctrl) {
    $Indicateur = $ctrl::GetIndicateur(Yii::$app->user);
    if (!empty($Indicateur) && $Indicateur != null) {
        array_unshift($IndicateurCtrl, $Indicateur);
    }
}


?>
<div class="materialize-index">

    <div class="jumbotron">
        <h1>Congratulations!</h1>

        <p class="lead">You are logged.</p>
        <p class="lead">TODO Show Dashboard</p>
        <p class="lead">

            <?php
            foreach ($IndicateurCtrl as $ind) {
                echo $ind['value'];
            }
            ?>
        </p>
    </div>



</div>
</div>