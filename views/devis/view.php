<?php

use app\helper\_clazz\UserRoleManager;
use app\helper\_enum\CompanyTypeEnum;
use app\helper\_enum\UserRoleEnum;
use yii\helpers\Html;
use app\models\devis\DevisStatus;
use app\models\devis\Milestone;
use app\models\devis\MilestoneStatus;
use app\widgets\TopTitle;
/* @var $this yii\web\View */
/* @var $model app\models\devis\Devis */

if ($model->id_capa) $this->title = $model->id_capa;
else $this->title = "Modification d'un devis";

$this->params['breadcrumbs'][] = ['label' => 'Devis', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

$stages = [
    1 => 'Avant Contrat',
    2 => 'Validation resp opérationnel',
    3 => 'Signature client',
    4 => 'Projet en cours',
    5 => 'Projet terminé / annulé'
];

$indexStatus = getIndexStatus($model);
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

                    <?php echo createTimeline($stages, $indexStatus) ?>

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
                    <?php echo createDataTable($model, $fileModel); ?>
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

function getIndexStatus($model): int
{

    $indexStatus = -1;

    switch ($model->devis_status->id) {
        case 1:
            $indexStatus = 1;
            break;
        case 2:
            $indexStatus = 2;
            break;
        case 3:
            $indexStatus = 3;
            break;
        case 4:
            $indexStatus = 4;
            break;
        case 5:
            $indexStatus = 5;
            break;
        case 6:
            $indexStatus = 5;
            break;
    }

    return $indexStatus;
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
function createDataTable($model, $fileModel): string
{

    // You can't use object with <<<HTML HTML; so you have to create value like bellow.
    $user_name = $model->capa_user->username;
    $user_email = $model->capa_user->email;
    $user_cellule = strtolower($model->capa_user->cellule->name);


    $company_name = $model->company->name;
    $company_type = CompanyTypeEnum::getTypeCompanyString($model->company->type);
    $company_description = $model->company->description;
    if ($company_description == null) $company_description = "Aucune description";
    $company_tva = $model->company->tva;

    $devis_price = $model->price;

    $delivery_type = $model->delivery_type->label;
    $delivery_duration_hour = $model->service_duration;
    $delivery_duration_day = intval($model->service_duration / 7.4);

    $laboxy_name = $model->id_laboxy;
    $laboxy_prestation_duration = $model->service_duration * Yii::$app->params['LaboxyTimeDay'];

    if ($fileModel == null) {
        $file_name = 'Aucun fichier';
        $file_version = 'Pas de fichier';
    } else {
        $file_name = $fileModel->name . '.' . $fileModel->type;
        $file_version = $fileModel->version;
    }


    return <<<HTML
        <table class="highlight">

            <tbody>
                <!-- Project manager data -->

                <tr class='group'>
                    <td class='header'>Chef de projet</td>
                    <td></td>
                </tr>
                <tr>
                    <td class='header'>Nom / prénom</td>
                    <td>${user_name}</td>
                </tr>
                <tr>
                    <td class='header'>Email</td>
                    <td>${user_email}</td>
                </tr>
                <tr>
                    <td class='header'>Cellule capacité</td>
                    <td>${user_cellule}</td>
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
                    <td class='header'>Description</td>
                    <td>${company_description}</td>
                </tr>
                <tr>
                    <td class='header'>Type d'entreprise</td>
                    <td>${company_type}</td>
                </tr>
                <tr>
                    <td class='header'>Tva</td>
                    <td>${company_tva}</td>
                </tr>

                <!-- Delivery data -->

                <tr class='group'>
                    <td class='header'>Prestation</td>
                    <td></td>
                </tr>
                <tr>
                    <td class='header'>Type de prestation</td>
                    <td>${delivery_type}</td>
                </tr>
                <tr>
                    <td class='header'>Durée de la prestation (h)</td>
                    <td>${delivery_duration_hour} heure(s)</td>
                </tr>
                <tr>
                    <td class='header'>Durée de la prestation (j)</td>
                    <td>${delivery_duration_day} jour(s)</td>
                </tr>
                
                <tr>
                    <td class='header'>Prix de la prestation (HT)</td>
                    <td>${devis_price} €</td>
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

                 <!-- Fichier uploadé -->

                 <tr class='group'>
                    <td class='header'>Fichier uploadé</td>
                    <td></td>
                </tr>
                <tr>
                    <td class='header'>Nom</td>
                    <td>${file_name}</td>
                </tr>
                <tr>
                    <td class='header'>Version</td>
                    <td>${file_version}</td>
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
function createMilestonesTable($milestones, $idDevis): string
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

    <?php if ($model->status_id == DevisStatus::AVANT_PROJET &&  UserRoleManager::hasRoles([UserRoleEnum::OPERATIONAL_MANAGER_DEVIS])) : ?>
        <?= Html::a(
            'Passer en validation opérationnelle <i class="material-icons right">check</i>',
            ['update-status', 'id' => $model->id, 'status' => DevisStatus::ATTENTE_VALIDATION_OP,],
            ['class' => 'waves-effect waves-light btn btn-green rightspace-15px leftspace-15px', 'data' => [
                'confirm' => 'Valider ce devis en tant que responsable opérationnel ?'
            ]]
        ) ?>
    <?php endif; ?>

    <?php if ($model->status_id == DevisStatus::ATTENTE_VALIDATION_OP &&  UserRoleManager::hasRoles([UserRoleEnum::OPERATIONAL_MANAGER_DEVIS])) : ?>
        <?= Html::a(
            'Valider la signature client <i class="material-icons right">check</i>',
            ['update-status', 'id' => $model->id, 'status' => DevisStatus::ATTENTE_VALIDATION_CL,],
            ['class' => 'waves-effect waves-light btn btn-green  rightspace-15px leftspace-15px', 'data' => [
                'confirm' => 'Le client à signé le contrat ?'
            ]]
        ) ?>
    <?php endif; ?>

    <?php if ($model->status_id == DevisStatus::ATTENTE_VALIDATION_CL &&  UserRoleManager::hasRoles([UserRoleEnum::OPERATIONAL_MANAGER_DEVIS])) : ?>
        <?= Html::a(
            'Passer en projet en cours <i class="material-icons right">check</i>',
            ['update-status', 'id' => $model->id, 'status' => DevisStatus::PROJET_EN_COURS,],
            ['class' => 'waves-effect waves-light btn btn-green  rightspace-15px leftspace-15px', 'data' => [
                'confirm' => 'Passer ce projet en cours ?'
            ]]
        ) ?>
    <?php endif; ?>

    <?php if ($model->status_id == DevisStatus::PROJET_EN_COURS &&  UserRoleManager::hasRoles([UserRoleEnum::OPERATIONAL_MANAGER_DEVIS])) : ?>
        <?= Html::a(
            'Passer en projet terminé <i class="material-icons right">check</i>',
            ['update-status', 'id' => $model->id, 'status' => DevisStatus::PROJETTERMINE,],
            ['class' => 'waves-effect waves-light btn btn-green rightspace-15px leftspace-15px', 'data' => [
                'confirm' => 'Ce projet est terminé ?'
            ]]
        ) ?>
    <?php endif; ?>

    <?php if ($model->status_id < DevisStatus::PROJET_ANNULE && UserRoleManager::hasRoles([UserRoleEnum::OPERATIONAL_MANAGER_DEVIS])) : ?>
        <?= Html::a(
            'annuler projet <i class="material-icons right">delete</i>',
            ['update-status', 'id' => $model->id, 'status' => DevisStatus::PROJET_ANNULE,],
            ['class' => 'waves-effect waves-light btn btn-orange rightspace-15px leftspace-15px', 'data' => [
                'confirm' => 'Annuler ce projet ?'
            ]]
        ) ?>
    <?php endif; ?>

    <?php if ($model->status_id == DevisStatus::PROJET_ANNULE && UserRoleManager::hasRoles([UserRoleEnum::OPERATIONAL_MANAGER_DEVIS, UserRoleEnum::ACCOUNTING_SUPPORT_DEVIS])) : ?>
        <?= Html::a(
            'Supprimer <i class="material-icons right">delete</i>',
            ['delete', 'id' => $model->id],
            ['class' => 'waves-effect waves-light btn btn-red rightspace-15px leftspace-15px', 'data' => [
                'confirm' => 'Supprimer ce projet ?'
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
