<?php

use app\models\projects\Project;

$id = $model->id;
if ($model->id_capa) $this->title = $model->id_capa;
else $this->title = "Modification d'un devis";

$this->params['breadcrumbs'][] = ['label' => 'Devis', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="card">
    <div class="card-content">
        <p class="title"><?= 'Devis : ' . $this->title ?></p>
    </div>
</div>


<div class="devis-view">
    <div class="row">
        <!-- Details informations -->

        <div class="col s12">
            <div class="row">

                <div class="col s5">
                    <?php echo defaultDataTable() ?>

                    <?php echo projectDataTable($model) ?>
                </div>

                <div class="col s6">
                    <?php echo companyDataTable($model) ?>
                </div>

            </div>
        </div>

        <div class="col s12">
            <?php echo milestonesDataTables($model) ?>
        </div>

        <div class="col s6">
            <?php echo detailsDataTable($model); ?>
        </div>

        <div class="col s12">
            <?php echo warningDataTable() ?>
        </div>

        <div class="col s12">
            <?php echo signatureDataTable() ?>
        </div>

        <pagebreak />

    </div>
</div>

<div class="lol"></div>


<?php

function defaultDataTable(): string
{
    return <<<HTML
        <table>
            <tr>
                <td class="textcenter">
                    <b class="bolded">CAPACITES SAS</b>
                    <p>26, boulevard Vincent Gâche</p>
                    <p>44200 Nantes - FRANCE</p>
                    <p><b class="bolded">Tél :</b> 02 72 64 88 40</p>
                    <p><b class="bolded">Fax :</b> 02 72 64 88 98</p>
                    <p><b class="bolded">Email :</b> commercial@capacites.fr</p>
                </td>
            </tr>
        </table>
        <br />
    HTML;
}

function companyDataTable($model): string
{
    $company_name = $model->company->name;
    $company_type = $model->company->type;
    $company_address = $model->company->address;
    $company_phone = $model->company->phone;
    $company_email = $model->company->email;
    $company_tva = $model->company->tva;
    $company_siret = $model->company->siret;

    return <<<HTML
        <table>
            <tr>
                <th class="title-stylish">Société</th>
            </tr>
        </table>
        <table>
            <tbody>
                <tr>
                    <th>Dénomination</th>
                    <td>${company_name}</td>
                </tr>
                <tr>
                    <th>A l'attention de</th>
                    <td>${company_type}</td>
                </tr>
                <tr>
                    <th>Addresse</th>
                    <td>${company_address}</td>
                </tr>
                <tr>
                    <th>Téléphone</th>
                    <td>${company_phone}</td>
                </tr>
                <tr>
                    <th>E-mail</th>
                    <td>${company_email}</td>
                </tr>
                <tr>
                    <th>Tva</th>
                    <td>${company_tva}</td>
                </tr>
                <tr>
                    <th>Siret</th>
                    <td>${company_siret}</td>
                </tr>
            </tbody>
        </table>
   HTML;
}

function projectDataTable($model): string
{
    $devis_name = $model->internal_name;
    $devis_date = $model->creation_date;
    $user_cellule = strtolower($model->project_manager->cellule->name);

    return <<<HTML
        <table>
            <tr>
                <th class="title-stylish">Devis</th>
            </tr>
        </table>
        <table>
                <tr>
                    <tH>Référence :</th>
                    <td>${devis_name}</td>
                </tr>
                <tr>
                    <th>Date :</th>
                    <td>${devis_date}</td>
                </tr>
                <tr>
                    <th>Proposition <br />de <br />laboratoire :</th>
                    <td>${user_cellule}</td>
                </tr>
        </table>
   HTML;
}

function milestonesDataTables($model): string
{

    $max_price = 0;

    $html_header = <<<HTML
        <div class="row">
            <div class="col s12">
                <table>
                    <tr>
                        <th>Désignation</th>
                        <th>Pourcentage</th>
                        <th>Prix</th>
                    </tr>
    HTML;

    $html_body = "";

    foreach ($model->millestones as $milestone) {
        $milestone_comment = $milestone->comment;
        $milestone_percent = $milestone->pourcentage;
        $milestone_price = $milestone->price;

        $max_price += $milestone_price;

        $html_body = $html_body . <<<HTML
            <tr>
                <td>${milestone_comment}</td>
                <td>${milestone_percent}</td>
                <td>${milestone_price}</td>
            </tr>
        HTML;
    }

    $html_footer = <<<HTML
            </table>
        </div>
    HTML;

    $tva_price = $max_price * 0.2;
    $price_ttc = $max_price * 1.2;

    $total_price_table = <<<HTML
            <div class="col s3 offset-s9">
                <table>
                    <tr>
                        <td class="price-stylish">TOTAL HT</td>
                        <td class="price-stylish">${max_price} €</td>
                    </tr>
                    <tr>
                        <td class="price-stylish">TVA 20%</td>
                        <td class="price-stylish">${tva_price} €</td>
                    </tr>
                    <tr>
                        <td class="price-stylish">TOTAL TTC</td>
                        <td class="price-stylish">${price_ttc} €</td>
                    </tr>
                </table>
            </div>
        </div>
    HTML;


    return $html_header . $html_body . $html_footer . $total_price_table;
}

function detailsDataTable($model): string
{
    $laboxy_prestation_duration = Yii::$app->formatter->asInteger($model->totalHourWithRisk);

    return <<<HTML
        <table>
            <tr>
                <td><p><mark class="stylish">Durée de la prestation : </mark>${laboxy_prestation_duration}</p></td>
            </tr>
            <tr>
                <td><p><mark class="stylish">Validité du devis : </mark>3 mois</p></td>
            </tr>
            <tr>
                <td><p><mark class="stylish">Condition de paiement : </mark>30 jours nets, date de facture</p></td>
            </tr>
            <tr>
                <td><p><mark class="stylish">Détails du paiement (échéancier) : </mark>Devis < 2000 €</p></td>
            </tr>
            <tr>
                <td><p>-30% à la commande</p></td>
            </tr>
            <tr>
                <td><p>-70% à la livraison des résultats</p></td>
            </tr>
        </table>
        <br />
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

function warningDataTable(): string
{
    return <<<HTML
        <table>
            <tr>
                <td class="textcenter">
                    <p class="warning">En cas d'acceptation, merci de nous retourner le présent devis daté et signé avec la mention :</p>
                    <p class="warning">"bon pour accord" et le cachet de votre entreprise.</p>
                    <p class="warning">La signature du présent contrat vaut acceptation des conditions générales de ventes jointes au devis</p>
                </td>
            </tr>
        </table>
    HTML;
}

function signatureDataTable()
{
    return <<<HTML
        <table>
            <tr>
                <td class="invisible">
                    Nom-Prenom :
                </td>
            </tr>
            <tr>
                <td class="invisible">
                    Fonction :
                </td>
            </tr>
            <tr>
                <td class="invisible">
                    Date :
                </td>
            </tr>
        </table>
    HTML;
}
