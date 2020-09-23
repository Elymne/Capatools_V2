<?php

use app\assets\AppAsset;
use app\models\projects\Project;
use app\assets\projects\ProjectSimulationAsset;
use app\widgets\TopTitle;
use yii\bootstrap\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\jui\DatePicker;
use kartik\select2\Select2;
use kidzen\dynamicform\DynamicFormWidget;
use yii\bootstrap\Alert;

$this->title = 'Simulation du projet';

$MargeAverage = $project->marginaverage;
$totalcostavplot = ($lotavp->total *  ($project->marginaverage / 100 + 1)) / (count($lots) - 1);
$totalprojet = 0.0;

AppAsset::register($this);
ProjectSimulationAsset::register($this);
?>

<?= TopTitle::widget(['title' => $this->title]) ?>



<!-- Gère les bandeaux d'alerts -->
<?php if ($SaveSucess != null) : ?>
    <?php if ($SaveSucess) : ?>
        <?= Alert::widget(['options' => ['class' => 'alert-success',], 'body' => 'Enregistrement réussi ...']) ?>
    <?php else : ?>
        <?= Alert::widget(['options' => ['class' => 'alert-danger',], 'body' => 'Enregistrement échoué ...',]) ?>
    <?php endif; ?>
<?php endif; ?>

<?php if ($tjmstatut == true) : ?>
    <?= Alert::widget(['options' => ['class' => 'alert-warning',], 'body' => 'Attention le taux journalier est inférieur à 700 €',]) ?>
<?php endif; ?>


<?php if ($validdevis == false) : ?>

    <?php foreach ($Resultcheck['lots'] as $lot) : ?>
        <?php if ($lot['Result'] == false) : ?>
            <?php if ($lot['number'] == 0) : ?>
                <?= Alert::widget(['options' => ['class' => 'alert-danger',], 'body' => ' Il n\'y a pas de tâche présente dans le l\'avant projet']) ?>
            <?php else : ?>
                <?= Alert::widget(['options' => ['class' => 'alert-danger',], 'body' => ' Il n\'y a pas de tâche présente dans le lot ' . $lot['number'],]); ?>
            <?php endif ?>
        <?php endif ?>
    <?php endforeach; ?>

    <?php if ($Resultcheck['millestone'] == false) : ?>
        <?= Alert::widget(['options' => ['class' => 'alert-danger',], 'body' => ' La somme des jalons ne correspond pas au prix de vente',]); ?>
    <?php endif; ?>

