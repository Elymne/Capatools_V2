<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\user\Cellule;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;
use  yii\data\ArrayDataProvider;
use app\models\user\userrightapplication;

///Récupère la liste des cellules

$value = Cellule::find()->all();

$Listcellule = ArrayHelper::map($value, 'id', 'name');
asort($Listcellule);

if ($model->cellule != null) {
    $comboxselect = $model->cellule->name;
} else {
    $comboxselect = 'Choisir la cellule ...';
}

//$model->userrightapplication['Administration'];
//Pour chaque controller service on récupère la listes des droits possibles

$Services = Yii::$app->DiscoverService->getServices();
$ArrayserviceRight = array();

foreach ($Services as &$service) {
    $ListRight = $service::GetRight();
    if (!empty($ListRight) && $ListRight != null) {
        $result[$ListRight['name']] = $ListRight;
    }
}

/* @var $this yii\web\View */
/* @var $model app\models\user\CapaUser */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="capa_user-form">

    <?php $form = ActiveForm::begin([
        'fieldConfig' => [
            'labelOptions' => ['class' => 'blue-text control-label'],
        ],
    ]); ?>


    <?= $form->field($model, 'username')->textInput(['maxlength' => true, 'placeholder' => 'Nom et prénom'])->label('Nom de l\'utilisateur :') ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true, 'placeholder' => 'Email capacités'])->label('Email :') ?>

    <?= $form->field($model, 'Celluleid')->dropDownList($Listcellule, ['prompt' => $comboxselect])->label('Nom de la cellule :');   ?>

    <?php
    $data = array();
    foreach ($result as  $application) {
        $stringpromp = 'Aucun';
        //Je recherche la valeur de l'utilisateur pour l'application
        $key = array_search($application['name'], array_column($model->userrightapplication, 'Application'));

        if (!is_bool($key)) {

            $stringpromp = $model->userrightapplication[$key]->Credential;
        }

        //Je génére les différents champs pour l'affichage
        $value = $form->field($model, 'userrightapplication[' . $application['name'] . ']')->dropDownList($application['right'], ['text' => 'Please select', 'options' => array($stringpromp => array('selected' => true))])->label('');
        $arr  = ['name' => $application['name'], 'link' => $value];
        array_unshift($data, $arr);
    }


    $Rightprovider = new ArrayDataProvider([
        'allModels' => $data,

    ]);

    //J'affiche le tableau des éléments
    echo GridView::widget([
        'dataProvider' => $Rightprovider,
        'columns' => [
            [
                'label' => 'Service',
                'attribute' => 'name',
                'format' => 'text'
            ],
            [

                'label' => 'Statut',
                'attribute' => 'link',
                'format' => 'raw'
            ],
        ],

    ]);
    ?>
    <div class="form-group">
        <?= Html::submitButton('Enregistrer <i class="material-icons right">save</i>', ['class' => 'btn waves-effect waves-light']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>