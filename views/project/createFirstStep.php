<?php

use app\assets\AppAsset;
use app\assets\projects\ProjectCreateFirstStepAsset;
use app\models\projects\Project;
use app\widgets\TopTitle;
use kidzen\dynamicform\DynamicFormWidget;
use yii\bootstrap\Html;
use yii\widgets\ActiveForm;

AppAsset::register($this);
ProjectCreateFirstStepAsset::register($this);

$this->title = "Création d'un devis - Paramètres Généraux";
$this->params["breadcrumbs"][] = ["label" => "Project", "url" => ["index"]];
$this->params["breadcrumbs"][] = ["label" => $model->id, "url" => ["view", "id" => $model->id]];
$this->params["breadcrumbs"][] = "Update";
?>

<?= TopTitle::widget(["title" => $this->title]) ?>
<div class="container">
    <div class="project-create">
        <?php $form = ActiveForm::begin(["id" => "dynamic-form", "options" => ["enctype" => "multipart/form-data"]]); ?>
        <div class="row">
            <div class="col s10 offset-s1">

                <!-- Card view basique -->
                <div class="card">

                    <div class="card-content">
                        <label>Paramètres généraux</label>
                    </div>

                    <div class="card-action">
                        <div class="row">
                            <div class="col s12">
                                <label class="blue-text control-label topspace-4px">Titre du projet</label>
                                <?= $form->field($model, "internal_name")->textInput()->label(false) ?>
                            </div>
                        </div>
                    </div>

                    <div class="card-action" style="background-color: #f0f8ff;">
                        <!-- Type de projet  -->
                        <div class="row">
                            <div class="col s12">
                                <label class="blue-text control-label bottomspace-16px topspace-4px">Type de projet</label>
                                <?= $form->field($model, "combobox_type_checked")->radioList(Project::TYPES, [
                                    "item" => function ($index, $label, $name, $checked, $value) use ($model) {

                                        if ($index == $model->combobox_type_checked) $check = "checked";
                                        else $check = "";

                                        $return = "<label class='modal-radio'>";
                                        $return .= "<input " . $check . " type='radio' name='" . $name . "' value='" . $value . "' tabindex='3'>";
                                        $return .= "<span style='margin-right:24px;'>" . ucwords($label) . "</span>";
                                        $return .= "</label>";
                                        return $return;
                                    }
                                ])->label(false); ?>
                            </div>
                        </div>
                    </div>

                    <div class="card-action">
                        <!-- Création de lot -->
                        <div class="row">
                            <div class="col s12">

                                <label id="lot-management-label" class="blue-text control-label bottomspace-16px topspace-4px">Créer des lots (optionnel) - ils ne seront pas éditables par la suite</label>
                                <div id="lot-management-body">
                                    <div class="input-field col s12">

                                        <?php DynamicFormWidget::begin([
                                            "widgetContainer" => "dynamicform_wrapper", // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                                            "widgetBody" => ".container-items-task", // required: css class selector
                                            "widgetItem" => ".item", // required: css class
                                            "limit" => 10, // the maximum times, an element can be cloned (default 999)
                                            "min" => 0, // 0 or 1 (default 1)
                                            "insertButton" => ".add-item", // css class
                                            "deleteButton" => ".remove-item", // css class
                                            "model" => $lots[0],
                                            "formId" => "dynamic-form",
                                            "formFields" => ["title"],
                                        ]); ?>

                                        <div class="container-items-task">

                                            <div class="row">
                                                <div class="col s1 offset-s5">
                                                    <button id="button-lot-first-add" type="button" class="add-item btn waves-effect waves-light btn-grey main-button-margin"><i class="glyphicon glyphicon-plus"></i></button>
                                                </div>
                                            </div>

                                            <!-- widgetContainer -->
                                            <?php foreach ($lots as $i => $lot) : ?>
                                                <div class="item">

                                                    <?php if (!$lot->isNewRecord) : ?>
                                                        <?= Html::activeHiddenInput($lot, "[{$i}]id"); ?>
                                                    <?php endif; ?>

                                                    <div class="row">
                                                        <div class=" col m2 xl2 ">
                                                            <?= $form->field($lot, "[{$i}]id_string")->textInput(["autocomplete" => "off", "maxlength" => true, "readonly" => true, "value" => "Lot N° " . ($i + 1) . " "])->label(("")) ?>
                                                        </div>
                                                        <div class="col m7 xl8">
                                                            <?= $form->field($lot, "[{$i}]title")->textInput(["autocomplete" => "off", "placeholder" => "Titre du lot", "maxlength" => true])->label("") ?>
                                                        </div>
                                                        <div class="col m3 xl2">
                                                            <button type="button" class="add-item btn-floating waves-effect waves-light btn-grey"><i class="glyphicon glyphicon-plus"></i></button>
                                                            <button type="button" class="remove-item btn-floating waves-effect waves-light btn-grey"><i class="glyphicon glyphicon-minus"></i></button>
                                                        </div>
                                                    </div><!-- .row -->

                                                </div>
                                            <?php endforeach; ?>

                                        </div>
                                        <?php DynamicFormWidget::end(); ?>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="card-action" style="background-color: #f0f8ff;">

                        <div class="row">
                            <div class="col m12 l6">
                                <label class="blue-text">Nom de société</label>
                                <?= $form->field($model, "company_name")
                                    ->widget(\yii\jui\AutoComplete::class, [
                                        "clientOptions" => ["source" => $companiesNames,]
                                    ])->label(false); ?>
                            </div>

                            <div class="col m12 l6">
                                <label class="blue-text">Contact client</label>
                                <?= $form->field($model, "contact_email")
                                    ->widget(\yii\jui\AutoComplete::class, [
                                        "clientOptions" => [
                                            "source" => $contactsEmail,
                                        ],
                                    ])->label(false)
                                ?>
                            </div>
                        </div>

                    </div>

                    <div class="card-action">
                        <div class=" form-group">
                            <?= Html::submitButton("Suivant <i class='material-icons right'>arrow_forward</i>", ["class" => "waves-effect waves-light btn btn-blue", "title" => "Sauvegarde le brouillon et vous dirige vers l'étape suivante"]) ?>
                        </div>
                    </div>

                </div>

            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>