<?php endif; ?>

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

                        <table class="highlight">
                            <tbody>
                                <tr>
                                    <td width="30%" class="table-font-bold">Total coût temps homme :</td>
                                    <td><?= Yii::$app->formatter->asCurrency($lotavp->totalCostHuman) ?></td>
                                    <td width="30%" class="table-font-bold"></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td width="30%" class="table-font-bold">Total des dépenses et des investissement :</td>
                                    <td><?= Yii::$app->formatter->asCurrency($lotavp->totalCostInvest) ?></td>
                                    <td width="30%" class="table-font-bold"></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td width="30%" class="table-font-bold">Total des reversements laboratoires :</td>
                                    <td><?= Yii::$app->formatter->asCurrency($lotavp->totalCostRepayement) ?></td>
                                    <td width="30%" class="table-font-bold"></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td width="30%" class="table-font-bold">Total de l'avant projet (non margé):</td>
                                    <td><?= Yii::$app->formatter->asCurrency($lotavp->total) ?></td>
                                    <td width="30%" class="table-font-bold">Somme ajoutée par lot (margé avec le Taux moyen):</td>
                                    <td><?= Yii::$app->formatter->asCurrency($project->additionallotprice) ?></td>
                                </tr>
                            </tbody>
                        </table>

                        <div class="row top-spacing">
                            <?php if ($Resultcheck['lots'][0]['Result'] == false) : ?>
                                <label class="red-text control-label typeLabel"> Il n'y a pas de tâche présente dans l'avant projet</label>
                            <?php endif; ?>
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
                                        'title' => "Modifier les tâches"
                                    ]
                                ); ?>
                            </div>

                            <div class="col s1">
                                <?= Html::a(
                                    '<i class="material-icons center">local_grocery_store</i>',
                                    Url::to(['project/update-dependencies-consumables', 'number' => 0, 'project_id' => $project->id]),
                                    [
                                        'id' => 'grid-custom-button',
                                        'data-pjax' => true,
                                        'action' => Url::to(['project/update-dependencies-consumables', 'number' => 0, 'project_id' => $project->id]),
                                        'class' => 'btn-large waves-effect waves-light btn-blue tooltipped',
                                        'data-position' => "bottom",
                                        'title' => "Modifier les investissements, les consommables et le laboratoire"
                                    ]
                                ); ?>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card view basique -->
                <div class="card">

                    <div class="card-content">
                        <label>Résumé du projet</label>
                    </div>

                    <?php foreach ($lots as $lotproject) : ?>
                        <?php if ($lotproject->number != 0) : ?>
                            <div class="card-action">

                                <div class="row">
                                    <div class="col s12">
                                        <p class='lot-title blue-text control-label typeLabel bottom-spacing'> <?= $lotproject->title ?> </p>
                                    </div>
                                </div>

                                <table class="highlight">
                                    <tbody>
                                        <tr>
                                            <td width="30%" class="table-font-bold">Prix du total lot sans avp:</td>
                                            <td><?= Yii::$app->formatter->asCurrency($lotproject->totalwithmargin) ?></td>
                                            <td width="30%" class="table-font-bold">Prix du total lot avec avp :</td>
                                            <td><?= Yii::$app->formatter->asCurrency($lotproject->totalwithmargin + $project->additionallotprice) ?></td>
                                        </tr>
                                        <tr>
                                            <td width="30%" class="table-font-bold">Prix du total lot avec avp et support :</td>
                                            <td><?= Yii::$app->formatter->asCurrency(round(($lotproject->totalwithmargin + $project->additionallotprice) / (1 - $project->management_rate / 100), -2)) ?></td>
                                            <td width="30%" class="table-font-bold"></td>
                                            <td></td>
                                        </tr>
                                    </tbody>
                                </table>

                                <div class="row top-spacing">
                                    <?php if ($Resultcheck['lots'][$lotproject->number]['Result'] == false) : ?>
                                        <label class="red-text control-label typeLabel"> Il n'y a pas de tâche présente dans le l'avant projet</label>
                                    <?php endif; ?>
                                </div>

                                <div class="row">

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
                                                'title' => "Modifier les tâches"
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
                                                'title' => "Modifier les investissements, consommables, laboratoire"
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
                                                'title' => "Calcul marges et prix de vente client",
                                            ]
                                        ); ?>
                                    </div>

                                </div>

                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>

                </div>

                <!-- Card view basique -->
                <div class="card">

                    <div class="card-content">
                        <label>Bilan du projet</label>
                    </div>

                    <div class="card-action">

                        <?php if ($tjmstatut) : ?>
                            <?= Alert::widget(['options' => ['class' => 'alert-warning',], 'body' => 'Attention le taux journalier est inférieur à 700 €',]) ?>
                        <?php endif; ?>

                        <table class="highlight">
                            <tbody>
                                <tr>
                                    <td width="30%" class="table-font-bold">Montant Total HT :</td>
                                    <td><?= Yii::$app->formatter->asCurrency($project->total) ?></td>
                                    <td width="30%" class="table-font-bold">Taux journalier homme sans risque:</td>
                                    <td><?= Yii::$app->formatter->asCurrency($project->Tjm) ?></td>
                                </tr>
                                <tr>
                                    <td width="30%" class="table-font-bold">Taux de marge moyen avant frais de gestion:</td>
                                    <td><?= Yii::$app->formatter->asPercent($project->marginaverage / 100, 2) ?></td>
                                    <td width="30%" class="table-font-bold">Taux journalier homme avec risque:</td>
                                    <td><?= Yii::$app->formatter->asCurrency($project->tjmWithRisk) ?></td>
                                </tr>
                                <tr>
                                    <td width="30%" class="table-font-bold">Frais de gestion du support HT:</td>
                                    <td><?= Yii::$app->formatter->asCurrency($project->supportprice) ?></td>
                                    <td width="30%" class="table-font-bold"></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td width="30%" class="table-font-bold">Taux de marge moyen avant frais de gestion:</td>
                                    <td><?= Yii::$app->formatter->asPercent($project->marginaverage / 100, 2) ?></td>
                                    <td width="30%" class="table-font-bold"></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td width="30%" class="table-font-bold">Prix de vente du projet HT (€ arrondis):</td>
                                    <td id="projectsimulate-sellingprice"><?= Yii::$app->formatter->asCurrency($project->SellingPrice) ?></td>
                                    <td width="30%" class="table-font-bold"></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>

                        <table>
                            <tbody>
                                <tr>
                                    <td width="10%" class="table-font-bold">
                                        <?php if ($tjmstatut) : ?>
                                            Raison:
                                        <?php endif; ?>
                                    </td>
                                    <td width="20%">
                                        <?php if ($tjmstatut) : ?>
                                            <?=
                                                $form->field($project, "low_tjm_raison")->widget(
                                                    Select2::class,
                                                    [
                                                        'theme' => Select2::THEME_MATERIAL,
                                                        'data' => Project::TJMRAISON,
                                                        'name' => 'GestionRisk',
                                                        'pluginLoading' => false,
                                                        'options' => ['placeholder' => 'Raison...'],
                                                    ]
                                                )->label('')
                                            ?>
                                        <?php else : ?>
                                            <?= $form->field($project, "low_tjm_raison")->hiddeninput(['value' => $project::TJMRAISON_TJMOK])->label(''); ?>
                                        <?php endif; ?>
                                    </td>
                                    <td width="20%" class="table-font-bold left-scpacing-32px">
                                        <?php if ($tjmstatut) : ?>
                                            <div id="low_tjm_description-label">Décrivez la raison :</div>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if ($tjmstatut) : ?>
                                            <div id="projectsimulate-low_tjm_description"><?= $form->field($project, "low_tjm_description")->label('', ['id' => 'low_tjm_description-label']) ?></div>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                    </div>
                </div>

                <!-- Card view basique -->
                <div class="card">

                    <div class="card-content">
                        <label>Autres reversements</label>
                    </div>

                    <div class="card-action">

                        <div class="row bottom-spacing">
                            <div class="col s12">
                                <label class='blue-text control-label typeLabel'>Reversement Laboratoire</label>
                            </div>
                        </div>

                        <table class="highlight">
                            <tbody>
                                <?php foreach ($laboratorydepenses as $depense) : ?>
                                    <tr>
                                        <td width="40%" class="table-font-bold"><?= $laboratorylistArray[$depense['labo_id']] ?></td>
                                        <td><?= Yii::$app->formatter->asCurrency($depense['total']) ?></td>
                                        <td width="30%" class="table-font-bold"></td>
                                        <td></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>

                    </div>

                    <div class="card-action">

                        <div class="row">
                            <div class="col s12">
                                <label class='blue-text control-label typeLabel'>Prestation interne</label>
                            </div>
                        </div>

                        <table class="highlight">
                            <tbody>
                                <?php foreach ($listInternalDepense as $depense) : ?>
                                    <tr>
                                        <td width="40%" class="table-font-bold"><?= $depense['title'] ?></td>
                                        <td><?= Yii::$app->formatter->asCurrency($depense['total']) ?></td>
                                        <td width="30%" class="table-font-bold"></td>
                                        <td></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>

                    </div>
                    <div class="card-action">

                        <div class="row">
                            <div class="col s12">
                                <label class='blue-text control-label typeLabel'>Sous traitance externe</label>
                            </div>
                        </div>

                        <table class="highlight">
                            <tbody>
                                <?php foreach ($listExternalDepense as $depense) : ?>
                                    <tr>
                                        <td width="40%" class="table-font-bold"><?= $depense['title'] ?></td>
                                        <td><?= Yii::$app->formatter->asCurrency($depense['total']) ?></td>
                                        <td width="30%" class="table-font-bold"></td>
                                        <td></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>

                    </div>
                </div>

                <div class="card">

                    <div class="card-content">
                        <label>Echéancier prévisionnel</label>
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
                                            <div class="col s2">
                                                <?= $form->field($millestone, "[{$i}]estimate_date")->widget(DatePicker::class, [
                                                    'language' => 'fr',
                                                    'dateFormat' => 'dd-MM-yyyy',
                                                ])->label(('Date(jj-mm-yyyy)')) ?>
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
                        <?php
                        if ($Resultcheck['millestone'] == false) {
                            echo '<label class=\'red-text control-label typeLabel\'> La somme des jalons ne correspond pas au prix de vente</label>';
                        }
                        ?>

                    </div>

                    <div class="card-action">
                        <div class="form-group">
                            <div style="bottom: 50px; right: 25px;" class="fixed-action-btn direction-top">
                                <?= Html::a(
                                    Yii::t('app', '<i class="material-icons right">arrow_back</i>'),
                                    ['project/index-draft'],
                                    ['class' => 'waves-effect waves-light btn-floating btn-large btn-grey', 'title' => 'Retour à la liste des brouillons']
                                ) ?>
                                <?= Html::submitButton(
                                    '<i class="material-icons right">save</i>',
                                    ['class' => 'waves-effect waves-light btn-floating btn-large btn-blue', 'title' => 'Sauvegarder les options']
                                ) ?>
                                <?php
                                if ($validdevis) {
                                    echo Html::a(
                                        Yii::t('app', '<i class="material-icons right">check</i>'),
                                        ['project/create-project?id=' . $project->id],
                                        ['class' => 'waves-effect waves-light btn-floating btn-large btn-green', 'title' => 'Créer le projet']
                                    );
                                } else {
                                    echo Html::a(
                                        Yii::t('app', '<i class="material-icons right">check</i>'),
                                        null,
                                        ['class' => 'btn-floating btn-large disabled', 'title' => 'Créer le projet']
                                    );
                                }
                                ?>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>