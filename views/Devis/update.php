<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\devis\Devis */

$this->title = 'Mise à jour du devis' ;
$this->params['breadcrumbs'][] = ['label' => 'Devis', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="devis-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,'type' =>'update',
    ]) ?>

</div>
