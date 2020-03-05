<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\user\Cellule;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;
use  yii\data\ArrayDataProvider;

///Récupère la liste des cellules

$value = Cellule::find()->all();

$cellules = ArrayHelper::map($value, 'id', 'name');
asort($cellules);

if ($model->cellule != null) {
    $comboxselect = $model->cellule->name;
} else {
    $comboxselect = 'Choisir la cellule ...';
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

    <?= $form->field($model, 'cellule_id')->dropDownList($cellules, ['prompt' => $comboxselect])->label('Nom de la cellule :');   ?>

    <?php
    $data = array();
    foreach ($results as $result) {
        $stringpromp = 'none';
        //Je recherche la valeur de l'utilisateur pour l'application
        $key = array_search($result['name'], array_column($model->userRole, 'service'));

        if (!is_bool($key)) {
            $stringpromp = $model->userRole[$key]->role;
        }

        //Je génére les différents champs pour l'affichage
        $value = $form->field($model, 'userRole[' . $result['name'] . ']')->dropDownList($result['right'], ['text' => 'Please select', 'options' => array($stringpromp => array('selected' => true))])->label('');
        $arr  = ['name' => $result['name'], 'link' => $value];
        array_unshift($data, $arr);
    }


    $rightProvider = new ArrayDataProvider([
        'allModels' => $data,

    ]);

    //J'affiche le tableau des éléments
    echo GridView::widget([
        'dataProvider' => $rightProvider,
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