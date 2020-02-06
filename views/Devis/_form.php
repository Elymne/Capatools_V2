<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;

use yii\widgets\ActiveForm;

use \app\models\devis\Client;
use \app\models\devis\ProjectManager;
use \app\models\devis\Unit;

$client = ArrayHelper::map(Client::getAll(), 'id', 'name');
$projectManager = ArrayHelper::map(ProjectManager::getAll(), 'id', 'fullname');
$units = ArrayHelper::map(Unit::getAll(), 'id', 'name');

?>


<div class="form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($query, 'internal_name')->textInput(['maxlength' => true])->label('Nom interne du devis') ?>

    <div class="form-group">
        <?= Html::submitButton('Confirmer', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>