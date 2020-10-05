<?php

use app\models\projects\Project;
use app\assets\AppAsset;
use yii\helpers\Html;

AppAsset::register($this);

$id = $model->id;
if ($model->id_capa) $this->title = $model->id_capa;
else $this->title = "Modification d'un devis";

$this->params['breadcrumbs'][] = ['label' => 'Devis', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

// Laboxy prestation duration
$laboxy_prestation_duration = Yii::$app->formatter->asInteger($model->totalHourWithRisk) . ' jours';

$condition = YII::$app->basePath . "/web/images/pdf/conditiongeneral.png";
// Prices
$max_price = 0;
if ($model->company->country == "France") $hasTVA = true;
else $hasTVA = false;
foreach ($model->lots as $lot) $max_price +=  round(($lot->totalwithmargin + $model->additionallotprice) / (1 - $model->management_rate / 100), -2);
$tva_price = $max_price * 0.2;
$price_ttc = $max_price * 1.2;


setlocale(LC_TIME, "fr_FR");


?>

<div class="container">

    <div class="row">


        <!-- LOGOS & DATE -->
        <div class="col-print-5">
            <div class="row">
                <div class="capalogo-container">
                </div>
            </div>
            <div class="row">
                <div class="big-title">
                    <?= $model->internal_name ?>
                </div>
                <div class="sub-title">
                    Date: <?= $model->creation_date ?>
                </div>
            </div>
        </div>


        <!-- DEVIS -->
        <div class="col-print-7">
            <div class="row pull-right">
                <span class="txt-gray"><?= strftime("%A %d %B %G"); ?></span>
                <br>
                <br>
                <br>
            </div>

            <!-- CLIENT INFORMATIONS -->
            <div class="row bg-lightgray">
                <div class="client-infos"><b>DESTINATAIRE</b> <span class="txt-gray"> <?= $model->company->name ?></span> <br></div>
                <div class="client-infos"><b>ADRESSE</b> <span class="txt-gray"> <?= $model->company->address ?></span> <br></div>
                <div class="client-infos"><b>TVA</b> <span class="txt-gray"> <?= $model->company->tva ?></span> <br></div>
                <div class="client-infos"><b>EMAIL</b> <span class="txt-gray"> <?= $model->company->email ?></span> <br></div>
                <div class="client-infos"><b>TEL</b> <span class="txt-gray"> <?= $model->company->phone ?></span> <br></div>
            </div>
        </div>
    </div>
    <br>
    <br>


    <!-- REF: VALIDITY: PAYMENT: DETAILS PAYMENT -->
    <div class="row">
        <div class="col-print-3">
            <b>Référence:</b>
            <div class="txt-gray"><?= $model->internal_name ?></div>
        </div>
        <div class="col-print-3">
            <b>Validité du devis:</b>
            <div class="txt-gray">45 jours</div>
        </div>
        <div class="col-print-3">
            <b>Condition de paiement:</b>
            <div class="txt-gray">30 jours nets, date de facture</div>
        </div>
        <div class="col-print-3">
            <b>Détails du paiement(échéancier):</b>
            <div class="txt-gray">Devis &lt; 2000 € </div>
        </div>
    </div>



    <!-- DETAILS LOTS -->
    <div class="row">
        <?php echo lotsDataTables($model); ?>
    </div>

    <div class="row ">
        <div class="blue-border ">

            <div class="col-print-6 presta-duration">
                <div class="txt-bold">DURÉE DE LA PRESTATION: <span class="txt-gray"><?= $laboxy_prestation_duration ?></span></div>
            </div>
            <div class="col-print-6 lightblue-bg">
                <div class="row txt-bold">
                    <div class="col-print-8 white-txt">
                        <div class="total-data">MONTANT TOTAL HT </div>
                        <div class="total-data">TVA 20 % </div>
                        <div class="total-data">MONTANT TOTAL TTC</div>
                    </div>
                    <div class="col-print-4 total-values">
                        <div class="total-data"><?= $max_price ?> €</div>
                        <div class="total-data"><?= $tva_price ?> €</div>
                        <div class="total-data"><?= $price_ttc ?> €</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <!--  ALIGN RIGHT -->
            <div class="">
                <br>
                <div class="txt-gray pull-right"> 30% à la commande, 70% à la livraison des résultats </div>
            </div>
        </div>
    </div>

    <!-- ROUNDED NOTE -->
    <div class="row">
        <div class="rounded-border txt-gray center">
            En cas d'acceptation, merci de nous retourner le présent devis daté et signé avec la mention :
            "bon pour accord" et le cachet de votre entreprise.
            La signature du présent contrat vaut acceptation des conditions générales de ventes jointes au devis
        </div>
    </div>


    <br>
    <br>
    <br>
    <br>
    <br>
    <!-- SIGNATURE CONTAINER -->
    <div class="row txt-bold signature">
        <div class="col-print-4">
            Fait le :
            <br>
            <br>
            Fonction:
            <br>
            <br>
        </div>
        <div class="col-print-4">
            <br>
            <br>
            Signature:
            <br>
            <br>
        </div>
    </div>
</div>


<pagebreak />
<!--
<div class="col-print-12">
    <div class="row">
        <div class="col-print-6 side-section-legals">
            <div class="legals-content">
                <?php echo footerLeftSideInformation() ?>
            </div>
        </div>

        <div class="col-print-6 side-section-legals">
            <div class="legals-content">
                <?php echo footerRightSideInformation() ?>
            </div>
        </div>
    </div>
</div>

-->

<div class="col-print-12">
    <div class="row">
        <img src="<?= $condition ?>" width="210mm" height="297mm" margin=0>
    </div>
</div>

<?php


function lotsDataTables($model): string
{
    $quantity = 1;

    $html_header = <<<HTML
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
        $lot_total_price = round(($lot->totalwithmargin + $model->additionallotprice) / (1 - $model->management_rate / 100), -2);
        $lot_total_total_price = $lot_total_price * $quantity;

        $html_body = $html_body . <<<HTML
            <tbody>
                <tr>
                    <td><b>${lot_title}</b></td>
                    <td class="txt-gray">${lot_total_price}</td>
                    <td class="txt-gray">${quantity}</td>
                    <td class="txt-gray">${lot_total_total_price}</td>
                </tr>
            </tbody>
        HTML;
    }

    $html_footer = <<<HTML
        </table>
    HTML;

    return $html_header . $html_body . $html_footer;
}


