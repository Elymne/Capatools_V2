<?php

use app\helper\_enum\CompanyTypeEnum;
use yii\helpers\Html;
use app\models\devis\DevisStatus;
use app\widgets\TopTitle;

/* @var $this yii\web\View */
/* @var $model app\models\devis\Devis */

$id = $model->id;

if ($model->id_capa) $this->title = $model->id_capa;
else $this->title = "Modification d'un devis";

$this->params['breadcrumbs'][] = ['label' => 'Devis', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$indexStatus = getIndexStatus($model);

?>

<?= TopTitle::widget(['title' => $this->title]) ?>

<div class="container">
    <div class="devis-view">

        <!-- Details informations -->
        <div class="row">
            <div class="card">

                <div class="card-content">
                    <span style="color:white">Détails</span>
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
                    <span style="color:white">Jalon(s)</span>
                </div>

                <div class="card-action">
                    <?php echo createMilestonesTable($milestones); ?>
                </div>
            </div>
        </div>

    </div>
</div>

<?php

/**
 * 
 */
function getIndexStatus($model)
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

/**
 * 
 */
function isStatusPassed($indexStatus, $arrayKey)
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

    $devis_name = $model->internal_name;
    $devis_date = $model->creation_date;
    $devis_labotory_proposal = $model->laboratory_proposal;

    $user_name = $model->capa_user->username;
    $user_email = $model->capa_user->email;
    $user_cellule = strtolower($model->capa_user->cellule->name);

    $company_name = $model->company->name;
    $company_type = CompanyTypeEnum::getTypeCompanyString($model->company->type);
    $company_address = $model->company->address;
    $company_phone = $model->company->phone;
    $company_email = $model->company->email;
    $company_siret = $model->company->siret;
    $company_tva = $model->company->tva;


    $delivery_type = $model->delivery_type->label;
    $delivery_duration_hour = $model->service_duration;
    $delivery_duration_day = intval($model->service_duration / 7.4);
    $delivery_validity_duration = $model->validity_duration;
    $delivery_payment_conditions = $model->payment_conditions;
    $delivery_price = $model->price;
    $delivery_payment_details = $model->payment_details;



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

                <!-- Devis details -->
                <tr class='group'>
                    <td class='header'>Informations générale</td>
                    <td></td>
                </tr>
                <tr>
                    <td class='header'>Nom du projet</td>
                    <td>${devis_name}</td>
                </tr>
                <tr>
                    <td class='header'>Date</td>
                    <td>${devis_date}</td>
                </tr>
                <tr>
                    <td class='header'>Proposition de laboratoire</td>
                    <td>${devis_labotory_proposal}</td>
                </tr>

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
                    <td class='header'>Type d'entreprise</td>
                    <td>${company_type}</td>
                </tr>
                <tr>
                    <td class='header'>Addresse</td>
                    <td>${company_address}</td>
                </tr>
                <tr>
                    <td class='header'>Téléphone</td>
                    <td>${company_phone}</td>
                </tr>
                <tr>
                    <td class='header'>Email</td>
                    <td>${company_email}</td>
                </tr>
                <tr>
                    <td class='header'>Siret</td>
                    <td>${company_siret}</td>
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
                    <td class='header'>Validité du devis</td>
                    <td>${delivery_validity_duration} jour(s)</td>
                </tr>

                <tr>
                    <td class='header'>Conditions de paiement</td>
                    <td>${delivery_payment_conditions}</td>
                </tr>
                <tr>
                    <td class='header'>Prix de la prestation (HT)</td>
                    <td>${delivery_price} €</td>
                </tr>
                <tr>
                    <td class='header'>Echéancier</td>
                    <td>${delivery_payment_details}</td>
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
        <br />
        <table class="highlight">
            <tbody>
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
 * TODO utiliser l'option HTML pour gérérer cette partie (plus visible).
 * Create table with all milestones.
 * @param Array<Milestone> $model : List of milestones.
 * 
 * @return HTML table.
 */
function createMilestonesTable($milestones)
{

    // Utiliser <<<HTML HTML; PLEEEASE

    if (empty($milestones)) {
        return <<<HTML
            <p> Il n'existe aucun jalon pour ce devis. </p>
        HTML;
    }

    $headerTable = <<<HTML
        <table class="highlight">
            <tbody>
                <tr class="group">
                    <td class="header">Nom</td>
                    <td class="header">Prix</td>
                    <td class="header">Date</td>
                    <td class="header">Status</td>
                </tr>
    HTML;

    $footerTable = <<<HTML
                </tr>
            </tbody>
        </table>
    HTML;

    $bodyTable = '';

    foreach ($milestones as $milestone) {

        $milestone_label = $milestone->label;
        $milestone_price = $milestone->price;
        $milestone_delivery_date = $milestone->delivery_date;
        $milestone_status = $milestone->milestoneStatus->label;

        $bodyTable = $bodyTable . <<<HTML
            <tr>
                <td>${milestone_label}</td>
                <td>${milestone_price}</td>
                <td>${milestone_delivery_date}</td>
                <td>${milestone_status}</td>
            </tr>   
        HTML;
    }

    return $headerTable . $bodyTable . $footerTable;
}

function statusUpdate()
{
}
