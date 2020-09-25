<?php

use app\services\userRoleAccessServices\UserRoleEnum;
use app\services\userRoleAccessServices\UserRoleManager;
use app\assets\administration\DocumentIndexAsset;
use app\widgets\TopTitle;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;

use yii\helpers\ArrayHelper;


$this->title = 'Liste des documents administratifs';
$this->params['breadcrumbs'][] = $this->title;

DocumentIndexAsset::register($this);
?>

<?= TopTitle::widget(['title' => $this->title]) ?>

<div class="container">
    <div class="laboratory-index">
        <div class="row">
            <div class="card">
                <div class="card-content">
                    <label>
                        Filtres
                    </label>
                </div>
                <div class="card-action">
                    <?php getSearchFilter($category) ?>
                </div>
            </div>
            <div class="card">
                <div class="card-action">
                    <div class="scroll-box">
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
        </div>
        <?php if (UserRoleManager::hasRoles([UserRoleEnum::ADMIN, UserRoleEnum::SUPER_ADMIN, UserRoleEnum::HUMAN_RESSOURCES, UserRoleEnum::ACCOUNTING_SUPPORT])) { ?>
            <div style="bottom: 50px; right: 25px;" class="fixed-action-btn direction-top">
                <a href="/administration/create-document" class="btn-floating btn-large gradient-45deg-light-blue-cyan gradient-shadow">
                    <i class="material-icons">add</i>
                </a>
            </div>
        <?php } ?>

    </div>
</div>

<?php

function getSearchFilter($category)
{
    echo Select2::widget([
        'id' => 'company-name-search',
        'name' => 'droplist_company',
        'data' => ArrayHelper::map($category, 'type', 'type'),
        'pluginLoading' => false,
        'options' => ['style' => 'width:350px', 'placeholder' => 'Selectionner une categorie ...'],
        'pluginOptions' => [
            'allowClear' => true
        ]
    ]);

    echo '<br />';
    echo Html::input('text', 'textinput_user', '', [
        'id' => 'indexdocument-name-search',
        'class' => 'form-control',
        'maxlength' => 50,
        'style' => 'width:350px',
        'placeholder' => 'Rechercher un nom de document',
        'onkeyup' => 'docuementNameFilterSearch()'
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
    array_push($result, getNameArray());
    array_push($result, getTypeArray());
    array_push($result, getLastUpdateArray());

    array_push($result, getDownloadButtonArray());
    if (UserRoleManager::hasRoles([UserRoleEnum::ADMIN, UserRoleEnum::SUPER_ADMIN, UserRoleEnum::HUMAN_RESSOURCES, UserRoleEnum::ACCOUNTING_SUPPORT])) {
        array_push($result, getUpdateButtonArray());
        array_push($result, getDeleteButtonArray());
    }
    return $result;
}

function getNameArray(): array
{
    return [
        'label' => 'Titre du document',
        'encodeLabel' => false,
        'format' => 'ntext',
        'attribute' => 'title',
        'contentOptions' => ['class' => 'title-row'],
    ];
}

function getTypeArray(): array
{
    return [
        'label' => 'Type du document',
        'encodeLabel' => false,
        'format' => 'ntext',
        'attribute' => 'type',
        'contentOptions' => ['class' => 'type-row'],
    ];
}

function getLastUpdateArray(): array
{
    return [
        'label' => 'Date de mise à jour',
        'encodeLabel' => false,
        'format' => 'ntext',
        'attribute' => 'last_update_date',
        'contentOptions' => ['class' => 'price_day-row'],
    ];
}
function getDownloadButtonArray()
{
    return [
        'format' => 'raw',
        'label' => 'Télécharger',
        'value' => function ($model, $key, $index, $column) {
            return Html::a(
                '<i class="material-icons right">file_download</i>',
                Url::to([$model->internal_link]),
                [
                    'id' => 'grid-custom-button',
                    'data-pjax' => true,
                    'target' => '_blank',
                    'action' => Url::to([$model->internal_link]),
                    'class' => 'btn-floating waves-effect waves-light btn-blue',
                    'title' => "Télécharge le document"
                ]
            );
        }
    ];
}
function getUpdateButtonArray()
{
    return [
        'format' => 'raw',
        'label' => 'Editer',
        'value' => function ($model, $key, $index, $column) {
            return Html::a(
                '<i class="material-icons right">build</i>',
                Url::to(['update-document', 'id' => $model->id]),
                [
                    'id' => 'grid-custom-button',
                    'data-pjax' => true,
                    'action' => Url::to(['update-document', 'id' => $model->id]),
                    'class' => 'btn-floating waves-effect waves-light btn-green',
                    'title' => "Modifier le document"
                ]
            );
        }
    ];
}

function getDeleteButtonArray()
{
    return [
        'format' => 'raw',
        'label' => 'supprimer',
        'value' => function ($model, $key, $index, $column) {
            return Html::a(
                '<i class="material-icons center">delete</i>',
                Url::to(['delete-document', 'id' => $model->id]),
                [
                    'id' => 'grid-custom-button',
                    'data-pjax' => true,
                    'action' => Url::to(['delete-document', 'id' => $model->id]),
                    'class' => 'btn-floating waves-effect waves-light btn-red',
                    'title' => "Supprimer "
                ]
            );
        }
    ];
}
