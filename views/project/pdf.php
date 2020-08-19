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
            <?php echo lotsDataTables($model) ?>
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

        <div class="col s12">
            <div class="row">
                <div class="col s5">
                    <?php echo footerLeftSideInformation() ?>
                </div>
                <div class="col s5">
                    <p> Salut </p>
                </div>
            </div>
        </div>

    </div>
</div>

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

function lotsDataTables($model): string
{

    $max_price = 0;
    $quantity = 1;

    if ($model->company->country == "France") $hasTVA = true;
    else $hasTVA = false;

    $html_header = <<<HTML
        <div class="row">
            <div class="col s12">
                <table>
                    <tr>
                        <th>Désignation</th>
                        <th>P.U HT</th>
                        <th>QTÉ</th>
                        <th>TOTAL HT</th>
                    </tr>
    HTML;

    $html_body = "";

    foreach ($model->lots as $lot) {
        $lot_title = $lot->title;
        $lot_total_price = $lot->getTotalWithMargin();
        $lot_total_total_price = $lot_total_price * $quantity;

        $max_price += $lot_total_price;

        $html_body = $html_body . <<<HTML
            <tr>
                <td>${lot_title}</td>
                <td>${lot_total_price}</td>
                <td>${quantity}</td>
                <td>${lot_total_total_price}</td>
            </tr>
        HTML;
    }

    $html_footer = <<<HTML
            </table>
        </div>
    HTML;

    $tva_price = $max_price * 0.2;
    $price_ttc = $max_price * 1.2;

    $total_price_table_header = <<<HTML
        <div class="col s3 offset-s9">
            <table>
    HTML;

    $total_price_table_data = <<<HTML
        <tr>
            <td class="price-stylish">TOTAL HT</td>
            <td class="price-stylish">${max_price} €</td>
        </tr>
    HTML;

    $total_price_tva_table_data = "";
    if ($hasTVA) {
        $total_price_tva_table_data = <<<HTML
            <tr>
                <td class="price-stylish">TVA 20%</td>
                <td class="price-stylish">${tva_price} €</td>
            </tr>
            <tr>
                <td class="price-stylish">TOTAL TTC</td>
                <td class="price-stylish">${price_ttc} €</td>
            </tr>
        HTML;
    }

    $total_price_table_footer_data = <<<HTML
                </table>
            </div>
        </div>
    HTML;

    return $html_header . $html_body . $html_footer . $total_price_table_header . $total_price_table_data . $total_price_tva_table_data . $total_price_table_footer_data;
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

function signatureDataTable(): string
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

function footerLeftSideInformation(): string
{
    return <<<HTML
        <b class="stylish-minus">CONDITIONS GÉNÉRALES DE PRESTATIONS DE SERVICE DE CAPACITÉS SAS</b>
        <p class="minus">La société CAPACITÉS, société par actions simplifiée inscrite au RCS de Nantes sous le numéro 483 434 247, au capiral social de 166 100 euros, dont le siège social est le sis 1, quai de Tourville à Nantes (44000), ci-après dénommée "CAPACITÉS", d'une part et le client tel que défini dans le devis, ci-après dénommé "le client", d'autre part. Les conditions générales de prestations de service (ci-après "les conditions générales"), et le devis incluant les conditions financières, forment un ensemble contractuel (ci-après 'le présent contrat"). Le cas échéant, les conditions particulières relatives à la cellule de compétences réalisant la prestation seront annexées aux présentes conditions générales et feront partie intégrante du présent contrat. Ces documents sont classés par ordre hiérarchique croissant, de telle manière que les dispositions du devis peuvent déroger aux dispositions des conditions générales. Tout autre document non expressément cité ci-dessus n'a pas de valeur contractuelle sans l'agrément exprès des parties et ne leur est pas opposable.</p>
        
        <b class="stylish-minus">ARTICLE 1 - OBJET</b>
        <p class="minus">Les présentes conditions générales ont pour objet de déterminer les obligations à la charge de chacune des parties.</p>
        
        <b class="stylish-minus">ARTICLE 2 - COLLABORATION À LA CHARGE DU CLIENT</b>
        <p class="minus"><b class="bluest-minus">2.1</b> Le client reconnaît être le seul à disposer des meilleurs informations relatives à son entreprise et à ses activités commerciales et/ou industrielles. À ce titre, le client s'engage à respecter, du début de la relation contractuelle et tout au long de l'exécution du contrat, son obligation de collaboration avec les équipes de CAPACITÉS et en particulier, le cas échéant, lors de la rédaction d'un cahier des charges.</p>
        <p class="minus"><b class="bluest-minus">2.2</b> En l'absence de collaboration du client dans les délais requis, CAPACITÉS se réserve le droit de suspendre l'exécution des prestations ou de résilier le contrat. Cette obligation de collaboration est une obligation essentielle du contrat, ce que le client reconnaît expresément</p>

        <b class="stylish-minus">ARTICLE 3 - LOYAUTÉ ENTRE LES PARTIES</b>
        <p class="minus"><b class="bluest-minus">3.1</b> L'une et l'autre des parties aura, envers son co-contractant, un comportement loyal dans l'exécution du présent contrat. Ce comportement loyal comprend aussi bien la qualité des échnages entre les deux parties que les relations que l'une et l'autre des parties entretiennent avec les tiers.</p>
        <p class="minus"><b class="bluest-minus">3.2</b> Confidentialité : Chaque partie s'engage à ne pas publier, ni divulguer de quelque façon que ce soit les informations scientifiques, techniques, ou de toute nature, appartenant à l'autre partie dont elle pourrait avoir connaissance à l'occasion de l'exécution de la prestation. Chaque partie s'engage à ne donner accès aux informations confidentielles de l'autre partie, à l'intérieur de son propre établissement, qu'aux seuls membres et employés directement concernés par la prestation objet du présent contrat, à informer ses membres et employés des présentes obligations de confidentialité et s'engage à leur imposer individuellement le respect des engagements souscrits en vertu des présentes. Cette obligation de confidentialité sera valable à compter de la date d'entrée en vigueur du présent contrat et jusqu'à ce que les informations cnfidencielles tombent dans le domaine public. Toute publication ou communication portant sur la prestation ou ses résultats, par l'une des parties, devra recevir l'accord préalable écrit de l'autre partie qui fera connaître sa décision dans un délai maximum d'un mois à compter de la demande. Passé ce délai et faute de réponse, l'accord sera réputé acquis. Ces publications et communications devront mentionner le concours apporté par chacune des parties à la réalisation de la prestation.</p>


    HTML;
}
