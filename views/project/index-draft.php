<?php

use app\assets\projects\ProjectIndexDraftAsset;
use app\assets\AppAsset;
use app\widgets\TopTitle;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use app\models\projects\Project;

AppAsset::register($this);
ProjectIndexDraftAsset::register($this);
$this->title = 'Liste des brouillons';
$this->params['breadcrumbs'][] = $this->title;

?>

<?= TopTitle::widget(['title' => $this->title]) ?>

<div class="container">
    <div class="project-index">
        <!-- New -->
        <div class="row body-marger">
            <div class="card">
                <div class="card-content">
                    <label>Réglage du tableau</label>
                </div>
                <div class="card-action">
                    <label class="rigthspace-20px">
                        <input type="checkbox" class="filled-in" checked="checked" id="capaid-checkbox" />
                        <span class="span-combobox">CapaID</span>
                    </label>
                    <label class="rigthspace-20px">
                        <input type="checkbox" class="filled-in" checked="checked" id="projectname-checkbox" />
                        <span class="span-combobox">Nom interne</span>
                    </label>
                    <?php if (false) : /* if (UserRoleManager::hasRoles([UserRoleEnum::ADMIN, UserRoleEnum::SUPER_ADMIN, UserRoleEnum::ACCOUNTING_SUPPORT])) : */ ?>
                        <label class="rigthspace-20px">
                            <input type="checkbox" class="filled-in" id="cellule-checkbox" />
                            <span class="span-combobox">Cellule</span>
                        </label>
                    <?php endif; ?>
                    <label class="rigthspace-20px">
                        <input type="checkbox" class="filled-in" checked="checked" id="company-checkbox" />
                        <span class="span-combobox">Client</span>
                    </label>
                </div>
            </div>
            <div class="card">
                <div class="card-action">
                    <div>
                        <?= GridView::widget([
                            'dataProvider' => $dataProvider,
                            'tableOptions' => [
                                'id' => 'devis_table',
                                'class' => ['highlight']
                            ],
                            'columns' => getCollumnsArray()
                        ]); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php

/**
 * Used to display all data needed for the table.
 * 
 * @return Array All data for table.
 */
function getCollumnsArray()
{
    $result = [];
    array_push($result, getIdArray());
    array_push($result, getInternalNameArray());
    if (false) {
        array_push($result, getCelluleArray());
    }
    array_push($result, getCompanyArray());
    // Buttons displaying.
    array_push($result, getUpdateButtonArray());
    array_push($result, getDeleteButtonArray());

    return $result;
}

function getIdArray()
{
    return [
        'attribute' => 'capaidreduc',
        'format' => 'text',
        'label' => 'CapaID',
        'contentOptions' => ['class' => 'capaid-row'],
        'headerOptions' => ['class' => 'capaid-row'],
    ];
}

function getInternalNameArray()
{
    return [
        'attribute' => 'internal_name',
        'format' => 'text',
        'label' => 'Nom interne',
        'contentOptions' => ['class' => 'projectname-row'],
        'headerOptions' => ['class' => 'projectname-row'],
    ];
}

function getCelluleArray()
{
    return [
        'attribute' => 'cellule.name',
        'format' => 'text',
        'label' => 'Cellule',
        'contentOptions' => ['class' => 'cellule-row'],
        'headerOptions' => ['class' => 'cellule-row'],
    ];
}

function getCompanyArray()
{
    return [
        'attribute' => 'company.name',
        'format' => 'text',
        'label' => 'Client',
        'contentOptions' => ['class' => 'company-row'],
        'headerOptions' => ['class' => 'company-row'],
    ];
}

function getStatusArray()
{
    return [
        'attribute' => 'state',
        'format' => 'text',
        'label' => 'Statut',
        'contentOptions' => ['class' => 'status-row'],
        'headerOptions' => ['class' => 'status-row'],
    ];
}

function getUpdateButtonArray()
{
    return [
        'format' => 'raw',
        'label' => 'Voir',
        'headerOptions' => ['style' => 'width:1%'],
        'contentOptions' => ['style' => 'width:1%'],
        'value' => function ($model, $key, $index, $column) {
            return Html::a(
                '<i class="material-icons center">build</i>',
                Url::to(['project-simulate', 'project_id' => $model->id]),
                [
                    'id' => 'grid-custom-button',
                    'data-pjax' => true,
                    'action' => Url::to(['project-simulate', 'project_id' => $model->id]),
                    'class' => 'btn-floating-minus waves-effect waves-light btn-green',
                    'title' => "Permet d'accéder au devis",
                    'target' => '_blank'
                ]
            );
        }
    ];
}

function getModelButtonArray()
{
    return [
        'format' => 'raw',
        'label' => "Mod.",
        'headerOptions' => ['style' => 'width:1%'],
        'contentOptions' => ['style' => 'width:1%'],
        'value' => function ($model, $key, $index, $column) {
            if ($model->state == Project::STATE_DEVIS_DRAFT) {
                return Html::a(
                    '<i class="material-icons center black-text">star_border</i>',
                    Url::to(['create-model', 'id' => $model->id, 'view' => 'index']),
                    [
                        'id' => 'grid-custom-button',
                        'data-pjax' => true,
                        'action' => Url::to(['create-model', 'id' => $model->id, 'view' => 'index']),
                        'class' => 'btn-floating-minus waves-effect waves-light  yellow lighten-4',
                        'title' => "Transforme ce devis en modèle"
                    ]
                );
            } else {
                return Html::a(
                    '<i class="material-icons center">star</i>',
                    Url::to(['create-model', 'id' => $model->id, 'view' => 'index']),
                    [
                        'id' => 'grid-custom-button',
                        'data-pjax' => true,
                        'action' => Url::to(['create-model', 'id' => $model->id, 'view' => 'index']),
                        'class' => 'btn-floating-minus waves-effect waves-light btn-yellow',
                        'title' => "Transforme ce devis en modèle"
                    ]
                );
            }
        }
    ];
}

function getDeleteButtonArray()
{
    return [
        'format' => 'raw',
        'label' => 'Sup.',
        'headerOptions' => ['style' => 'width:1%'],
        'contentOptions' => ['style' => 'width:1%'],
        'value' => function ($model, $key, $index, $column) {
            if ($model->state == Project::STATE_DEVIS_DRAFT) {
                return Html::a(
                    '<i class="material-icons center">delete</i>',
                    Url::to(['delete-draft-project', 'id' => $model->id]),
                    [
                        'id' => 'grid-custom-button',
                        'data-pjax' => true,
                        'action' => Url::to(['delete-draft-project', 'id' => $model->id]),
                        'class' => 'btn-floating-minus waves-effect waves-light btn-red',
                        'title' => "Permet de supprimer le devis"
                    ]
                );
            } else {
                return "";
            }
        }
    ];
}

function getDuplicateButtonArray()
{
    return [
        'format' => 'raw',
        'label' => 'Dupl.',
        'headerOptions' => ['style' => 'width:1%'],
        'contentOptions' => ['style' => 'width:1%'],
        'value' => function ($model, $key, $index, $column) {
            return Html::a(
                '<i class="material-icons center">content_copy</i>',
                Url::to(['duplicate-project', 'id' => $model->id]),
                [
                    'id' => 'grid-custom-button',
                    'data-pjax' => true,
                    'action' => Url::to(['duplicate-project', 'id' => $model->id]),
                    'class' => 'btn-floating-minus waves-effect waves-light btn-blue',
                    'title' => "Dupliquer le devis",
                    'target' => '_blank'
                ]
            );
        }
    ];
}
