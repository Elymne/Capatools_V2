<?php

use app\models\users\CapaUser;
use app\services\userRoleAccessServices\UserRoleEnum;
use app\services\userRoleAccessServices\UserRoleManager;
use app\widgets\TopTitle;
use yii\helpers\Html;
/* @var $this yii\web\View */
/* @var $model app\models\users\CapaUser */

$this->title = "Détail du salarié : " . $model->email;
$this->params['breadcrumbs'][] = ['label' => 'Capaidentities', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

// Get user roles.
$userRoles = [];
if ($model->id != null) $userRoles = UserRoleManager::getUserRoles($model->id);

?>

<?= TopTitle::widget(['title' => $this->title]) ?>

<div class="container">
    <div class="capa_user-view">
        <div class="row">

            <div class="card">
                <div class="card-action">
                    <?= Html::a('Retour <i class="material-icons right">arrow_back</i>', ['index'], ['class' => 'waves-effect waves-light btn btn-grey']) ?>

                    <?php if (UserRoleManager::canUpdateUser($userRoles)) : ?>
                        <?= Html::a('Modifier <i class="material-icons right">mode_edit</i>', ['update', 'id' => $model->id], ['class' => 'waves-effect waves-light btn btn-green']) ?>
                    <?php else : ?>
                        <?= Html::a('Modifier <i class="material-icons right">mode_edit</i>', ['#', -1], ['class' => 'btn disabled']) ?>
                    <?php endif ?>

                    <?= Html::a('Supprimer <i class="material-icons right">delete</i> ', ['delete', 'id' => $model->id], [
                        'class' => 'waves-effect waves-light btn btn-grey',
                        'data' => [
                            'confirm' => 'Etes vous sûr de vouloir supprimer ce salarié ?',
                            'method' => 'post',
                        ],
                    ]) ?>
                </div>

                <div class="card-action">
                    <?php echo createUserDataTable($model) ?>
                </div>
            </div>

            <div class="card">
                <div class="card-content">
                    <label> Droits utilisateur </label>
                </div>

                <div class="card-action">
                    <?php echo createRolesTable($userRoles) ?>
                </div>
            </div>

        </div>

    </div>
</div>

<?php

function createUserDataTable(CapaUser $model): string
{
    $surname = $model->surname;
    $firstname = $model->firstname;
    $email = $model->email;
    $cellule = $model->cellule->name;
    $salary = $model->price;
    $active = 'non';
    if ($model->flag_active) $active = 'oui';

    return <<<HTML
        <table class="highlight">
            <tbody>
                <tr>
                    <td width="30%" class="table-font-bold">Nom</td>
                    <td>${surname}</td>
                </tr>
                <tr>
                    <td width="30%" class="table-font-bold">Prénom</td>
                    <td>${firstname}</td>
                </tr>
                <tr>
                    <td width="30%" class="table-font-bold">Email</td>
                    <td>${email}</td>
                </tr>  
                <tr>
                    <td width="30%" class="table-font-bold">Cellule</td>
                    <td>${cellule}</td>
                </tr>  
                <tr>
                    <td width="30%" class="table-font-bold">Prix d'intervention</td>
                    <td>${salary} (€)</td>
                </tr>  
                <tr>
                    <td width="30%" class="table-font-bold">Utilisateur actif</td>
                    <td>${active}</td>
                </tr>  
            </tbody>
        </table>
    HTML;
}

function createRolesTable(array $userRoles): string
{

    $userRoleString = [];
    if (in_array(UserRoleEnum::SALARY, $userRoles)) array_push($userRoleString, 'Salarié');
    if (in_array(UserRoleEnum::PROJECT_MANAGER, $userRoles)) array_push($userRoleString, 'Chef de projet');
    if (in_array(UserRoleEnum::CELLULE_MANAGER, $userRoles)) array_push($userRoleString, 'Resp. de cellule');
    if (in_array(UserRoleEnum::HUMAN_RESSOURCES, $userRoles)) array_push($userRoleString, 'Resp. ressources humaine');
    if (in_array(UserRoleEnum::SUPPORT, $userRoles)) array_push($userRoleString, 'Support');
    if (in_array(UserRoleEnum::ADMIN, $userRoles)) array_push($userRoleString, 'Administrateur');
    if (in_array(UserRoleEnum::SUPER_ADMIN, $userRoles)) array_push($userRoleString, 'Super administrateur');

    $head = <<<HTML
        <table class="highlight">
            <tbody>
                <tr>
                    
    HTML;

    $body = '';
    foreach ($userRoleString as $value) {
        $body = $body . <<<HTML
            <td>${value}</td>
    HTML;
    }

    $foot = <<<HTML
                </tr>
            </tbody>
        </table>
    HTML;

    return $head . $body . $foot;
}
