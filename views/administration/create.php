<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\user\CapaUser */

$this->title = 'Création d\'un salarié';
$this->params['breadcrumbs'][] = ['label' => 'Capaidentities', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="capa_user-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>