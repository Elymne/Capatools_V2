<?php

use app\helper\_clazz\UserRoleManager;
use app\helper\_enum\UserRoleEnum;
use app\widgets\TopTitle;
use yii\helpers\Html;
/* @var $this yii\web\View */
/* @var $model app\models\users\CapaUser */

$this->title = "Détails de la société : " . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'company_id', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

?>

<?= TopTitle::widget(['title' => $this->title]) ?>

<div class="container">
    <div class="capa_user-view">
        <div class="row">

            <div class="card">
                <div class="card-action">
                    <?= Html::a('Retour <i class="material-icons right">arrow_back</i>', ['index'], ['class' => 'waves-effect waves-light btn btn-grey']) ?>
                </div>

                <div class="card-action">
                    <?php echo createUserDataTable($model) ?>
                </div>
            </div>

            <div class="card">
                <div class="card-action">
                    <label>Liste des contacts</label>
                </div>

                <div class="card-action">
                    <?= Html::a('Ajouter des contacts', ['company/add-contacts', 'id' => $model['id']], ['class' => '']) ?>
                    <br /><br />
                    <?php echo createContactsTable($model->contacts) ?>
                </div>
            </div>

        </div>

    </div>
</div>

<?php

function createUserDataTable($model): string
{
    $username = $model->name;
    $email = $model->email;
    $address = $model->address;
    $phone = $model->phone;
    $siret = $model->siret;
    $tva = $model->tva;
    $type = $model->type;

    return <<<HTML
        <table class="highlight">
            <tbody>
                <tr>
                    <td width="30%" class="table-font-bold">Nom</td>
                    <td>${username}</td>
                </tr>
                <tr>
                    <td width="30%" class="table-font-bold">Email</td>
                    <td>${email}</td>
                </tr>  
                <tr>
                    <td width="30%" class="table-font-bold">Adresse</td>
                    <td>${address}</td>
                </tr>  
                <tr>
                    <td width="30%" class="table-font-bold">N° de téléphone</td>
                    <td>${phone}</td>
                </tr>  
                <tr>
                    <td width="30%" class="table-font-bold">Siret</td>
                    <td>${siret}</td>
                </tr>  
                <tr>
                    <td width="30%" class="table-font-bold">Tva</td>
                    <td>${tva}</td>
                </tr>  
                <tr>
                    <td width="30%" class="table-font-bold">Type de société</td>
                    <td>${type}</td>
                </tr>  
            </tbody>
        </table>
    HTML;
}

/**
 * Créer un tableau avec tous les contacts
 * @param Array<Contact> $model : List of milestones.
 * 
 * @return HTML table.
 */
function createContactsTable($contacts): string
{

    $statusRowBody = '';

    // When no milestone has been created.
    if (empty($milestones)) {
        return <<<HTML
            <p> Il n'y a aucuns contacts d'affiliés avec cette société </p>
        HTML;
    }

    // Create the header of milestone table.
    $headerTable = <<<HTML
        <table class="highlight">
            <tbody>
                <tr class="group">
                    <td class="header">Nom</td>
                    <td class="header">Prénom</td>
                    <td class="header">Email</td>
                    <td class="header">N° de téléphone</td>
                   
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
    foreach ($contacts as $contact) {

        $contactName = $contact->name;
        $contactFirstname = $contact->firstname;
        $contactEmail = $contact->email;
        $contactPhone = $contact->phone;

        $bodyTable = $bodyTable . <<<HTML
            <tr>
                <td>${contactName}</td>
                <td>${contactFirstname} €</td>
                <td>${contactEmail}</td>
                <td>${contactPhone}</td>
            </tr>   
        HTML;
    }

    return $headerTable . $bodyTable . $footerTable;
}
