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
