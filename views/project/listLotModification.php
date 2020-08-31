<?php


use app\assets\AppAsset;
use app\models\projects\Project;
use app\models\projects\Lot;
use app\assets\projects\ProjectModifLotAsset;
use app\widgets\TopTitle;
use kidzen\dynamicform\DynamicFormWidget;
use yii\bootstrap\Html;
use yii\widgets\ActiveForm;
use kartik\sortinput\SortableInput;

$this->title = 'Modification de la liste des lots';
$this->params['breadcrumbs'][] = $this->title;

AppAsset::register($this);
ProjectModifLotAsset::register($this);
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
                        <label>
                            <?= $model->internal_name ?></label>
                    </div>

                    <div class="card-action">

                        <!-- Création de lot -->

                        <div id="lot-management-body" class="col s12">
                            <div class="row">
                                <div class="input-field col s12">
                                    <?php
                                    // Scenario # 2: Advanced usage without ActiveForm or model and hide the stored value.
                                    // Style your sortable content and disable certain values in the list from sorting.
                                    echo SortableInput::widget([
                                        'name' => 'sort_list_1',
                                        'items' => [
                                            $lots[0]->number => ['content' =>  $form->field($lots[0], "title")->textInput(['autocomplete' => 'off', 'maxlength' => true])->label("Title") . '<i class="fas fa-cog"></i> '],
                                            $lots[1]->number => ['content' =>  $form->field($lots[1], "title")->textInput(['autocomplete' => 'off', 'maxlength' => true])->label("Title") . '<i class="fas fa-cog"></i> '],
                                            3 => ['content' => '<i class="fas fa-cog"></i> Item # 3'],
                                            4 => ['content' => '<i class="fas fa-cog"></i> Item # 4'],
                                            5 => ['content' => '<i class="fas fa-cog"></i> Item # 5', 'disabled' => true]
                                        ],
                                        'hideInput' => true,
                                    ]);
                                    ?>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="card-action">

                        <!-- Buttons -->
                        <div class="form-group">
                            <?= Html::submitButton('Enregistrer <i class="material-icons right">save</i>', ['class' => 'waves-effect waves-light btn btn-blue']) ?>
                            <?= Html::a(Yii::t('app', 'Annuler'), ['#'], ['class' => 'waves-effect waves-light btn btn-grey']) ?>
                        </div>

                    </div>

                </div>

            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>