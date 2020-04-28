<?php

use app\helper\_clazz\UserRoleManager;
use app\helper\_enum\UserRoleEnum;
use app\widgets\TopTitle;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\user\CapaUser */
/* @var $cellules app\models\devis\Cellule */

$this->title = 'Mise à jour de l\'utilisateur: ' . $model->username;
$this->params['breadcrumbs'][] = ['label' => 'Capaidentities', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';

// Get user roles.
$userRoles = [];
if ($model->id != null) $userRoles = UserRoleManager::getUserRoles($model->id);

$adminRole = UserRoleEnum::ADMINISTRATION_ROLE[UserRoleManager::getSelectedAdminRoleKey($userRoles)];
?>

<?= TopTitle::widget(['title' => $this->title]) ?>

<div class="container">
    <div class="capa_user-update">

        <?php if (canUpdateUser($adminRole)) : ?>
            <div class="row">
                <div class="col s6 offset-s3">

                    <div class="card">
                        <div class="card-action">
                            <?= $this->render('_form', [
                                'model' => $model,
                                'cellules' => $cellules
                            ]) ?>
                        </div>
                    </div>

                </div>
            </div>
        <?php else : ?>
            <div class="row">
                <div class="col s6 offset-s3">

                    <div class="card">
                        <div class="card-action">
                            <label>Vous ne pouvez pas modifier ce devis.</label>
                            <br />
                            <br />
                            <?= Html::a('Retour <i class="material-icons right">arrow_back</i>', ['index'], ['class' => 'waves-effect waves-light btn btn-grey']) ?>
                        </div>
                    </div>

                </div>
            </div>
        <?php endif ?>



    </div>
</div>


<?php

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
