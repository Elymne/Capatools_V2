<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\devis\Devis */

$this->title = 'Create Devis';
$this->params['breadcrumbs'][] = ['label' => 'Devis', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="devis-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
