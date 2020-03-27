<?php

use app\widgets\TopTitle;



/* @var $this yii\web\View */
/* @var $model app\models\user\CapaUser */

$this->title = 'Création d\'un salarié';
$this->params['breadcrumbs'][] = ['label' => 'Capaidentities', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?= TopTitle::widget(['title' => $this->title]) ?>

<div class="container">
    <div class="capa_user-create">

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