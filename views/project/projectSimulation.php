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

$this->title = 'Simulation du projet ' . $project->internal_name;

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

<div class="container">
    <div class="project-create">
        <?php $form = ActiveForm::begin(['id' => 'dynamic-form', 'options' => ['enctype' => 'multipart/form-data']]); ?>
        <div class="row">
            <div class="col s12">

                <!-- Card view basique : AVANT-PROJET -->
                <div class="card">

                    <div class="card-content">
                        <label>Détail des coûts d'avant projet (hors marges)</label>
                    </div>

                    <div class="card-action">

                        <div class="row bottom-spacing">

                            <?php if (($Resultcheck['lots'][0]['Result'] == false) && $project->first_in == 1) : ?>
                                <?= Alert::widget(['options' => ['class' => 'alert-warning',], 'body' => ' Il n\'y a pas de tâche présente dans l\'avant projet']) ?>
                            <?php endif; ?>

                            <div class="col s12 l6">
                                <table class="highlight">
                                    <tbody>
                                        <tr>
                                            <td width="90%" class="table-font-bold">Total coût temps homme :</td>
                                            <td><?= Yii::$app->formatter->asCurrency($lotavp->totalCostHuman) ?></td>
                                        </tr>
                                        <tr>
                                            <td width="90%" class="table-font-bold">Total des dépenses et des investissement :</td>
                                            <td><?= Yii::$app->formatter->asCurrency($lotavp->totalCostInvest) ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="col s12 l6">
                                <table class="highlight">
                                    <tbody>
                                        <tr>
                                            <td width="90%" class="table-font-bold">Total de l'avant projet (non margé):</td>
                                            <td><?= Yii::$app->formatter->asCurrency($lotavp->total) ?></td>
                                        </tr>
                                        <tr>
                                            <td width="90%" class="table-font-bold">Total des reversements laboratoires :</td>
                                            <td><?= Yii::$app->formatter->asCurrency($lotavp->totalCostRepayement) ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="col s12 l6">
                                <table class="highlight">
                                    <tbody>
                                        <tr>
                                            <td width="90%" class="table-font-bold">Somme ajoutée par lot (margé avec le Taux moyen):</td>
                                            <td><?= Yii::$app->formatter->asCurrency($project->additionallotprice) ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                        </div>

                        <div class="row top-spacing">

                            <div class="col s2">
                                <?= Html::a(
                                    '<span>Ajouter des tâches</span>',
                                    Url::to(['project/update-task', 'number' => 0, 'project_id' => $project->id]),
                                    [
                                        'id' => 'grid-custom-button',
                                        'data-pjax' => true,
                                        'action' => Url::to(['project/update-task', 'number' => 0, 'project_id' => $project->id]),
                                        'class' => 'btn-large waves-effect waves-light btn-blue tooltipped',
                                        'data-position' => "bottom",
                                        'title' => "Permet de créer, modifier, supprimer des tâche"
                                    ]
                                ); ?>
                            </div>

                            <div class="col s2">
                                <?= Html::a(
                                    '<span>Gérer les dépenses</span>',
                                    Url::to(['project/update-dependencies-consumables', 'number' => 0, 'project_id' => $project->id]),
                                    [
                                        'id' => 'grid-custom-button',
                                        'data-pjax' => true,
                                        'action' => Url::to(['project/update-dependencies-consumables', 'number' => 0, 'project_id' => $project->id]),
                                        'class' => 'btn-large waves-effect waves-light btn-blue tooltipped',
                                        'data-position' => "bottom",
                                        'title' => "Permet de créer les consommables et investissements ainsi que de gérer les matériels laboratoires et les contributeurs"
                                    ]
                                ); ?>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Card view basique : PROJETS -->
                <div class="card">

                    <div style="background-color: #2A2B36;" class="card-content">
                        <label>Résumé du projet</label>
                    </div>

                    <?php foreach ($lots as $lotproject) : ?>
                        <?php if ($lotproject->number != 0) : ?>
                            <div class="card-action">

                                <div class="row bottom-spacing">

                                    <?php if ($Resultcheck['lots'][$lotproject->number]['Result'] == false  && $project->first_in == 1) : ?>
                                        <?= Alert::widget(['options' => ['class' => 'alert-warning',], 'body' => ' Il n\'y a pas de tâche présente dans ce lot ']); ?>
                                    <?php endif; ?>

                                    <div class="col s12">
                                        <p class='lot-title blue-text control-label typeLabel bottom-spacing'> <?= $lotproject->title ?> </p>
                                    </div>

                                    <div class="col s12 l6 xl4">
                                        <table class="highlight">
                                            <tbody>
                                                <tr>
                                                    <td width="90%" class="table-font-bold">Prix du total lot sans avp:</td>
                                                    <td><?= Yii::$app->formatter->asCurrency($lotproject->totalwithmargin) ?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="col s12 l6 xl4">
                                        <table class="highlight">
                                            <tbody>
                                                <tr>
                                                    <td width="90%" class="table-font-bold">Prix du total lot avec avp :</td>
                                                    <td><?= Yii::$app->formatter->asCurrency($lotproject->totalwithmargin + $project->additionallotprice) ?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="col s12 l6 xl4">
                                        <table class="highlight">
                                            <tbody>
                                                <tr>
                                                    <td width="90%" class="table-font-bold">Prix du total lot avec avp et support :</td>
                                                    <td><?= Yii::$app->formatter->asCurrency(round(($lotproject->totalwithmargin + $project->additionallotprice) / (1 - $project->management_rate / 100), -2)) ?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                </div>

                                <div class="row top-spacing">

                                    <div class="col s2">
                                        <?= Html::a(
                                            '<span>Ajouter des tâches</span>',
                                            Url::to(['project/update-task', 'number' =>  $lotproject->number, 'project_id' => $project->id]),
                                            [
                                                'id' => 'grid-custom-button',
                                                'data-pjax' => true,
                                                'action' => Url::to(['project/update-task', 'number' => $lotproject->number, 'project_id' => $project->id]),
                                                'class' => 'btn-large waves-effect waves-light btn-blue tooltipped',
                                                'data-position' => "bottom",
                                                'title' => "Permet de créer, modifier, supprimer des tâche"
                                            ]
                                        ); ?>
                                    </div>

                                    <div class="col s2">
                                        <?= Html::a(
                                            '<span>Gérer les dépenses</span>',
                                            Url::to(['project/update-dependencies-consumables', 'number' =>  $lotproject->number, 'project_id' => $project->id]),
                                            [
                                                'id' => 'grid-custom-button',
                                                'data-pjax' => true,
                                                'action' => Url::to(['project/Update-task', 'number' => $lotproject->number, 'project_id' => $project->id]),
                                                'class' => 'btn-large waves-effect waves-light btn-blue tooltipped',
                                                'data-position' => "bottom",
                                                'title' => "Permet de créer les consommables et investissements ainsi que de gérer les matériels laboratoires et les contributeurs"
                                            ]
                                        ); ?>
                                    </div>

                                    <div class="col s2">
                                        <?= Html::a(
                                            '<span>Modifier les marges</span>',
                                            Url::to(['project/lot-simulate', 'number' =>  $lotproject->number, 'project_id' => $project->id]),
                                            [
                                                'id' => 'grid-custom-button',
                                                'data-pjax' => true,
                                                'action' => Url::to(['project/lot-simulate', 'number' => $lotproject->number, 'project_id' => $project->id]),
                                                'class' => 'btn-large waves-effect waves-light btn-blue tooltipped',
                                                'data-position' => "bottom",
                                                'title' => "Permet de modifier les marges",
                                            ]
                                        ); ?>
                                    </div>

                                </div>

                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>

                </div>

                <!-- Card view basique : BILAN -->
                <div class="card">

                    <div class="card-content">
                        <label>Bilan du projet</label>
                    </div>

                    <div class="card-action">

                        <div class="row">

                            <?php if ($tjmstatut  && $project->first_in == 1) : ?>
                                <?= Alert::widget(['options' => ['class' => 'alert-warning',], 'body' => 'Attention le taux journalier est inférieur à 700 €',]) ?>
                            <?php endif; ?>

                            <div class="col s12 m6">
                                <table class="highlight">
                                    <tbody>
                                        <tr>
                                            <td width="90%" class="table-font-bold">Montant Total HT :</td>
                                            <td><?= Yii::$app->formatter->asCurrency($project->total) ?></td>
                                        </tr>
                                        <tr>
                                            <td width="90%" class="table-font-bold">Taux de marge moyen avant frais de gestion:</td>
                                            <td><?= Yii::$app->formatter->asPercent($project->marginaverage / 100, 2) ?></td>
                                        </tr>
                                        <tr>
                                            <td width="90%" class="table-font-bold">Frais de gestion du support HT:</td>
                                            <td><?= Yii::$app->formatter->asCurrency($project->supportprice) ?></td>
                                        </tr>
                                        <tr>
                                            <td width="90%" class="table-font-bold">Prix de vente du projet HT (€ arrondis):</td>
                                            <td id="projectsimulate-sellingprice"><?= Yii::$app->formatter->asCurrency($project->SellingPrice) ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="col s12 m6">
                                <table class="highlight">
                                    <tbody>
                                        <tr>
                                            <td width="90%" class="table-font-bold">Taux journalier homme sans risque:</td>
                                            <td><?= Yii::$app->formatter->asCurrency($project->Tjm) ?></td>
                                        </tr>
                                        <tr>
                                            <td width="90%" class="table-font-bold">Taux journalier homme avec risque:</td>
                                            <td><?= Yii::$app->formatter->asCurrency($project->tjmWithRisk) ?></td>
                                        </tr>
                                        <tr>
                                            <td width="90%" class="table-font-bold">Taux de marge moyen avant frais de gestion:</td>
                                            <td><?= Yii::$app->formatter->asPercent($project->marginaverage / 100, 2) ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col s12">
                                <?php if ($tjmstatut) : ?>
                                    <table class="highlight">
                                        <tbody>
                                            <tr>
                                                <td width="20%">
                                                    <?php if ($tjmstatut) : ?>
                                                        <?= $form->field($project, "low_tjm_raison")->widget(
                                                            Select2::class,
                                                            [
                                                                'theme' => Select2::THEME_MATERIAL,
                                                                'data' => Project::TJMRAISON,
                                                                'name' => 'GestionRisk',
                                                                'pluginLoading' => false,
                                                                'options' => ['placeholder' => 'Sélectionner une raison'],
                                                            ]
                                                        )->label('') ?>
                                                    <?php else : ?>
                                                        <?= $form->field($project, "low_tjm_raison")->hiddeninput(['value' => $project::TJMRAISON_TJMOK])->label(''); ?>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <div id="projectsimulate-low_tjm_description"><?= $form->field($project, "low_tjm_description")->input(['placeholder' => "Enter Your Email"])->label("", ['id' => 'low_tjm_description-label']) ?></div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                <?php endif; ?>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Card view basique : OTHER REVERSMENTS -->
                <div class="card">

                    <div class="card-content">
                        <label>Autres reversements</label>
                    </div>

                    <div class="card-action">

                        <div class="row bottom-spacing">
                            <div class="col s12 l6">

                                <table class="highlight">
                                    <tbody>
                                        <tr>
                                            <td width="80%" class="table-font-bold">Reversement Laboratoire :</td>
                                            <td width="20%"></td>
                                        </tr>
                                        <?php if (sizeof($laboratorydepenses) == 0) : ?>
                                            <tr>
                                                <td style="font-style: italic;">Pas de reversements laboratoires trouvés</td>
                                                <td></td>
                                            </tr>
                                        <?php else : ?>
                                            <?php foreach ($laboratorydepenses as $depense) : ?>
                                                <tr>
                                                    <td width="40%"><?= $laboratorylistArray[$depense['labo_id']] ?></td>
                                                    <td><?= Yii::$app->formatter->asCurrency($depense['total']) ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </tbody>
                                </table>

                            </div>

                            <div class="col s12 l6">

                                <table class="highlight">
                                    <tbody>
                                        <tr>
                                            <td width="80%" class="table-font-bold">Prestation interne</td>
                                            <td width="20%"></td>
                                        </tr>
                                        <?php if (sizeof($listInternalDepense) == 0) : ?>
                                            <tr>
                                                <td style="font-style: italic;">Pas de prestations internes trouvées</td>
                                                <td></td>
                                            </tr>
                                        <?php else : ?>
                                            <?php foreach ($listInternalDepense as $depense) : ?>
                                                <tr>
                                                    <td width="40%"><?= $depense['title'] ?></td>
                                                    <td><?= Yii::$app->formatter->asCurrency($depense['total']) ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </tbody>
                                </table>

                            </div>

                            <div class="col s12 l6">

                                <table class="highlight">
                                    <tbody>
                                        <tr>
                                            <td width="80%" class="table-font-bold">Sous-traitance externe</td>
                                            <td width="20%"></td>
                                        </tr>
                                        <?php if (sizeof($listExternalDepense) == 0) : ?>
                                            <tr>
                                                <td style="font-style: italic;">Pas de sous-traitances externes trouvées</td>
                                                <td></td>
                                            </tr>
                                        <?php else : ?>
                                            <?php foreach ($listExternalDepense as $depense) : ?>
                                                <tr>
                                                    <td width="40%"><?= $depense['title'] ?></td>
                                                    <td><?= Yii::$app->formatter->asCurrency($depense['total']) ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </tbody>
                                </table>

                            </div>
                        </div>

                    </div>
                </div>

                <!-- Card view basique : MILESTONES -->
                <div class="card">

                    <div class="card-content">
                        <label>Echéancier prévisionnel</label>
                    </div>

                    <div class="card-action">

                        <div class="row bottom-spacing">

                            <?php if ($Resultcheck['millestone'] == false   && $project->first_in == 1) : ?>
                                <?= Alert::widget(['options' => ['class' => 'alert-warning',], 'body' => ' La somme des jalons ne correspond pas au prix de vente',]); ?>
                            <?php endif; ?>

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
                                        <div class="row">
                                            <?php if (!$millestone->isNewRecord) : ?>
                                                <?= Html::activeHiddenInput($millestone, "[{$i}]id"); ?>
                                            <?php endif; ?>

                                            <div class="col s0">
                                                <?= Html::activeHiddenInput($millestone, "[{$i}]number"); ?>
                                            </div>

                                            <div class="col s5">
                                                <?= $form->field($millestone, "[{$i}]comment")->textInput(['autocomplete' => 'off', 'maxlength' => true, 'placeholder' => 'Titre'])->label(false) ?>
                                            </div>

                                            <div class="col s1">
                                                <?= $form->field($millestone, "[{$i}]pourcentage", [])->textInput(['autocomplete' => 'off', 'maxlength' => true, 'placeholder' => 'Pourcentage'])->label(false) ?>
                                            </div>

                                            <div class="col s2">
                                                <?= $form->field($millestone, "[{$i}]priceeuros")->textInput(['autocomplete' => 'off', 'maxlength' => true, 'value' => Yii::$app->formatter->asCurrency($millestones[$i]->price),  'placeholder' => 'prix'])->label(false) ?>
                                                <?= Html::activeHiddenInput($millestone, "[{$i}]price") ?>
                                            </div>

                                            <div class="col s2">
                                                <?= $form->field($millestone, "[{$i}]estimate_date")->widget(DatePicker::class, [
                                                    'language' => 'fr',
                                                    'dateFormat' => 'dd-MM-yyyy',
                                                    'options' => ['class' => 'form-control picker', 'placeholder' => 'Date (jour-mois-année)'],
                                                ])->label(false) ?>
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



                </div>

                <?= Html::a(
                    Yii::t('app', '<i class="material-icons right">arrow_back</i>Retour'),
                    ['project/index-draft'],
                    ['class' => 'waves-effect waves-light btn btn-grey', 'title' => 'Retour à la liste des brouillons']
                ) ?>

                <?= Html::submitButton(
                    '<i class="material-icons right">save</i>Enregistrer',
                    ['class' => 'waves-effect waves-light btn btn-blue', 'title' => 'Sauvegarder les options']
                ) ?>
                <?php if ($project->state != Project::STATE_DEVIS_MODEL) : ?>
                    <?= Html::a(
                        Yii::t('app', '<i class="material-icons right black-text">star_border</i>Ajouter aux modèles'),
                        ['project/create-model', 'id' => $project->id, 'view' => 'projectsimulate'],
                        ['class' => 'waves-effect waves-light btn btn-white', 'title' => 'Créer un model de devis']
                    ) ?>
                <?php endif; ?>
                <?php if ($project->state == Project::STATE_DEVIS_MODEL) : ?>
                    <?= Html::a(
                        Yii::t('app', '<i class="material-icons right">star</i>Retirer des modèles'),
                        ['project/create-model', 'id' => $project->id, 'view' => 'projectsimulate'],
                        ['class' => 'waves-effect waves-light btn btn-capa', 'title' => 'supprimer le model de devis']
                    ) ?>
                <?php endif; ?>
                <?php if ($validdevis && $project->state != Project::STATE_DEVIS_MODEL) : ?>
                    <?= Html::a(
                        Yii::t('app', '<i class="material-icons right">check</i>Créer le projet'),
                        ['project/create-project?id=' . $project->id],
                        ['class' => 'waves-effect waves-light btn btn-green', 'title' => 'Créer le projet']
                    ) ?>
                <?php endif; ?>

            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>

<!-- Utilisation : envoi de données concernant le prix total de vente HT-->
<div id="price-data-target" style="display: none;">
    <?php echo json_encode(Yii::$app->formatter->asCurrency($project->SellingPrice)) ?>
</div>