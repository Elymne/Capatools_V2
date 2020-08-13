<?php

use app\assets\projects\PdfAsset;
use app\models\projects\Project;
use app\widgets\TopTitle;

PdfAsset::register($this);

$id = $model->id;
if ($model->id_capa) $this->title = $model->id_capa;
else $this->title = "Modification d'un devis";

$this->params['breadcrumbs'][] = ['label' => 'Devis', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?= TopTitle::widget(['title' => "Devis : " . $this->title]) ?>

<div class="container">
    <div class="devis-view">

        <!-- Details informations -->
        <div class="row">

            <div class="col s12">
                <div class="row">

                    <div class="col s4">
                        <div class="card">
                            <div class="card-action">
                                <?php echo defaultDataTable() ?>
                            </div>
                        </div>
                    </div>

                    <div class="col s7">
                        <div class="card">
                            <div class="card-content">
                                <span style="color:white">Société</span>
                            </div>
                            <div class="card-action">
                                <?php echo companyDataTable($model) ?>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="card">
                <div class="card-content">
                    <span style="color:white">Projet</span>
                </div>
                <div class="card-action">
                    <?php echo projectDataTable($model) ?>
                </div>
            </div>

            <div class="spaceFirstPage">
                <br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
            </div>

            <div class="card">
                <div class="card-content">
                    <span style="color:white">Informations laboxy</span>
                </div>
                <div class="card-action">
                    <?php echo priceDataTable($model) ?>
                </div>
            </div>


            <div class="card">

                <div class="card-content">
                    <span style="color:white">Informations client</span>
                </div>

                <div class="card-action">
                    <?php echo createClientTable($model); ?>
                </div>
            </div>

            <div>
                <br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
            </div>

            <div class="card">
                <div class="card-action">
                    <?php echo footerDataTable($model); ?>
                </div>
            </div>

        </div>

    </div>
</div>

<?php

function defaultDataTable(): string
{
    return <<<HTML
        <b>CAPACITES SAS</b>
        <p>26, boulevard Vincent Gâche</p>
        <p>44200 Nantes - FRANCE</p>
        <p><b>Tél :</b> 02 72 64 88 40</p>
        <p><b>Fax :</b> 02 72 64 88 98</p>
        <p><b>Email :</b> commercial@capacites.fr</p>
    HTML;
}

function companyDataTable($model): string
{
    $company_name = $model->company->name;
    $company_type = $model->company->type;
    $company_country = $model->company->country;
    $company_city = $model->company->city;
    $company_postal_code = $model->company->postal_code;
    $company_email = $model->company->email;
    $company_tva = $model->company->tva;

    return <<<HTML
        <table class="highlight">
            <tbody>
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
            </tbody>
        </table>
   HTML;
}

function projectDataTable($model): string
{
    $devis_name = $model->internal_name;
    $devis_date = $model->creation_date;
    $project_probability = $model->signing_probability;
    $project_type = $model->type;

    $project_manager_firstname = $model->project_manager->firstname;
    $project_manager_surname = $model->project_manager->surname;
    $project_manager_email = $model->project_manager->email;
    $user_cellule = strtolower($model->project_manager->cellule->name);



    return <<<HTML
        <table class="highlight">
            <tbody>
                <tr>
                    <td class='header'>Référence</td>
                    <td>${devis_name}</td>
                </tr>
                <tr>
                    <td class='header'>Probabilité de signature</td>
                    <td>${project_probability} %</td>
                </tr>
                <tr>
                    <td class='header'>Type</td>
                    <td>${project_type}</td>
                </tr>
                <tr>
                    <td class='header'>Référence</td>
                    <td>${devis_name}</td>
                </tr>
                <tr>
                    <td class='header'>Date</td>
                    <td>${devis_date}</td>
                </tr>

                <tr class='group'>
                    <td class='header'>Chef de projet</td>
                    <td></td>
                </tr>

                <tr>
                    <td class='header'>Nom</td>
                    <td>${project_manager_firstname}</td>
                </tr>
                <tr>
                    <td class='header'>Prénom</td>
                    <td>${project_manager_surname}</td>
                </tr>
                <tr>
                    <td class='header'>Email</td>
                    <td>${project_manager_email}</td>
                </tr>
                <tr>
                    <td class='header'>De la cellule</td>
                    <td>${user_cellule}</td>
                </tr>
            </tbody>
        </table>
   HTML;
}

function priceDataTable($model)
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
                    <td class='header'>Coût total Achat,Frais généreaux, Investissement et RH </td>
                    <td>${laboxy_coutAchatInvestReversement} </td>
                </tr>
                <tr>
                    <td class='header'>Prix de vente </td>
                    <td>${laboxy_prixvente}</td>
                </tr>
                <tr>
                    <td class='header'>Marge avec frais généreaux</td>
                    <td>${laboxy_Marge}</td>
                </tr>
                <tr>
                    <td class='header'>Taux marge avec frais généreaux</td>
                    <td>${laboxy_TauxMarge}</td>
                </tr>
            </tbody>
        </table>
HTML;
}

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

function footerDataTable()
{
    return <<<HTML
        <p>En cas d'acceptation, merci de nous retourner le présent devis daté et signé avec la mention : </p>
        <p>bon pour accord" et le cachet de votre entreprise.</p>
        <p>La signature du présent contrat vaut acceptation des conditions générales de ventes jointes au devis</p>
       
        <table class="highlight">
            <tbody>
                <tr><td>Nom - Prénom : </td><tr>
                <tr><td>Fonction : </td><tr>
                <tr><td>Date : </td><tr>
            </tbody>
        </table>
    HTML;
}