function footerLeftSideInformation(): string
{
    return <<<HTML
        <b class="stylish-minus">CONDITIONS GÉNÉRALES DE PRESTATIONS DE SERVICE DE CAPACITÉS SAS</b>
        <p class="minus">La société CAPACITÉS, société par actions simplifiée inscrite au RCS de Nantes sous le numéro 483 434 247, au capiral social de 166 100 euros, dont le siège social est le sis 1, quai de Tourville à Nantes (44000), ci-après dénommée "CAPACITÉS", d'une part et le client tel que défini dans le devis, ci-après dénommé "le client", d'autre part. Les conditions générales de prestations de service (ci-après "les conditions générales"), et le devis incluant les conditions financières, forment un ensemble contractuel (ci-après 'le présent contrat"). Le cas échéant, les conditions particulières relatives à la cellule de compétences réalisant la prestation seront annexées aux présentes conditions générales et feront partie intégrante du présent contrat. Ces documents sont classés par ordre hiérarchique croissant, de telle manière que les dispositions du devis peuvent déroger aux dispositions des conditions générales. Tout autre document non expressément cité ci-dessus n'a pas de valeur contractuelle sans l'agrément exprès des parties et ne leur est pas opposable.</p>
        
        <b class="stylish-minus">ARTICLE 1 - OBJET</b>
        <p class="minus">Les présentes conditions générales ont pour objet de déterminer les obligations à la charge de chacune des parties.</p>
        
        <b class="stylish-minus">ARTICLE 2 - COLLABORATION À LA CHARGE DU CLIENT</b>
        <p class="minus"><b class="bluest-minus">2.1</b> Le client reconnaît être le seul à disposer des meilleures informations relatives à son entreprise et à ses activités commerciales et/ou industrielles. À ce titre, le client s'engage à respecter, du début de la relation contractuelle et tout au long de l'exécution du contrat, son obligation de collaboration avec les équipes de CAPACITÉS et en particulier, le cas échéant, lors de la rédaction d'un cahier des charges.</p>
        <p class="minus"><b class="bluest-minus">2.2</b> En l'absence de collaboration du client dans les délais requis, CAPACITÉS se réserve le droit de suspendre l'exécution des prestations ou de résilier le contrat. Cette obligation de collaboration est une obligation essentielle du contrat, ce que le client reconnaît expressément</p>
        <b class="stylish-minus">ARTICLE 3 - LOYAUTÉ ENTRE LES PARTIES</b>
        <p class="minus"><b class="bluest-minus">3.1</b> L'une et l'autre des parties aura, envers son co-contractant, un comportement loyal dans l'exécution du présent contrat. Ce comportement loyal comprend aussi bien la qualité des échanges entre les deux parties que les relations que l'une et l'autre des parties entretiennent avec les tiers.</p>
        <p class="minus"><b class="bluest-minus">3.2</b> Confidentialité : Chaque partie s'engage à ne pas publier, ni divulguer de quelque façon que ce soit les informations scientifiques, techniques, ou de toute nature, appartenant à l'autre partie dont elle pourrait avoir connaissance à l'occasion de l'exécution de la prestation. Chaque partie s'engage à ne donner accès aux informations confidentielles de l'autre partie, à l'intérieur de son propre établissement, qu'aux seuls membres et employés directement concernés par la prestation objet du présent contrat, à informer ses membres et employés des présentes obligations de confidentialité et s'engage à leur imposer individuellement le respect des engagements souscrits en vertu des présentes. Cette obligation de confidentialité sera valable à compter de la date d'entrée en vigueur du présent contrat et jusqu'à ce que les informations confidencielles tombent dans le domaine public. Toute publication ou communication portant sur la prestation ou ses résultats, par l'une des parties, devra recevir l'accord préalable écrit de l'autre partie qui fera connaître sa décision dans un délai maximum d'un mois à compter de la demande. Passé ce délai et faute de réponse, l'accord sera réputé acquis. Ces publications et communications devront mentionner le concours apporté par chacune des parties à la réalisation de la prestation.</p>
        <b class="stylish-minus">ARTICLE 4 - OBLIGATION CONTRACTUELLE - RESPONSABILITÉ DE CAPACITÉS</b>
        <p class="minus"><b class="bluest-minus">4.1</b> CAPACITÉS exécute les prestations dans le cadre d'une obligation de moyens et mettra tout en oeuvre pour assurer le bon déroulement de la prestation.</p>
        <p class="minus"><b class="bluest-minus">4.2</b> La responsabilité de CAPACITÉS ne pourra donc être engagée que sur la démonstration d'une faute exclusive imputable à CAPACITÉS.</p>
        <p class="minus"><b class="bluest-minus">4.3</b> La responsabilité de CAPACITÉS ne saurait être engagée en cas de force majeure tel défini par la jurisprudence française. En cas de prolongation de l'évènement au-delà d'une période de 3 (trois) mois, le contrat pourra être résilié par l'une ou l'autre des parties par lettre recommandée avec demande d'avis de réception.</p>
        <p class="minus"><b class="bluest-minus">4.4</b> Il est expressément convenu que, si la responsabilité de CAPACITÉS était reconnue judiciairement dans l'exécution du contrat, le client ne pourrait prétendre à d'autres indemnités et dommages-intérêts que le remboursement des règlements effectués, au titre du présent contrat. </p>
        <b class="stylish-minus">ARTICLE 5 - PROPRIÉTÉ INTELLECTUELLE</b>
        <p class="minus"> Les résultats de la prestation sont la propriété du client après complet paiement du prix mentionné par le devis. Le savoir-faire mis en oeuvre par CAPACITÉS pour réaliser la</p>
    HTML;
}

function footerRightSideInformation(): string
{
    return <<<HTML
        <p class="minus">prestation reste la propriété de l'Université de Nantes ou de CAPACITÉS : en conséquence, toute amélioration de ce savoir-faire demeurera leur propriété. L'évolution du présent contrat ne devra impliquer l'exercice d'aucune activité inventive nouvelle. En conséquence, elle ne devra pas déboucher sur la création d'éléments susceptibles d'être protégés au titre de la propriété industrielle. Dans le cas contraire, les parties s'engagent à s'en informer mutuellement et à négocier entre elles et de bonne foi un contrat spécifique ultérieur régissant notamment les règles de propriété et les conditions d'exploitation de ces éléments de propriété industrielle.</p>
        <b class="stylish-minus">ARTICLE 6 - CONDITIONS FINANCIÈRES</b>
        <p class="minus"><b class="bluest-minus">6.1</b> Détermination du prix et modalités de facturation 
            <br />Le montant du budget et les modalités de facturations sont détaillés dans le devis. Le devis a une durée de validité de 45 jours à compter de sa signature par CAPACITÉS
        </p>
        <p class="minus"><b class="bluest-minus">6.2</b> Le client s'engage à régler les factures dans les 30 (trente) jours nets à la date d'émission de facture
        </p>
        <p class="minus"><b class="bluest-minus">6.3</b> Retard de paiement 
            <br />De convention expresse, et sauf report sollicité à temps et accordé par CAPACITÉS de manière particulière et écrite, le défaut total ou partiel de paiement à l'échéance de toute somme due au titre du contrat entraînera de plein droit et sans mise en demeure préalable : 
            <br />- l'exigibilité immédiate de toutes les sommes restant dues par le client, même non encore facturées, au titre du contrat, quel que soit le mode de règlement prévu.
            <br />- les sommes précédemment versées par le client resteront acquises à CAPACITÉS. L'ensemble des frais de recouvrement sera à la charge du client.
            <br />- la facturation au client d'un intérêt de retard égal à une fois et demi le taux d'intérêt légal, dernier taux publié à la date de facturation, l'intérêt étant dû par le seul fait de l'échéance du terme contractuel. L'intérêt est calculé prorata temporis sur la période d'un mois.
        </p>
        <p class="minus"><b class="bluest-minus">6.4</b>
            Tout désaccord concernant la facturation devra être motivé par l'envoi d'une lettre recommandée avec demande d'avis de réception, dans les huit jours suivants la date d'émission de la facture. En l'absence de cette procédure, le client sera réputé avoir accepté celle-ci.
        </p>
        <b class="stylish-minus">ARTICLE 7 - ENTRÉE EN VIGUEUR ET DURÉE</b>
        <p class="minus">Le contrat prend effet à compter de la date de signature du contrat par les deux parties et est conclu pour la durée précisée par le devis.</p>
        <b class="stylish-minus">ARTICLE 8 - RÉSILIATION ANTICIPÉE</b>
        <p class="minus">
            Le présent contrat pourra être résilié par anticipation, par l'une ou l'autre des parties, en cas d'inexécution de l'une ou l'autre des obligations y figurant. La résiliation aura pour conséquence de rendre exigible l'ensemble des sommes dues à CAPACITÉS par le client qui s'engage à régler, sans délai, lesdites sommes.
            <br />La résiliation anticipée interviendra un mois après l'envoi d'une mise en demeure signifiée par la lettre recommandée avec demande d'avis de réception à la partie défaillante indiquant l'intention de faire application de la présente clause résolutoire expresse, restée, en tout ou partie, sans effet.
        </p>
        <b class="stylish-minus">ARTICLE 9 - DISPOSITIONS DIVERSES</b>
        <p class="minus"><b class="bluest-minus">9.1</b> Dans l'éventualité où l'une des quelconques dispositions du contrat serait déclarée nulle ou sans effet, de quelque façon et pour quelque motif que ce soit, elle serait réputée non écrite et n'entraînerait pas la nullité des autres dispositions.</p>
        <p class="minus"><b class="bluest-minus">9.2</b> CAPACITÉS déclare être assurée pour sa responsabilité civile professionnelle auprès d'une compagnie d'assurance notoirement solvable pour tous les dommages matériels et immatériels consécutifs à l'exécution du présent contrat par personnel ou ses collaborateurs.</p>
        <p class="minus"><b class="bluest-minus">9.3</b> En cas de traduction du contrat, seule la version en française fera foi.</p>
        <p class="minus"><b class="bluest-minus">9.4</b> Chaque partie est un entrepreneur indépendant et aucune des dispositions du présent contrat ne créera une société, de fait ou de droit, une société commune, un mandat, un contrat de franchise ou d'agent commercial ou un rapport de salariat, entre les parties.</p>
        <p class="minus"><b class="bluest-minus">9.5</b> Le client autorise CAPACITÉS à faire figurer sur son internet et sur ses plaquettes commerciales, la marque et/ou la dénomination sociale du client et une brève annonce de la conclusion du contrat avec le client.</p>
        <b class="stylish-minus">ARTICLE 10 - RÈGLEMENT DES LITIGES</b>
        <p class="minus">Le présent contrat est régi par le droit français. En cas de difficulté sur l'interprétation ou l'exécution du présent contrat, les parties s'efforceront de résoudre leur différend à l'amiable. En cas de désaccord persistant au-delà d'un mois, les litiges seront portés devant la juridiction française compétente.</p>
    HTML;
}
