<?php

use app\assets\AppAsset;
use app\models\projects\Project;
use app\assets\projects\ProjectSimulationAsset;
use app\widgets\TopTitle;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\bootstrap\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

use kartik\select2\Select2;

$this->title = 'Simulation du projet';

AppAsset::register($this);
ProjectSimulationAsset::register($this);

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
                        <label>Détail des coûts d'avant projet (hors marges)</label>
                    </div>

                    <div class="card-action">
                        <div class="row top-spacing">
                            <div class="col s3">
                                Total coût temps homme :
                            </div>
                            <div class="col s2">
                                <?= $form->field($lotavp, "totalCostHuman", ['inputOptions' => ['readonly' => true, 'value' => Yii::$app->formatter->asCurrency($lotavp->totalCostHuman)]])->label(false) ?>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col s3">
                                Total des dépenses et investissement :
                            </div>
                            <div class="col s2">
                                <?= $form->field($lotavp, "totalCostInvest", ['inputOptions' => ['readonly' => true, 'value' => Yii::$app->formatter->asCurrency($lotavp->totalCostInvest)]])->label(false) ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col s3">
                                Total des reversements laboratoires :
                            </div>
                            <div class="col s2">
                                <?= $form->field($lotavp, "totalCostRepayement", ['inputOptions' => ['readonly' => true, 'value' => Yii::$app->formatter->asCurrency($lotavp->totalCostRepayement)]])->label(false) ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col s3">
                                Total de l'avant projet (non margé):
                            </div>
                            <div class="col s2">
                                <?= $form->field($lotavp, "total", ['inputOptions' => ['readonly' => true, 'value' => Yii::$app->formatter->asCurrency($lotavp->total)]])->label(false) ?>
                            </div>
                            <div class="col s3">
                                Somme ajoutée par lot (margé avec le Taux moyen):
                            </div>
                            <div class="col s2">
                                <?= $form->field($project, "additionallotprice", ['inputOptions' => ['readonly' => true, 'value' => Yii::$app->formatter->asCurrency($project->additionallotprice)]])->label(false) ?>
                            </div>
                        </div>
                        <div class="row bottom-spacing">
                            <div class="col s1">
                                <?= Html::a(
                                    '<i class="material-icons center">create</i>',
                                    Url::to(['project/update-task', 'number' => 0, 'project_id' => $project->id]),
                                    [
                                        'id' => 'grid-custom-button',
                                        'data-pjax' => true,
                                        'action' => Url::to(['project/update-task', 'number' => 0, 'project_id' => $project->id]),
                                        'class' => 'btn-large waves-effect waves-light btn-blue tooltipped',
                                        'data-position' => "bottom",
                                        'data-tooltip' => "Modifier les tâches"
                                    ]
                                ); ?>


                            </div>
                        </div>

                    </div>
                </div>


                <!-- Card view basique -->
                <div class="card">

                    <div class="card-content">
                        <label>Résumé du projet </label>
                        <label> (+ coûts d'avant-projet intégré dans chaque lot)</label>
                    </div>

                    <?php
                    $MargeAverage = $project->marginaverage;
                    $totalcostavplot = ($lotavp->total *  ($project->marginaverage / 100 + 1)) / (count($lots) - 1);
                    $totalprojet = 0.0

                    ?>

                    <?php foreach ($lots as $lotproject) {
                        if ($lotproject->number != 0) {
                    ?>
                            <div class="card-action">

                                <div class="row">

                                    <div class="col s12">
                                        <p class='lot-title blue-text control-label typeLabel top-spacing bottom-spacing'> <?= $lotproject->title ?> </p>
                                    </div>

                                    <div class="col s12">
                                        <!-- Détail du coût  -->
                                        <b>Prix du total lot :</b>
                                    </div>
                                    <div class="col s3">
                                        <!-- Détail du coût  -->
                                        <?= Html::input('text', '', Yii::$app->formatter->asCurrency($lotproject->totalwithmargin + $project->additionallotprice), $options = ['autocomplete' => 'off', 'maxlength' => true, 'readonly' => true, 'format' => 'currency']) ?>
                                    </div>
                                </div>

                                <div class="row top-spacing bottom-spacing">
                                    <div class="col s1">
                                        <?= Html::a(
                                            '<i class="material-icons center">create</i>',
                                            Url::to(['project/update-task', 'number' =>  $lotproject->number, 'project_id' => $project->id]),
                                            [
                                                'id' => 'grid-custom-button',
                                                'data-pjax' => true,
                                                'action' => Url::to(['project/update-task', 'number' => $lotproject->number, 'project_id' => $project->id]),
                                                'class' => 'btn-large waves-effect waves-light btn-blue tooltipped',
                                                'data-position' => "bottom",
                                                'data-tooltip' => "Modifier les tâches"
                                            ]
                                        ); ?>


                                    </div>
                                    <div class="col s1">
                                        <?= Html::a(
                                            '<i class="material-icons center">local_grocery_store</i>',
                                            Url::to(['project/update-dependencies-consumables', 'number' =>  $lotproject->number, 'project_id' => $project->id]),
                                            [
                                                'id' => 'grid-custom-button',
                                                'data-pjax' => true,
                                                'action' => Url::to(['project/Update-task', 'number' => $lotproject->number, 'project_id' => $project->id]),
                                                'class' => 'btn-large waves-effect waves-light btn-blue tooltipped',
                                                'data-position' => "bottom",
                                                'data-tooltip' => "Modifier les investissements/Consomable/Laboratoire"
                                            ]
                                        ); ?>
                                    </div>
                                    <div class="col s1">
                                        <?= Html::a(
                                            '<i class="material-icons center">euro_symbol</i>',
                                            Url::to(['project/lot-simulate', 'number' =>  $lotproject->number, 'project_id' => $project->id]),
                                            [
                                                'id' => 'grid-custom-button',
                                                'data-pjax' => true,
                                                'action' => Url::to(['project/lot-simulate', 'number' => $lotproject->number, 'project_id' => $project->id]),
                                                'class' => 'btn-large waves-effect waves-light btn-blue tooltipped',
                                                'data-position' => "bottom",
                                                'data-tooltip' => "Modifier les marges",
                                            ]
                                        ); ?>
                                    </div>
                                </div>
                            </div>

                    <?php
                        }
                    } ?>

                </div>


                <!-- Card view basique -->
                <div class="card">

                    <div class="card-content">
                        <label>Bilan du projet</label>
                    </div>

                    <div class="card-action">

                        <div class="row top-spacing">
                            <div class="col s3">
                                Montant Total HT :
                            </div>
                            <div class="col s2">
                                <?= $form->field($project, "total", ['inputOptions' => ['readonly' => true, 'value' => Yii::$app->formatter->asCurrency($project->total)]])->label(false) ?>
                            </div>
                            <div class="col s3">
                                Taux journalier homme sans risque:
                            </div>
                            <div class="col s2">
                                <?= $form->field($project, "tjm", ['inputOptions' => ['readonly' => true, 'value' => Yii::$app->formatter->asCurrency($project->Tjm)]])->label(false) ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col s3">
                                Taux de marge moyen avant frais de gestion:
                            </div>
                            <div class="col s2">
                                <?= $form->field($project, "marginaverage", ['inputOptions' => ['readonly' => true, 'value' => Yii::$app->formatter->asPercent($project->marginaverage / 100, 2)]])->label(false) ?>
                            </div>
                            <div class="col s3">
                                Taux journalier homme avec risque:
                            </div>
                            <div class="col s2">
                                <?= $form->field($project, "tjmWithRisk", ['inputOptions' => ['readonly' => true, 'value' => Yii::$app->formatter->asCurrency($project->tjmWithRisk)]])->label(false) ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col s3">
                                Frais de gestion du support HT:
                            </div>
                            <div class="col s2">
                                <?= $form->field($project, "supportprice", ['inputOptions' => ['readonly' => true, 'value' => Yii::$app->formatter->asCurrency($project->supportprice)]])->label(false)  ?>
                            </div>
                            <div class="col s5">
                                <?php if ($tjmstatut) { ?>
                                    <label class='orange-text control-label typeLabel'> Attention le taux journalier est inférieur à 700 €</label>
                                <?php  } ?>
                            </div>
                        </div>
                        <div class="row bottom-spacing">
                            <div class="col s3">
                                Prix de vente du projet HT (€ arrondis):
                            </div>
                            <div class="col s2">
                                <?= $form->field($project, "SellingPrice", ['inputOptions' => ['readonly' => true, 'value' => Yii::$app->formatter->asCurrency($project->SellingPrice)]])->label(false) ?>
                            </div>
                            <div class="col s3">
                                <?php if ($tjmstatut) { ?>
                                    Raison:
                                <?php  } ?>
                            </div>
                            <div class="col s2">
                                <?php
                                if ($tjmstatut) {
                                    echo $form->field($project, "low_tjm_raison")->widget(
                                        Select2::classname(),
                                        [
                                            'theme' => Select2::THEME_MATERIAL,
                                            'data' => Project::TJMRAISON,
                                            'name' => 'GestionRisk',
                                            'pluginLoading' => false,
                                            'options' => [
                                                'placeholder' => 'Raison...',
                                            ],
                                        ]
                                    )->label(false);
                                } else {
                                    echo  $form->field($project, "low_tjm_raison")->hiddeninput(['value' => $project::TJMRAISON_TJMOK])->label('');
                                } ?>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="card">

                    <div class="card-content">
                        <label>Coût Externe</label>
                    </div>

                    <div class="card-action">

                        <div class="row  bottom-spacing">
                            <div class="col s3">
                                <label class='blue-text control-label typeLabel'> Reversement interne :</label>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col s3">
                                Cellule 1 :
                            </div>
                            <div class="col s2">
                                <?= $form->field($project, "marginaverage", ['inputOptions' => ['readonly' => true, 'value' => Yii::$app->formatter->asPercent($project->marginaverage / 100, 2)]])->label(false) ?>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col s3">
                                Cellule 2 :
                            </div>
                            <div class="col s2">
                                <?= $form->field($project, "marginaverage", ['inputOptions' => ['readonly' => true, 'value' => Yii::$app->formatter->asPercent($project->marginaverage / 100, 2)]])->label(false) ?>
                            </div>
                        </div>

                    </div>
                    <div class="card-action">

                        <div class="row bottom-spacing">
                            <div class="col s3">
                                <label class='blue-text control-label typeLabel'> Reversement Laboratoire :</label>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col s3">
                                Labo 1 :
                            </div>

                            <div class="col s2">
                                <?= $form->field($project, "marginaverage", ['inputOptions' => ['readonly' => true, 'value' => Yii::$app->formatter->asPercent($project->marginaverage / 100, 2)]])->label(false) ?>
                            </div>
                        </div>

                    </div>
                    <div class="card-action">

                        <div class="row bottom-spacing">
                            <div class="col s3">
                                <label class='blue-text control-label typeLabel'> Reversement Externe :</label>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col s3">
                                Capgemini :
                            </div>
                            <div class="col s2">
                                <?= $form->field($project, "marginaverage", ['inputOptions' => ['readonly' => true, 'value' => Yii::$app->formatter->asPercent($project->marginaverage / 100, 2)]])->label(false) ?>
                            </div>

                        </div>
                    </div>
                </div>


                <div class="card">

                    <div class="card-content">
                        <label>Facturation</label>
                    </div>

                    <div class="card-action">
                        <div class="row top-spacing bottom-spacing">

                            <?php DynamicFormWidget::begin([
                                'widgetContainer' => 'dynamicform_millestone', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                                'widgetBody' => '.container-items-millestone', // required: css class selector
                                'widgetItem' => '.item-millestone', // required: css class
                                'limit' => 10, // the maximum times, an element can be cloned (default 999)
                                'min' => 1, // 0 or 1 (default 1)
                                'insertButton' => '.add-item-millestone', // css class
                                'deleteButton' => '.remove-item-millestone', // css class
                                'model' => $millestones[0],
                                'formId' => 'dynamic-form',
                                'formFields' => [
                                    'pourcentage',
                                ],
                            ]); ?>
                            <div class="container-items-millestone">
                                <!-- widgetContainer -->
                                <?php foreach ($millestones as $i => $millestone) : ?>
                                    <div class="item-millestone">

                                        <?php
                                        // necessary for update action.
                                        if (!$millestone->isNewRecord) {
                                            echo Html::activeHiddenInput($millestone, "[{$i}]id");
                                        }
                                        ?>
                                        <div class="row">
                                            <div class="col s0">
                                                <?= Html::activeHiddenInput($millestone, "[{$i}]number"); ?>
                                            </div>
                                            <div class="col s3">
                                                <?= $form->field($millestone, "[{$i}]comment")->textInput(['autocomplete' => 'off', 'maxlength' => true,])->label("Titre") ?>

                                            </div>
                                            <div class="col s2">
                                                <?= $form->field($millestone, "[{$i}]pourcentage")->textInput(['autocomplete' => 'off', 'maxlength' => true,])->label("Pourcentage") ?>
                                            </div>
                                            <div class="col s2">
                                                <?= $form->field($millestone, "[{$i}]priceeuros")->textInput(['autocomplete' => 'off', 'maxlength' => true, 'value' => Yii::$app->formatter->asCurrency($millestones[$i]->price)])->label("Prix") ?>
                                                <?= Html::activeHiddenInput($millestone, "[{$i}]price") ?>
                                            </div>
                                            <div class="col 2">
                                                <button type="button" class="add-item-millestone btn-floating waves-effect waves-light btn-grey"><i class="glyphicon glyphicon-plus"></i></button>
                                            </div>
                                            <div class="col 2">
                                                <button type="button" class="remove-item-millestone btn-floating waves-effect waves-light btn-grey"><i class="glyphicon glyphicon-minus"></i></button>
                                            </div>
                                        </div>

                                    </div>
                                <?php endforeach; ?>
                            </div>

                            <?php DynamicFormWidget::end(); ?>
                        </div>
                    </div>

                    <div class="card-action">
                        <!-- Buttons -->
                        <div class="form-group">
                            <?= Html::submitButton('Enregistrer <i class="material-icons right">save</i>', ['class' => 'waves-effect waves-light btn btn-blue']) ?>

                            <?php
                            if ($validdevis) {
                                echo Html::a(Yii::t('app', 'Créer le projet'), ['#'], ['class' => 'waves-effect waves-light btn btn-blue']);
                            } else {
                                echo Html::a(Yii::t('app', 'Créer le projet'), null, ['class' => 'btn  disabled ']);
                            }
                            ?>
                        </div>
                    </div>
                </div>


            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>