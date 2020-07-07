<?php

use app\assets\AppAsset;
use app\models\projects\Project;
use app\widgets\TopTitle;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\bootstrap\Html;
use yii\widgets\ActiveForm;

$this->title = 'Simulation de lot';

AppAsset::register($this);

?>

<?= TopTitle::widget(['title' => $this->title]) ?>
<div class="container">
    <div class="project-create">
        <?php $form = ActiveForm::begin(['id' => 'dynamic-form', 'options' => ['enctype' => 'multipart/form-data']]); ?>
        <div class="row">
            <div class="col s10 offset-s1">

                <!-- Card view basique -->
                <div class="card">

                    <div class="card-content">
                        <label>Simulation du lot</label>
                    </div>

                    <div class="card-action">

                        <!-- Détail du coût  -->
                        <label class='blue-text control-label typeLabel'>Détail du coût</label>

                        <!-- Marges -->
                        <label class='blue-text control-label typeLabel'>Marges</label>


                        <!-- Prix total du lot X -->
                        <label class='blue-text control-label typeLabel'>Prix du lot </label>
                        <?= Html::button("+", ['title' => "Topic", 'onclick' => 'console.log(\'toto\');', 'class' => 'waves-effect waves-light btn btn-white']) ?>
                        <?= Html::button("-", ['title' => "Topic", 'onclick' => 'console.log(\'toto\');', 'class' => 'waves-effect waves-light btn btn-white']) ?>



                        <!-- Buttons -->
                        <div class="form-group">
                            <?= Html::submitButton('Enregistrer <i class="material-icons right">save</i>', ['class' => 'waves-effect waves-light btn btn-blue']) ?>
                            <?= Html::a(Yii::t('app', 'Précédent'), ['#'], ['class' => 'waves-effect waves-light btn btn-grey']) ?>
                        </div>

                    </div>

                </div>

            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>