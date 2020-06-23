<?php

use app\widgets\TopTitle;
use yii\helpers\Html;
/* @var $this yii\web\View */
/* @var $model app\models\users\CapaUser */

$this->title = 'Paramètres de devis';
$this->params['breadcrumbs'][] = ['label' => 'DevisParameters', 'url' => ['manage-devis-parameters']];
$this->params['breadcrumbs'][] = 'Update';
\yii\web\YiiAsset::register($this);

?>

<?= TopTitle::widget(['title' => $this->title]) ?>

<div class="container">
    <div class="capa_user-view">
        <div class="row">

            <div class="card">
                <div class="card-action">
                    <?= Html::a('Modifier <i class="material-icons right">mode_edit</i>', ['manage-devis-parameters'], ['class' => 'waves-effect waves-light btn btn-green']) ?>
                </div>

                <div class="card-action">
                    <?php echo createParamsDataTable($model) ?>
                </div>
            </div>

        </div>

    </div>
</div>

<?php

function createParamsDataTable($model): string
{
    $iban = $model->iban;
    $bic = $model->bic;
    $banking_domiciliation = $model->banking_domiciliation;
    $address = $model->address;
    $legal_status = $model->legal_status;
    $devis_note = $model->devis_note;

    return <<<HTML
        <table class="highlight">
            <tbody>
                <tr>
                    <td width="30%" class="table-font-bold">Iban</td>
                    <td>${iban}</td>
                </tr>
                <tr>
                    <td width="30%" class="table-font-bold">Bic</td>
                    <td>${bic}</td>
                </tr>  
                <tr>
                    <td width="30%" class="table-font-bold">Domiciliation bancaire</td>
                    <td>${banking_domiciliation}</td>
                </tr>
                <tr>
                    <td width="30%" class="table-font-bold">Adresse</td>
                    <td>${address}</td>
                </tr>  
                <tr>
                    <td width="30%" class="table-font-bold">Status juridique</td>
                    <td>${legal_status}</td>
                </tr>  
                <tr>
                    <td width="30%" class="table-font-bold">Note de devis</td>
                    <td>${devis_note}</td>
                </tr>
                <tr>
                    <td width="30%" class="table-font-bold">CGU FR</td>
                    <td><a href="/administration/download-cgu-fr-file" target="_blank">Télécharger</a></td>
                </tr>
                <tr>
                    <td width="30%" class="table-font-bold">CGU EN</td>
                    <td><a href="/administration/download-cgu-en-file" target="_blank">Télécharger</a></td>
                </tr>
            </tbody>
        </table>
    HTML;
}
