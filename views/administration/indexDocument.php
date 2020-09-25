<?php

use app\assets\AppAsset;
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

AppAsset::register($this);
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
                    <div class="col s3">
                        <p>Filtre nom du document :</p>
                        <?= getSearchNameFilter() ?>
                    </div>
                    <div class="col s3">
                        <p>Filtre type de document :</p>
                        <?= getSearchtypeFilter($category) ?>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-action">
                    <div class="scroll-box">
                        <?php Pjax::begin(); ?>
                        <?= GridView::widget([
                            'dataProvider' => $dataProvider,
                            'tableOptions' => [
                                'id' => 'document_table',
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
function getSearchNameFilter()
{
    echo Html::input('text', 'textinput_user', '', [
        'id' => 'indexdocument-name-search',
        'class' => 'form-control',
        'maxlength' => 50,
        'style' => 'width:350px',
        'placeholder' => 'Rechercher un nom de document',
        'onkeyup' => 'onInputDocumentNameChange()'
    ]);
}
function getSearchtypeFilter($category)
{
    echo Select2::widget([
        'id' => 'type-name-search',
        'name' => 'droplist_type',
        'data' => ArrayHelper::map($category, 'type', 'type'),
        'pluginLoading' => false,
        'hideSearch' => true,
        'options' => ['style' => 'width:350px', 'placeholder' => 'Selectionner une categorie ...'],
        'pluginOptions' => [
            'allowClear' => true
        ],
        'pluginEvents' => [
            "change" => "() => { onSelectTypeChange() }",
        ]
    ]);
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
        "attribute" => "document.internal_name",
        'label' => 'Titre du document',
        "format" => "raw",
        'attribute' => 'title',
        "contentOptions" => ["class" => "document-internal_name-row"],
        "headerOptions" => ["class" => "document-internal_name-row"],
    ];
}

function getTypeArray(): array
{
    return [
        "attribute" => "document.internal_type",
        'label' => 'Type du document',
        "format" => "raw",
        'attribute' => 'type',
        "contentOptions" => ["class" => "document-internal_type-row"],
        "headerOptions" => ["class" => "document-internal_type-row"],

    ];
}

function getLastUpdateArray(): array
{
    return [
        'label' => 'Date de mise à jour',
        "attribute" => "document.internal_lastupdate",
        "format" => "raw",
        'attribute' => 'type',
        "contentOptions" => ["class" => "document-internal_lastupdate-row"],
        "headerOptions" => ["class" => "document-internal_lastupdate-row"],

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
