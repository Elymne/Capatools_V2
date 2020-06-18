<?php

use app\services\companyTypeServices\CompanyTypeEnum;
use app\widgets\TopTitle;
/* @var $this yii\web\View */
/* @var $model app\models\devis\Devis */

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
                    <span style="color:white">Devis</span>
                </div>
                <div class="card-action">
                    <?php echo devisDataTable($model) ?>
                </div>
            </div>

            <div class="card">
                <div class="card-content">
                    <span style="color:white">Prix</span>
                </div>
                <div class="card-action">
                    <?php echo priceDataTable($model) ?>
                </div>
            </div>


            <div class="card">

                <div class="card-content">
                    <span style="color:white">Prestation</span>
                </div>

                <div class="card-action">
                    <?php echo prestationDataTable($model); ?>
                </div>
            </div>

            <br />
            <br />
            <br />

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
    $company_type = CompanyTypeEnum::getTypeCompanyString($model->company->type);
    $company_address = $model->company->address;
    $company_phone = $model->company->phone;
    $company_email = $model->company->email;
    $company_siret = $model->company->siret;
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
            </tbody>
        </table>
   HTML;
}

function devisDataTable($model): string
{
    $devis_name = $model->internal_name;
    $devis_date = $model->creation_date;
    $user_name = $model->capa_user->username;
    $user_cellule = strtolower($model->capa_user->cellule->name);

    return <<<HTML
        <table class="highlight">
            <tbody>
                <tr>
                    <td class='header'>Référence</td>
                    <td>${devis_name}</td>
                </tr>
                <tr>
                    <td class='header'>Date</td>
                    <td>${devis_date}</td>
                </tr>
                <tr>
                    <td class='header'>Proposition de</td>
                    <td>${user_name}</td>
                </tr>
                <tr>
                    <td class='header'>Laboratoire</td>
                    <td>${user_cellule}</td>
                </tr>
            </tbody>
        </table>
   HTML;
}

function priceDataTable($model)
{
    $delivery_name = "livraison";
    $delivery_quantity = $model->quantity;
    $delivery_unit_price = $model->unit_price;
    $delivery_price = $model->price;

    return <<<HTML
        <table class="highlight">
            <tbody>
                <tr>
                    <td class='header'>Désignation</td>
                    <td class='header'>P.U HT</td>
                    <td class='header'>Quantité</td>
                    <td class='header'>Prix total</td>
                </tr>
                <tr>
                    <td>${delivery_name}</td>
                    <td>${delivery_quantity}</td>
                    <td>${delivery_unit_price}</td>
                    <td>${delivery_price}</td>
                </tr>
            </tbody>
        </table>
   HTML;
}

function prestationDataTable($model): string
{


    $delivery_duration_hour = $model->service_duration;
    $delivery_duration_day = $model->service_duration_day;
    $delivery_validity_duration = $model->validity_duration;
    $delivery_payment_conditions = $model->payment_conditions;
    $delivery_payment_details = $model->payment_details;

    return <<<HTML
        <table class="highlight">
            <tbody>
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
                    <td class='header'>Echéancier</td>
                    <td>${delivery_payment_details}</td>
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
