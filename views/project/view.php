<?php

use app\helper\_clazz\UserRoleManager;
use app\helper\_enum\UserRoleEnum;
use yii\helpers\Html;
use app\models\devis\Milestone;
use app\models\devis\MilestoneStatus;
use app\models\projects\Project;
use app\widgets\TopTitle;
/* @var $this yii\web\View */
/* @var $model app\models\devis\Devis */

if ($model->id_capa) $this->title = $model->id_capa;
else $this->title = "Modification d'un devis";

$this->params['breadcrumbs'][] = ['label' => 'Devis', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

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
                    <?php echo createDataTable($model); ?>
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
                    <?php echo createMilestonesTable($milestones, $model->id); ?>
                </div>
            </div>
        </div>

        <!-- Contributors informations -->
        <div class="row">
            <div class="card">
                <div class="card-content">
                    <label>Liste des intervenants</label>
                </div>

                <div class="card-action">
                    <?php echo createContributorsTable($contributors, $model->id); ?>
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

function createTimeline($stages, $indexStatus)
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

function isStatusPassed($indexStatus, $arrayKey): bool
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
function createDataTable($model): string
{

    $internal_name = $model->internal_name;
    $internal_reference = $model->internal_reference;
    $type = $model->type;
    $prospecting_time_day = $model->prospecting_time_day;
    $signing_probability = $model->signing_probability;

    $project_manager_firstname = $model->project_manager->firstname;
    $project_manager_surname = $model->project_manager->surname;
    $project_manager_email = $model->project_manager->email;
    $project_manager_cellule = strtolower($model->project_manager->cellule->name);

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

    $laboxy_name = $model->id_laboxy;
    $laboxy_prestation_duration = $model->prospecting_time_day * Yii::$app->params['LaboxyTimeDay'];

    return <<<HTML
        <table class="highlight">

            <tbody>

                <!-- Devis details -->
                <tr class='group'>
                    <td class='header'>Informations générale</td>
                    <td></td>
                </tr>
                <tr>
                    <td class='header'>Nom interne du projet</td>
                    <td>${internal_name}</td>
                </tr>
                <tr>
                    <td class='header'>Reference interne du projet</td>
                    <td>${internal_reference}</td>
                </tr>
                <tr>
                    <td class='header'>Type de projet</td>
                    <td>${type}</td>
                </tr>
                <tr>
                    <td class='header'>Temps de prospection en jours</td>
                    <td>${prospecting_time_day}</td>
                </tr>
                <tr>
                    <td class='header'>Probabilité de signature</td>
                    <td>${signing_probability}</td>
                </tr>

                <!-- Project manager data -->
                <tr class='group'>
                    <td class='header'>Chef de projet</td>
                    <td></td>
                </tr>
                <tr>
                    <td class='header'>Nom</td>
                    <td>${project_manager_surname}</td>
                </tr>
                <tr>
                    <td class='header'>Prénom</td>
                    <td>${project_manager_firstname}</td>
                </tr>
                <tr>
                    <td class='header'>Email</td>
                    <td>${project_manager_email}</td>
                </tr>
                <tr>
                    <td class='header'>Cellule capacité</td>
                    <td>${project_manager_cellule}</td>
                </tr>

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
                    <td class='header'>Contacte client</td>
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
                    <td class='header'>Validité du devis</td>
                    <td>${contact_email}</td>
                </tr>

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
                    <td class='header'>Durée prestation laboxy</td>
                    <td>${laboxy_prestation_duration} heures</td>
                </tr>
                
            </tbody>

        </table>
HTML;
}

/**
 * Create table with all milestones.
 * @param Array<Milestone> $model : List of milestones.
 * 
 * @return HTML table.
 */
function createMilestonesTable($lots): string
{

    // Used to display or not tab for milestone management.
    $statusRowHeader = '';
    $statusRowBody = '';

    // When no milestone has been created.
    if (empty($milestones)) {
        return <<<HTML
            <p> Il n'existe aucun jalon pour ce devis. </p>
        HTML;
    }

    // When user = ACCOUNTING_SUPPORT_DEVIS, create milestone header tab.
    if (UserRoleManager::hasRoles([UserRoleEnum::ACCOUNTING_SUPPORT_DEVIS])) {
        $statusRowHeader = <<<HTML
            <td class="header"></td>
        HTML;
    }

    // Create the header of milestone table.
    $headerTable = <<<HTML
        <table class="highlight">
            <tbody>
                <tr class="group">
                    <td class="header">Nom</td>
                    <td class="header">Prix</td>
                    <td class="header">Date</td>
                    <td class="header">Status</td>
                    ${statusRowHeader}
                </tr>
    HTML;

    // Create the footer of milestone table.
    $footerTable = <<<HTML
                </tr>
            </tbody>
        </table>
    HTML;

    // Create the body of milestone table with data.
    $bodyTable = '';
    foreach ($milestones as $milestone) {

        $milestone_label = $milestone->label;
        $milestone_price = $milestone->price;
        $milestone_delivery_date = $milestone->delivery_date;
        $milestone_status = $milestone->milestoneStatus->label;

        // When user = ACCOUNTING_SUPPORT_DEVIS, create milestone body tab.
        if (UserRoleManager::hasRoles([UserRoleEnum::ACCOUNTING_SUPPORT_DEVIS])) {
            $milestone_update = $milestone->milestoneStatus->id;
            $statusRowBody = updateStatus($milestone->id, $milestone_update, $idDevis);
        }

        $bodyTable = $bodyTable . <<<HTML
            <tr>
                <td>${milestone_label}</td>
                <td>${milestone_price} €</td>
                <td>${milestone_delivery_date}</td>
                <td>${milestone_status}</td>
                ${statusRowBody}
            </tr>   
        HTML;
    }

    return $headerTable . $bodyTable . $footerTable;
}

/**
 * Used to generate HTML cell of a specific milestone.
 * 
 * @return HTML cell of Milestone table.
 */
function updateStatus($id, $status, $idDevis): string
{

    if ($status == MilestoneStatus::ENCOURS) {
        return <<<HTML
            <td>
                <a href="update-milestone-status?id=${id}&status=${status}&id_devis=${idDevis}" class="btn-floating waves-effect waves-light blue">
                    <i class="material-icons right">check_circle</i>
                </a>
            </td>
        HTML;
    }

    if ($status == MilestoneStatus::FACTURATIONENCOURS) {
        return <<<HTML
            <td>
                <a href="update-milestone-status?id=${id}&status=${status}&id_devis=${idDevis}" class="btn-floating waves-effect waves-light blue">
                    <i class="material-icons right">check_circle</i>
                </a>
            </td>
        HTML;
    }

    return <<<HTML
        <td>Jalon réglé</td>
    HTML;
}

/**
 * Display all buttons.
 * 
 * @return HTML cell of Milestone table.
 */
function displayActionButtons($model)
{
?>
    <!-- Actions on devis -->
    <?= Html::a('Retour <i class="material-icons right">arrow_back</i>', ['index'], ['class' => 'waves-effect waves-light btn btn-grey rightspace-15px leftspace-15px']) ?>

    <?= Html::a('Modifier <i class="material-icons right">build</i>', ['update', 'id' => $model->id], ['class' => 'waves-effect waves-light btn btn-green rightspace-15px leftspace-15px']) ?>

    <?php if ($model->state == PROJECT::STATE_DRAFT && UserRoleManager::hasRoles([UserRoleEnum::OPERATIONAL_MANAGER_DEVIS])) : ?>
        <?= Html::a(
            'Passer en validation opérationnelle <i class="material-icons right">check</i>',
            ['update-status', 'id' => $model->id, 'status' => PROJECT::STATE_DEVIS_SENDED,],
            ['class' => 'waves-effect waves-light btn btn-green rightspace-15px leftspace-15px', 'data' => [
                'confirm' => 'Valider ce devis en tant que responsable opérationnel ?'
            ]]
        ) ?>
    <?php endif; ?>

    <?php if ($model->state == PROJECT::STATE_DEVIS_SENDED &&  UserRoleManager::hasRoles([UserRoleEnum::OPERATIONAL_MANAGER_DEVIS])) : ?>
        <?= Html::a(
            'Valider la signature client <i class="material-icons right">check</i>',
            ['update-status', 'id' => $model->id, 'status' => Project::STATE_DEVIS_SIGNED,],
            ['class' => 'waves-effect waves-light btn btn-green  rightspace-15px leftspace-15px', 'data' => [
                'confirm' => 'Le client à signé le contrat ?'
            ]]
        ) ?>
    <?php endif; ?>

    <?= Html::a(
        'Créer un pdf <i class="material-icons right">picture_as_pdf</i>',
        ['pdf', 'id' => $model->id],
        ['class' => 'waves-effect btn-purple waves-light btn']
    ) ?>
<?php
}
