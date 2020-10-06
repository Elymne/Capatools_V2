<?php

use app\assets\projects\ProjectViewAsset;
use yii\helpers\Html;
use app\models\projects\Millestone;
use app\models\projects\Project;
use app\services\htmlServices\HtmlHelperConst;
use app\services\userRoleAccessServices\UserRoleEnum;
use app\services\userRoleAccessServices\UserRoleManager;
use app\widgets\TopTitle;
use yii\helpers\Url;
use yii\web\YiiAsset;

/* @var $this yii\web\View */
/* @var $model app\models\devis\Devis */

if ($model->id_capa) $this->title = $model->id_capa;
else $this->title = "Modification d'un devis";

$this->params['breadcrumbs'][] = ['label' => 'Devis', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;


YiiAsset::register($this);
ProjectViewAsset::register($this);
?>

<?= TopTitle::widget(['title' => $this->title]) ?>

<div class="container">
    <div class="devis-view">

        <!-- Main information -->
        <div class="row">
            <div class="card">
                <div class="card-action">
                    <?php echo displayActionButtons($model) ?>
                </div>
            </div>

            <div class="card">
                <div class="card-content">
                    <label>Etat du contrat</label>
                </div>
                <div class="card-action">
                    <?php echo createTimeline(Project::STATES, $model->getStatusIndex()) ?>
                </div>
            </div>
        </div>

        <!-- Details informations -->
        <div class="row">
            <div class="card">

                <div class="card-content">
                    <label>Détails du projet</label>
                </div>

                <div class="card-action">
                    <?php echo createProjetTable($model); ?>
                </div>
            </div>
        </div>
        <!-- Details informations -->
        <div class="row">
            <div class="card">

                <div class="card-content">
                    <label>Information Laboxy</label>
                </div>

                <div class="card-action">
                    <?php echo createLaboxyTable($model); ?>
                </div>
            </div>
        </div>

        <!-- Milestones informations -->
        <div class="row">
            <div class="card">
                <div class="card-content">
                    <label>Jalon(s)</label>
                </div>

                <div class="card-action">
                    <div class="row">
                        <table>
                            <tbody>
                                <?php echo createMillestone($model->millestones) ?>
                            <tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- Details informations -->
        <div class="row">
            <div class="card">

                <div class="card-content">
                    <label>Information Client</label>
                </div>

                <div class="card-action">
                    <?php echo createClientTable($model); ?>
                </div>
            </div>
        </div>


        <!-- Display list button -->
        <div class="row">
            <div class="card">
                <div class="card-action">
                    <?php echo displayActionButtons($model) ?>
                </div>
            </div>
        </div>

    </div>
</div>

<?php

function createTimeline(array $stages, int $indexStatus)
{
?>
    <div class="timeline">
        <?php foreach ($stages as $key => $stage) { ?>
            <div class="timeline-event">
                <p class="event-label"><?php echo $stage; ?></p>
                <?php if (isStatusPassed($indexStatus, $key)) echo '<span class="point-filled"></span>';
                else echo '<span class="point"></span>'; ?>
            </div>
        <?php } ?>
    </div>
<?php
}

function isStatusPassed(int $indexStatus, int $arrayKey): bool
{
    if ($indexStatus >= $arrayKey)
        return true;
    else
        return false;
}

/**
 * Create table with all data.
 * @param Devis $model : Model of Devis.
 * 
 * @return HTML table.
 */
function createProjetTable(Project $model)
{

    $internal_name = $model->internal_name;
    $internal_reference = $model->internal_reference;
    $type = $model->type;

    $project_manager_firstname = $model->project_manager->firstname;
    $project_manager_surname = $model->project_manager->surname;
    $project_manager_email = $model->project_manager->email;
    $project_manager_cellule = strtolower($model->project_manager->cellule->name);

?>
    <table class="highlight">
        <tbody>
            <!-- Devis details -->
            <tr class='group'>
                <td class='header'>Informations générale</td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td class='header'>Nom interne du projet</td>
                <td><?= $internal_name ?></td>
                <td></td>
            </tr>
            <tr>
                <td class='header'>Reference interne du projet</td>
                <td><?= $internal_reference ?> </td>
                <td></td>
            </tr>
            <tr>
                <td class='header'>Type de projet</td>
                <td><?= $type ?></td>
                <td></td>
            </tr>

            <tr>
                <td class='header'>Probabilité de signature</td>
                <td>
                    <?= createProbabilityButtons($model) ?>
                </td>
                <td></td>
            </tr>

            <!-- Project manager data -->
            <tr class='group'>
                <td class='header'>Chef de projet</td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td class='header'>Nom</td>
                <td><?= $project_manager_surname ?></td>
                <td></td>
            </tr>
            <tr>
                <td class='header'>Prénom</td>
                <td><?= $project_manager_firstname ?></td>
                <td></td>
            </tr>
            <tr>
                <td class='header'>Email</td>
                <td><?= $project_manager_email ?></td>
                <td></td>
            </tr>
            <tr>
                <td class='header'>Cellule capacité</td>
                <td><?= $project_manager_cellule ?></td>
                <td></td>
            </tr>

        </tbody>

    </table>
<?php
}

function createProbabilityButtons(Project $model)
{

    if (UserRoleManager::hasRole(UserRoleEnum::PROJECT_MANAGER) && $model->state == Project::STATE_DEVIS_SENDED) {
        if ($model->signing_probability == 20) {
            echo Html::a('20%', null, ['class' => 'waves-effect waves-light btn btn-blue-activated']);
            echo HtmlHelperConst::SPACING;
            echo Html::a('50%', ['project/update-signing-probability', 'id' => $model->id, 'probability' => 50], ['class' => 'waves-effect waves-light btn btn-grey']);
            echo HtmlHelperConst::SPACING;
            echo Html::a('80%', ['project/update-signing-probability', 'id' => $model->id, 'probability' => 80], ['class' => 'waves-effect waves-light btn btn-grey']);
        }

        if ($model->signing_probability == 50) {
            echo Html::a('20%', ['project/update-signing-probability', 'id' => $model->id, 'probability' => 20], ['class' => 'waves-effect waves-light btn btn-grey']);
            echo HtmlHelperConst::SPACING;
            echo Html::a('50%', null, ['class' => 'waves-effect waves-light btn btn-blue-activated']);
            echo HtmlHelperConst::SPACING;
            echo Html::a('80%', ['project/update-signing-probability', 'id' => $model->id, 'probability' => 80], ['class' => 'waves-effect waves-light btn btn-grey']);
        }

        if ($model->signing_probability == 80) {
            echo Html::a('20%', ['project/update-signing-probability', 'id' => $model->id, 'probability' => 20], ['class' => 'waves-effect waves-light btn btn-grey']);
            echo HtmlHelperConst::SPACING;
            echo Html::a('50%', ['project/update-signing-probability', 'id' => $model->id, 'probability' => 50], ['class' => 'waves-effect waves-light btn btn-grey']);
            echo HtmlHelperConst::SPACING;
            echo Html::a('80%', null, ['class' => 'waves-effect waves-light btn btn-blue-activated']);
        }
    } else {
        echo $model->signing_probability . '%';
    }
}

/**
 * Create table with all data.
 * @param Devis $model : Model of Devis.
 * 
 * @return HTML table.
 */
function createLaboxyTable(Project $model): string
{

    $laboxy_name = $model->id_laboxy;
    $prix_vente = $model->sellingprice;
    $rhcost = $model->TotalcostRHWithRisk;
    $coutAchatInvestReversement = $model->TotalAchatInvesteReversementPrice;
    $laboxy_prixvente = Yii::$app->formatter->asCurrency($prix_vente);
    $laboxy_prestation_duration = Yii::$app->formatter->asInteger($model->totalHourWithRisk);
    $laboxy_RHcost = Yii::$app->formatter->asCurrency($rhcost);
    $laboxy_coutAchatInvestReversement = Yii::$app->formatter->asCurrency($coutAchatInvestReversement);

    $marge = $prix_vente - $rhcost - $coutAchatInvestReversement;
    $tauxMarge = $marge / ($rhcost + $coutAchatInvestReversement);
    $laboxy_Marge =  Yii::$app->formatter->asCurrency($marge);
    $laboxy_TauxMarge =  Yii::$app->formatter->asPercent($tauxMarge, 2);


    return <<<HTML
        <table class="highlight">
            <tbody>
                 <!-- Laboxy data -->
                 <tr class='group'>
                    <td class='header'>Information Laboxy</td>
                    <td></td>
                </tr>
                <tr>
                    <td class='header'>Identitifant</td>
                    <td>${laboxy_name}</td>
                </tr>
                <tr>
                    <td class='header'>Nombre d'heures prévus</td>
                    <td>${laboxy_prestation_duration} heures</td>
                </tr>
                <tr>
                    <td class='header'>Coût RH</td>
                    <td>${laboxy_RHcost}</td>
                </tr>
                <tr>
                    <td class='header'>Coût total Achat,Frais généraux, Investissement et RH </td>
                    <td>${laboxy_coutAchatInvestReversement} </td>
                </tr>
                <tr>
                    <td class='header'>Prix de vente </td>
                    <td>${laboxy_prixvente}</td>
                </tr>
                <tr>
                    <td class='header'>Marge avec frais généraux</td>
                    <td>${laboxy_Marge}</td>
                </tr>
                <tr>
                    <td class='header'>Taux marge avec frais généraux</td>
                    <td>${laboxy_TauxMarge}</td>
                </tr>
            </tbody>
        </table>
    HTML;
}



/**
 * Create table with all data.
 * @param Devis $model : Model of Devis.
 * 
 * @return HTML table.
 */
function createClientTable(Project $model): string
{


    $company_name = $model->company->name;
    $company_email = $model->company->email;
    $company_type = $model->company->type;
    $company_postal_code = $model->company->postal_code;
    $company_city = $model->company->city;
    $company_country = $model->company->country;
    $company_tva = $model->company->tva;

    $contact_firstname = $model->contact->firstname;
    $contact_surname = $model->contact->surname;
    $contact_phone_number = $model->contact->phone_number;
    $contact_email = $model->contact->email;

    return <<<HTML
        <table class="highlight">
            <tbody>
                 <!-- Company data -->
                <tr class='group'>
                    <td class='header'>Client</td>
                    <td></td>
                </tr>
                <tr>
                    <td class='header'>Nom du client / société</td>
                    <td>${company_name}</td>
                </tr>
                <tr>
                    <td class='header'>Type d'entreprise</td>
                    <td>${company_type}</td>
                </tr>
                <tr>
                    <td class='header'>Pays</td>
                    <td>${company_country}</td>
                </tr>
                <tr>
                    <td class='header'>Ville</td>
                    <td>${company_city}</td>
                </tr>
                <tr>
                    <td class='header'>Code postal</td>
                    <td>${company_postal_code}</td>
                </tr>
                <tr>
                    <td class='header'>Email</td>
                    <td>${company_email}</td>
                </tr>
                <tr>
                    <td class='header'>Tva</td>
                    <td>${company_tva}</td>
                </tr>
                <!-- Delivery data -->
               <tr class='group'>
                    <td class='header'>Contact client</td>
                    <td></td>
                </tr>
                <tr>
                    <td class='header'>Nom</td>
                    <td>${contact_surname}</td>
                </tr>
                <tr>
                    <td class='header'>Prénom</td>
                    <td>${contact_firstname}</td>
                </tr>
                <tr>
                    <td class='header'>N° téléphone</td>
                    <td>${contact_phone_number}</td>
                </tr>
                <tr>
                    <td class='header'>email</td>
                    <td>${contact_email}</td>
                </tr>
             </tbody>
        </table>
    HTML;
}



/**
 * Create table with all lots and tasks.
 * @param Array<Lot> $model : List of Lot..
 * 
 * @return HTML table.
 */
function createMillestone(array $millestones)
{ ?>
    <tr>
        <th>Titre</th>
        <th>Pourcentage</th>
        <th>Prix du jalon</th>
        <th>Statut</th>
        <?php if (UserRoleManager::hasRoles([UserRoleEnum::SUPER_ADMIN, UserRoleEnum::ADMIN, UserRoleEnum::ACCOUNTING_SUPPORT])) {
            echo "<th></th>";
        } ?>
    </tr>
    <?php foreach ($millestones as $key => $millestone) { ?>
        <tr>
            <td><?= $millestone->comment ?></td>
            <td><?= Yii::$app->formatter->asPercent($millestone->pourcentage / 100) ?></td>
            <td><?= $millestone->priceeuros ?></td>
            <td><?= updateStatus($millestone) ?></td>
            <?php
            getUpdateStatusButton($millestone);
            ?>
        </tr>
    <?php
    }
}

function getUpdateStatusButton($milestone)
{
    if ($milestone->statut == Millestone::STATUT_ENCOURS && (UserRoleManager::hasRole(UserRoleEnum::PROJECT_MANAGER) || UserRoleManager::hasRole(UserRoleEnum::SUPER_ADMIN) || UserRoleManager::hasRole(UserRoleEnum::ADMIN))) {
    ?> <td><?= Html::a('A facturer', ['update-millestone-status', 'id' => $milestone->id, 'status' => Millestone::STATUT_FACTURATIONENCOURS], ['class' => 'waves-effect waves-light btn btn-grey']) ?></td>
    <?php
    }
    if ($milestone->statut == Millestone::STATUT_FACTURATIONENCOURS &&  (UserRoleManager::hasRole(UserRoleEnum::ACCOUNTING_SUPPORT)  || UserRoleManager::hasRole(UserRoleEnum::SUPER_ADMIN) || UserRoleManager::hasRole(UserRoleEnum::ADMIN))) {
    ?> <td><?= Html::a('Valider la facturation', ['update-millestone-status', 'id' => $milestone->id, 'status' => Millestone::STATUT_FACTURER], ['class' => 'waves-effect waves-light btn btn-grey']) ?></td>
    <?php
    }
    if ($milestone->statut == Millestone::STATUT_FACTURER &&  (UserRoleManager::hasRole(UserRoleEnum::ACCOUNTING_SUPPORT)  || UserRoleManager::hasRole(UserRoleEnum::SUPER_ADMIN) || UserRoleManager::hasRole(UserRoleEnum::ADMIN))) {
    ?> <td><?= Html::a('Valider le paiement', ['update-millestone-status', 'id' => $milestone->id, 'status' => Millestone::STATUT_PAYED], ['class' => 'waves-effect waves-light btn btn-grey']) ?></td>
    <?php
    }
    if ($milestone->statut == Millestone::STATUT_PAYED) {
    ?> <td></td>
    <?php
    }
}

/**
 * Used to generate HTML cell of a specific millestone.
 * 
 * @return HTML cell of Millestone table.
 */
function updateStatus($millestone): string
{


    if ($millestone->statut == Millestone::STATUT_ENCOURS && $millestone->project->state  == Project::STATE_DEVIS_SIGNED) {
        $id = $millestone->id;
        $status = Millestone::STATUT_FACTURATIONENCOURS;
        return <<<HTML
                En Cours&nbsp;&nbsp;&nbsp;

        HTML;
    }
    if ($millestone->statut == Millestone::STATUT_ENCOURS) {
        $id = $millestone->id;
        $status = $millestone->statut;
        return <<<HTML
                En cours&nbsp;&nbsp;&nbsp;
                </a>
        HTML;
    }
    if ($millestone->statut == Millestone::STATUT_FACTURER) {
        $id = $millestone->id;
        $status = $millestone->statut;
        return <<<HTML
                Facturé&nbsp;&nbsp;&nbsp;
                </a>
        HTML;
    }

    if ($millestone->statut == Millestone::STATUT_FACTURATIONENCOURS) {
        $id = $millestone->id;
        $status = $millestone->statut;
        return <<<HTML
                Facturation en cours&nbsp;&nbsp;&nbsp;
                </a>
        HTML;
    }

    if ($millestone->statut == Millestone::STATUT_PAYED) {
        $id = $millestone->id;
        $status = $millestone->statut;
        return <<<HTML
                Payé&nbsp;&nbsp;&nbsp;
                </a>
        HTML;
    }
    return "";
}

/**
 * Display all buttons.
 * 
 * @return HTML cell of Action bouton
 */
function displayActionButtons($model)
{ ?>
    <!-- Actions on devis -->
    <?= Html::a('Retour <i class="material-icons right">arrow_back</i>', ['index'], ['class' => 'waves-effect waves-light btn btn-grey rightspace-15px leftspace-15px']) ?>
    <?php if ($model->state == PROJECT::STATE_DEVIS_SENDED) : ?>
        <?= Html::a(
            'Modifier le devis <i class="material-icons right">edit</i>',
            ['update-status', 'id' => $model->id, 'status' => Project::STATE_DEVIS_DRAFT,],
            ['class' => 'waves-effect waves-light btn btn-grey  rightspace-15px leftspace-15px', 'data' => [
                'confirm' => 'Modifier le devis ?'
            ]]
        ) ?>
    <?php endif; ?>

    <?php if ($model->state == PROJECT::STATE_DEVIS_SENDED) : ?>
        <?= Html::a(
            'Valider la signature client <i class="material-icons right">check</i>',
            ['update-status', 'id' => $model->id, 'status' => Project::STATE_DEVIS_SIGNED,],
            ['class' => 'waves-effect waves-light btn btn-green  rightspace-15px leftspace-15px', 'data' => [
                'confirm' => 'Le client a signé le contrat ?'
            ]]
        ) ?>
    <?php endif; ?>


    <?php if ($model->state == PROJECT::STATE_DEVIS_SENDED) : ?>
        <?= Html::a(
            'Cloturer le devis <i class="material-icons right">clear</i>',
            ['update-status', 'id' => $model->id, 'status' => Project::STATE_DEVIS_CANCELED,],
            ['class' => 'waves-effect waves-light btn btn-red  rightspace-15px leftspace-15px', 'data' => [
                'confirm' => 'Cloturer le devis ?'
            ]]
        ) ?>
    <?php endif; ?>


    <?php if ($model->state == PROJECT::STATE_DEVIS_SIGNED) : ?>
        <?= Html::a(
            'Abandonner la prestation <i class="material-icons right">clear</i>',
            ['update-status', 'id' => $model->id, 'status' => Project::STATE_DEVIS_CANCELED,],
            ['class' => 'waves-effect waves-light btn btn-red  rightspace-15px leftspace-15px', 'data' => [
                'confirm' => 'Attention : Les échanciers non facturés seront abandonnés. Abandonner la prestation ? '
            ]]
        ) ?>
    <?php endif; ?>
    <?php if ($model->state == PROJECT::STATE_DEVIS_SIGNED) : ?>
        <?= Html::a(
            'Prestation terminée <i class="material-icons right">check</i>',
            ['update-status', 'id' => $model->id, 'status' => Project::STATE_DEVIS_FINISHED,],
            ['class' => 'waves-effect waves-light btn btn-blue  rightspace-15px leftspace-15px', 'data' => [
                'confirm' => 'Attention : Les échanciers non facturés seront abandonnés. Terminer la prestation ?'
            ]]
        ) ?>
    <?php endif; ?>

    <?= Html::a(
        'Générer le pdf <i class="material-icons right">picture_as_pdf</i>',
        Url::to(['project/pdf', 'id' => $model->id,]),
        [
            'id' => 'grid-custom-button',
            'target' => '_blank',
            'data-pjax' => true,
            'action' => Url::to(['project/pdf', 'id' => $model->id]),
            'class' => 'waves-effect waves-light btn btn-purple  rightspace-15px leftspace-15px',
            'title' => "Générer le devis sous forme pdf"
        ]
    ) ?>

<?php
}
