<?php

use app\assets\AppAsset;
use app\widgets\TopTitle;
use yii\widgets\ActiveForm;

$this->title = 'Création d\'un projet - liste des dépenses et reversements : Lot n°?';

AppAsset::register($this);

?>

<?= TopTitle::widget(['title' => $this->title]) ?>
<div class="container">
    <div class="project-create">
        <?php $form = ActiveForm::begin(['id' => 'dynamic-form', 'options' => ['enctype' => 'multipart/form-data']]); ?>
        <div class="row">
            <div class="col s12">

                <!-- Card : Gestion des consonmmables -->
                <div class="card">

                    <div class="card-content">
                        <label>Dépenses</label>
                    </div>

                    <div class="card-action">

                    </div>

                </div>


                <!-- Card : Gestion des reversements -->
                <div class="card">

                    <div class="card-content">
                        <label>Reversements Labo</label>
                    </div>

                    <div class="card-action">

                    </div>

                </div>


            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>