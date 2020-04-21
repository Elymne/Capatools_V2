<?php

use app\helper\_clazz\UserRoleManager;
use app\helper\_enum\UserRoleEnum;
use app\widgets\TopTitle;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\user\CapaUser */

$this->title = "Détail du salarié: " . $model->username;
$this->params['breadcrumbs'][] = ['label' => 'Capaidentities', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

// Get user roles.
$userRoles = [];
if ($model->id != null) $userRoles = UserRoleManager::getUserRoles($model->id);

// Get role by service.
$adminRole = UserRoleEnum::ADMINISTRATOR_ROLE_STRING[UserRoleManager::getSelectedAdminRoleKey($userRoles)];
$devisRole = UserRoleEnum::DEVIS_ROLE_STRING[UserRoleManager::getSelectedDevisRoleKey($userRoles)];

?>

<?= TopTitle::widget(['title' => $this->title]) ?>

<div class="container">
    <div class="capa_user-view">

        <div class="row">
            <div class="card">

                <div class="card-content">
                    <?= Html::a('Retour <i class="material-icons right">arrow_back</i>', ['index'], ['class' => 'waves-effect waves-light btn blue']) ?>

                    <?php if ($adminRole === UserRoleEnum::ADMINISTRATOR && !Yii::$app->user->can('superAdministrator')) : ?>
                        <?= Html::a('Modifier <i class="material-icons right">mode_edit</i>', ['#', -1], ['class' => 'btn disabled']) ?>
                    <?php else : ?>
                        <?= Html::a('Modifier <i class="material-icons right">mode_edit</i>', ['update', 'id' => $model->id], ['class' => 'waves-effect orange waves-light btn']) ?>
                    <?php endif ?>

                    <?= Html::a('Supprimer <i class="material-icons right">delete</i> ', ['delete', 'id' => $model->id], [
                        'class' => 'waves-effect waves-light btn red',
                        'data' => [
                            'confirm' => 'Etes vous sûr de vouloir supprimer ce salarié ?',
                            'method' => 'post',
                        ],
                    ]) ?>
                </div>

                <div class="card-content">
                    <?= DetailView::widget([
                        'model' => $model,
                        'options' => [
                            'class' => ['highlight']
                        ],
                        'attributes' => [
                            [
                                'label' => 'Nom et prénom',
                                'attribute' => 'username',
                            ],
                            'email:email',
                            [
                                'label' => 'Nom de la cellule',
                                'attribute' => 'cellule.name',
                            ],
                        ],
                    ]) ?>

                    <br /><br /><br />

                    <?php echo createRolesTable($adminRole, $devisRole); ?>

                </div>

            </div>
        </div>

    </div>
</div>

<?php

function createRolesTable(string $adminRole, string $devisRole): string
{

    $head = <<<HTML

        <table class="highlight">
            <tbody>
                <tr>
                    <td class='header'>Service</td>
                    <td class='header'>Rôle</td>
                </tr>    
    HTML;

    $body = '';



    // Admin row.
    $body = $body . <<<HTML
        <tr>
            <td>Administration</td>
            <td>${adminRole}</td>
        </tr>
    HTML;

    // Devis row.
    $body = $body . <<<HTML
        <tr>
            <td>Devis</td>
            <td>${devisRole}</td>
        </tr>
    HTML;

    $foot = <<<HTML
            </tbody>
        </table>
    HTML;

    return $head . $body . $foot;
}
