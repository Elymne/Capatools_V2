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
?>

<?= TopTitle::widget(["title" => $this->title]) ?>
<div class="container">
    <div class="project-create">
        <?php $form = ActiveForm::begin(["id" => "dynamic-form", "options" => ["enctype" => "multipart/form-data"]]); ?>
        <div class="row">
            <div class="col s10 offset-s1">
                <!-- Card view PARAMTRES GENERAUX -->
                <div class="card">
                    <!-- HEADER CARD -->
                    <div class="card-content">
                        <label>Paramètres généraux</label>
                    </div>
                    <!-- BODY CARD -->
                    <div class="card-action">
                        <div class="row">
                            <div class="col s12">
                                <?= $form->field($model, "internal_name")->textInput()->label("Titre du projet") ?>
                            </div>
                        </div>
                    </div>
                    <!-- BODY CARD -->
                    <div class="card-action" style="background-color: #f0f8ff;">
                        <!-- Type de projet  -->
                        <div class="row">
                            <div class="col s12">
                                <?= $form->field($model, "radiobutton_type_selected")->radioList(Project::TYPES, [
                                    "item" => function ($index, $label, $name, $checked, $value) use ($model) {
                                        if ($value == $model->radiobutton_type_selected) $check = "checked";
                                        else $check = "";
                                        $return = "<label class='modal-radio'>";
                                        $return .= "<input " . $check . " type='radio' name='" . $name . "' value='" . $value . "' tabindex='3'>";
                                        $return .= "<span style='margin-right:24px;'>" . ucwords($label) . "</span>";
                                        $return .= "</label>";
                                        return $return;
                                    }
                                ])->label("Type de projet"); ?>
                            </div>
                        </div>
                    </div>
                    <!-- BODY CARD -->
                    <?php if ($showlot) : ?>
                        <div class="card-action">
                            <!-- Création de lot -->
                            <div class="row">
                                <div class="col s12">
                                    <label id="lot-management-label" class="control-label">Créer des lots (optionnel) - ils ne seront pas éditables par la suite</label>
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
                                                <!-- widgetContainer -->
                                                <?php foreach ($lots as $i => $lot) : ?>
                                                    <div class="item">
                                                        <div class="card">
                                                            <div class="card-item">
                                                                <?php if (!$lot->isNewRecord) : ?>
                                                                    <?= Html::activeHiddenInput($lot, "[{$i}]id"); ?>
                                                                <?php endif; ?>
                                                                <div class="row">
                                                                    <div class=" col m2 xl2 ">
                                                                        <?= $form->field($lot, "[{$i}]id_string")->textInput(["autocomplete" => "off", "maxlength" => true, "readonly" => true, "value" => "Lot N° " . ($i + 1) . " "])->label(false) ?>
                                                                    </div>
                                                                    <div class="col m7 xl9">
                                                                        <?= $form->field($lot, "[{$i}]title")->textInput(["autocomplete" => "off", "placeholder" => "Titre du lot", "maxlength" => true])->label(false) ?>
                                                                    </div>
                                                                    <div class="col m3 xl1">
                                                                        <button type="button" class="remove-item btn-flat remove-item-button-type"><i class="glyphicon glyphicon-trash"></i></button>
                                                                    </div>
                                                                </div><!-- .row -->
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endforeach; ?>

                                            </div>
                                            <div class="col s12">
                                                <p class="add-item add-item-link-type">Ajouter un nouveau lot à ce devis</p>
                                            </div>
                                            <?php DynamicFormWidget::end(); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                    <!-- BODY CARD -->
                    <div class="card-action" <?php if ($showlot) : ?>style="background-color: #f0f8ff;" <?php endif; ?>>
                        <div class="row">
                            <div class="col m12 l6">
                                <?= $form->field($model, "company_name")
                                    ->widget(\yii\jui\AutoComplete::class, [
                                        "clientOptions" => ["source" => $companiesNames,]
                                    ])->label("Nom de société"); ?>
                            </div>
                            <div class="col m12 l6">
                                <?= $form->field($model, "contact_email")
                                    ->widget(\yii\jui\AutoComplete::class, [
                                        "clientOptions" => [
                                            "source" => $contactsEmail,
                                        ],
                                    ])->label("Contact client")
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Card view END -->
                <!-- FORM BUTTONS-->
                <div class=" to-the-right">
                    <?= Html::submitButton("Suivant <i class='material-icons right'>arrow_forward</i>", ["class" => "waves-effect waves-light btn btn-blue", "title" => "Sauvegarde le brouillon et vous dirige vers l'étape suivante"]) ?>
                </div>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>