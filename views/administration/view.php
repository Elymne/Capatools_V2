<?php

use app\helper\_clazz\UserRoleManager;
use app\helper\_enum\UserRoleEnum;
use app\widgets\TopTitle;
use yii\helpers\Html;
/* @var $this yii\web\View */
/* @var $model app\models\user\CapaUser */

$this->title = "Détail du salarié: " . $model->username;
$this->params['breadcrumbs'][] = ['label' => 'Capaidentities', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

// Get user roles.
$userRoles = [];
if ($model->id != null) $userRoles = UserRoleManager::getUserRoles($model->id);

$adminRole = UserRoleEnum::ADMINISTRATION_ROLE[UserRoleManager::getSelectedAdminRoleKey($userRoles)];

?>

<?= TopTitle::widget(['title' => $this->title]) ?>

<div class="container">
    <div class="capa_user-view">

        <div class="row">

            <div class="card">

                <div class="card-content">
                    <?= Html::a('Retour <i class="material-icons right">arrow_back</i>', ['index'], ['class' => 'waves-effect waves-light btn btn-grey']) ?>

                    <?php if (canUpdateUser($adminRole)) : ?>
                        <?= Html::a('Modifier <i class="material-icons right">mode_edit</i>', ['update', 'id' => $model->id], ['class' => 'waves-effect waves-light btn btn-green']) ?>
                    <?php else : ?>
                        <?= Html::a('Modifier <i class="material-icons right">mode_edit</i>', ['#', -1], ['class' => 'btn disabled']) ?>
                    <?php endif ?>

                    <?= Html::a('Supprimer <i class="material-icons right">delete</i> ', ['delete', 'id' => $model->id], [
                        'class' => 'waves-effect waves-light btn btn-red',
                        'data' => [
                            'confirm' => 'Etes vous sûr de vouloir supprimer ce salarié ?',
                            'method' => 'post',
                        ],
                    ]) ?>
                </div>

                <div class="card-content">
                    <?php echo createUserDataTable($model) ?>
                </div>

            </div>

            <div class="card">

                <div class="card-content">
                    <p> Droits utilisateur </p>
                </div>

                <div class="card-content">
                    <?php echo createRolesTable($userRoles) ?>
                </div>

            </div>

        </div>

    </div>
</div>

<?php

function createUserDataTable($model): string
{
    $username = $model->username;
    $email = $model->email;
    $cellule = $model->cellule->name;

    return <<<HTML
        <table class="highlight">
            <tbody>
                <tr>
                    <td width="30%" class="table-font-bold">Nom / prénom</td>
                    <td>${username}</td>
                </tr>
                <tr>
                    <td width="30%" class="table-font-bold">Email</td>
                    <td>${email}</td>
                </tr>  
                <tr>
                    <td width="30%" class="table-font-bold">Cellule</td>
                    <td>${cellule}</td>
                </tr>  
            </tbody>
        </table>
    HTML;
}

function createRolesTable(array $userRoles): string
{

    // Get role by service.
    $adminStringRole = UserRoleEnum::ADMINISTRATOR_ROLE_STRING[UserRoleManager::getSelectedAdminRoleKey($userRoles)];
    $devisStringRole = UserRoleEnum::DEVIS_ROLE_STRING[UserRoleManager::getSelectedDevisRoleKey($userRoles)];

    $head = <<<HTML

        <table class="highlight">
            <tbody>
                <tr>
                    <td class="table-font-bold">Service</td>
                    <td class="table-font-bold">Rôle</td>
                </tr>    
    HTML;

    $body = '';



    // Admin row.
    $body = $body . <<<HTML
        <tr>
            <td width="30%">Administration</td>
            <td>${adminStringRole}</td>
        </tr>
    HTML;

    // Devis row.
    $body = $body . <<<HTML
        <tr>
            <td width="30%">Devis</td>
            <td>${devisStringRole}</td>
        </tr>
    HTML;

    $foot = <<<HTML
            </tbody>
        </table>
    HTML;

    return $head . $body . $foot;
}

function canUpdateUser($adminRole): bool
{
    $result = true;

    if (
        !UserRoleManager::hasRoles([UserRoleEnum::SUPER_ADMINISTRATOR]) &&
        ($adminRole == UserRoleEnum::ADMINISTRATOR || $adminRole == UserRoleEnum::SUPER_ADMINISTRATOR)
    )  $result = false;

    if (UserRoleManager::hasRoles([UserRoleEnum::SUPER_ADMINISTRATOR]) && $adminRole == UserRoleEnum::SUPER_ADMINISTRATOR)
        $result = false;

    return $result;
}
