<?php

use app\widgets\TopTitle;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\user\CapaUser */
/* @var $cellules app\models\devis\Cellule */

$this->title = 'Mise à jour de l\'utilisateur: ' . $model->username;
$this->params['breadcrumbs'][] = ['label' => 'Capaidentities', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>

<?= TopTitle::widget(['title' => $this->title]) ?>

<div class="container">
    <div class="capa_user-update">

        <div class="row">
            <div class="col s6 offset-s3">

                <div class="card">
                    <div class="card-content">

                        <?= $this->render('_form', [
                            'model' => $model,
                            'cellules' => $cellules
                        ]) ?>

                    </div>
                </div>

            </div>
        </div>

    </div>
</div>