<?php

use app\assets\administration\AdminIndexAsset;
use app\helper\_clazz\UserRoleManager;
use app\helper\_enum\UserRoleEnum;
use app\widgets\TopTitle;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\user\CapaUserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Liste des salariés';
$this->params['breadcrumbs'][] = $this->title;

AdminIndexAsset::register($this);

?>

<?= TopTitle::widget(['title' => $this->title]) ?>

<div class="container">
    <div class="capa_user-index">
        <div class="row">

            <div class="card">
                <div class="card-content">
                    <label>
                        Filtres
                    </label>
                </div>
                <div class="card-action">
                    <?php getSearchFilter($cellulesNames) ?>
                </div>
            </div>

            <div class="card">
                <div class="card-action">

                    <?php Pjax::begin(); ?>

                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'tableOptions' => [
                            'id' => 'admin_table',
                            'style' => 'height: 20px',
                            'class' => ['highlight']
                        ],
                        'columns' => getCollumnArray(),
                    ]); ?>

                    <?php Pjax::end(); ?>

                </div>
            </div>

        </div>

        <div style="bottom: 50px; right: 25px;" class="fixed-action-btn direction-top">
            <a href="/administration/create" class="btn-floating btn-large gradient-45deg-light-blue-cyan gradient-shadow">
                <i class="material-icons">add</i>
            </a>
        </div>

    </div>
</div>

<?php


function getSearchFilter(array $cellules)
{

    echo Select2::widget([
        'id' => 'cellule-name-search',
        'name' => 'droplist_cellule',
        'data' => $cellules,
        'pluginLoading' => false,
        'options' => ['style' => 'width:350px', 'placeholder' => 'Selectionner une cellule ...'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);

    echo '<br />';

    echo Html::input('text', 'textinput_user', '', [
        'id' => 'username-search',
        'class' => 'form-control',
        'maxlength' => 10,
        'style' => 'width:350px',
        'placeholder' => 'Rechercher un nom d\'utilisateur',
        'onkeyup' => 'usernameFilterSearch()'
    ]);

    echo '<br />';
}

/**
 * Used to display all data needed for the table.
 * 
 * @return Array All data for table.
 */
function getCollumnArray(): array
{

    $result = [];

    // Text input.
    array_push($result, getUsernameArray());
    array_push($result, getEmailArray());
    array_push($result, getCelluleArray());

    // Button input.
    array_push($result, getUpdateButtonArray());

    return $result;
}

function getUsernameArray(): array
{
    return [
        'attribute' => 'username',
        'format' => 'raw',
        'label' => '<span class="material-icons">arrow_drop_down</span> Salarié',
        'contentOptions' => ['class' => 'username-row'],
        'encodeLabel' => false,
        'value' => function ($data) {
            return Html::a($data['username'], ['administration/view', 'id' => $data['id']]);
        }
    ];
}

function getEmailArray(): array
{
    return [
        'label' => '<span class="material-icons">arrow_drop_down</span> Email',
        'encodeLabel' => false,
        'format' => 'ntext',
        'attribute' => 'email',
        'contentOptions' => ['class' => 'email-row'],
    ];
}

function getCelluleArray(): array
{
    return [
        'label' => '<span class="material-icons">arrow_drop_down</span> Cellule',
        'encodeLabel' => false,
        'format' => 'ntext',
        'attribute' => 'cellule.name',
        'contentOptions' => ['class' => 'cellule-row'],
    ];
}

function getUpdateButtonArray()
{
    return [
        'format' => 'raw',
        'label' => 'Modification',
        'value' => function ($model, $key, $index, $column) {

            // Get user roles.
            $userRoles = [];
            if ($model->id != null) $userRoles = UserRoleManager::getUserRoles($model->id);

            $adminRole = UserRoleEnum::ADMINISTRATION_ROLE[UserRoleManager::getSelectedAdminRoleKey($userRoles)];

            $buttonClass = "";
            if (canUpdateUser($adminRole)) $buttonClass = "waves-effect waves-light btn btn-green";
            else $buttonClass = "btn disabled";

            return Html::a(
                '<i class="material-icons right">edit</i> Modifier',
                Url::to(['administration/update', 'id' => $model->id]),
                [
                    'id' => 'grid-custom-button',
                    'data-pjax' => true,
                    'action' => Url::to(['administration/update', 'id' => $model->id]),
                    'class' => $buttonClass
                ]
            );
        }
    ];
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
