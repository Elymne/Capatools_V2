<?php

use yii\widgets\ActiveForm;
use app\assets\AppAsset;
use app\assets\projects\RefactoringAsset as ProjectsRefactoringAsset;
use app\widgets\TopTitle;
use kartik\select2\Select2;
use yii\bootstrap\Html;

use yii\helpers\ArrayHelper;


/* @var $this yii\web\View */
/* @var $model app\models\devis\Devis */

$this->title = 'Création du projet à partir du devis';

AppAsset::register($this);
ProjectsRefactoringAsset::register($this);

?>

<?= TopTitle::widget(['title' => $this->title]) ?>


<div class="container">
    <div class="devis-update">

        <?php $form = ActiveForm::begin(['id' => 'dynamic-form', 'options' => ['enctype' => 'multipart/form-data']]); ?>
        <div class="row">

            <div class="col s10 offset-s1">

                <!-- Informations générales -->
                <div id="first-form-card" class="card">

                    <div class="card-content">
                        <label>Informations générales</label>
                    </div>

                    <div class="card-action">

                        <div class="col s12">
                            <div class="row">

                                <div class="input-field col s6">
                                    <?= $form->field($model, 'internal_name')
                                        ->textInput(['maxlength' => true, 'readonly' => true], ['autocomplete' => 'off'])
                                        ->label("Nom du projet")
                                    ?>
                                </div>
                                <div class="input-field col s6">
                                    <?= $form->field($model, 'id_laboxy')
                                        ->textInput(['maxlength' => true, 'readonly' => true], ['autocomplete' => 'off'])
                                        ->label("Référence interne du projet")
                                    ?>
                                </div>

                            </div>
                        </div>
                        <div class="col s12">
                            <div class="row">
                                <div class="input-field col s6">
                                    <?= $form->field($model, 'capa_user_id')->widget(
                                        Select2::classname(),
                                        [
                                            'theme' => Select2::THEME_MATERIAL,
                                            'name' => 'TaskContributor',
                                            'data' =>  ArrayHelper::map($celluleUsers, 'id', 'fullName'),
                                            'options' => ['placeholder' => 'Selectionner le responsable du projet ...'],
                                        ]
                                    )->label("Responsable projet"); ?>
                                </div>
                                <div class="input-field col s6">
                                    <?= $form->field($model, 'upfilename')->fileInput(['accept' => 'pdf/*'])->label('Document technique / Cahier des charges annexe (PDF)', [])

                                    ?>
                                </div>

                            </div>
                        </div>


                        <div class="col s12">
                            <div class="row">


                                <div class="input-field col s6">
                                    <?= $form->field($model, 'thematique')
                                        ->textInput(['maxlength' => true,], ['autocomplete' => 'off'])
                                        ->label("Thématique du projet")
                                    ?>
                                </div>

                                <div class="input-field col s6">
                                    <?= $form->field($model, 'signing_probability')->widget(
                                        Select2::classname(),
                                        [
                                            'theme' => Select2::THEME_MATERIAL,
                                            'name' => 'TaskContributor',
                                            'data' => ["10" => '10 %', "20" => '20 %', "30" => '30 %', "40" => '40 %', "50" => '50 %', "60" => '60 %', "70" => '70 %', "80" => '80 %', "90" => '90 %', "100" => '100 %'],
                                            'options' => ['placeholder' => 'Selectionner un pourcentage ...'],
                                        ]
                                    )->label("Probabilité de signature"); ?>
                                </div>

                            </div>
                        </div>
                        <div class="col s12">
                            <div class="row">


                                <div class="input-field col s6">
                                    <?= $form->field($model, "SellingPrice", ['inputOptions' => ['readonly' => true, 'value' => Yii::$app->formatter->asCurrency($model->SellingPrice)]])->label('Prix de vente du projet') ?>

                                </div>
                            </div>
                        </div>

                        <div class="col s12">
                            <div class="row">
                                <div class="input-field col s6">
                                    <div class="input-field col s1 "> <?= Html::submitButton('Enregistrer <i class="material-icons right">save</i>', ['class' => 'waves-effect waves-light btn btn-blue']) ?>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>

                </div>
            </div>

        </div>

    </div>
    <?php ActiveForm::end(); ?>

</div>
</div>