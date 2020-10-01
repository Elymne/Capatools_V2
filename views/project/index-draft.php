<?php

use app\services\userRoleAccessServices\UserRoleEnum;
use app\services\userRoleAccessServices\UserRoleManager;
use app\widgets\TopTitle;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;

use app\models\projects\Project;

$this->title = 'Liste des brouillons';
$this->params['breadcrumbs'][] = $this->title;

?>

<?= TopTitle::widget(['title' => $this->title]) ?>

<div class="container">
    <div class="project-index">

        <!-- New -->
        <div class="row body-marger">


            <div class="card">
                <div class="card-action">

                    <div class="scroll-box">
                        <?php Pjax::begin(['id' => '1']) ?>
                        <?= GridView::widget([
                            'dataProvider' => $dataProvider,
                            'rowOptions' => [
                                'style' => 'height:20px;',
                                'text-overflow:ellipsis;'
                            ],
                            'tableOptions' => [
                                'id' => 'devis_table',
                                'style' => 'height: 10px',
                                'class' => ['highlight']
                            ],
                            'columns' => getCollumnsArray()
                        ]); ?>
                        <?php Pjax::end() ?>
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
    array_push($result, getUsernameArray());
    if (UserRoleManager::hasRoles([UserRoleEnum::ADMIN, UserRoleEnum::SUPER_ADMIN])) {
        array_push($result, getCelluleArray());
    }
    array_push($result, getCompanyArray());
    array_push($result, getStatusArray());

    // Buttons displaying.
    array_push($result, getUpdateButtonArray());
    array_push($result, getModelButtonArray());
    array_push($result, getDeleteButtonArray());
    array_push($result, getDuplicateButtonArray());

    return $result;
}

function getIdArray()
{
    return [
        'attribute' => 'id_capa',
        'format' => 'text',
        'label' => 'CapaID',
        'contentOptions' => ['class' => 'projectname-row'],
        'headerOptions' => ['class' => 'projectname-row'],
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

function getUsernameArray()
{
    return [
        'attribute' => 'project_manager.email',
        'format' => 'text',
        'label' => 'Resp projet',
        'contentOptions' => ['class' => 'projectmanager-row', 'style' => 'display: none'],
        'headerOptions' => ['class' => 'projectmanager-row', 'style' => 'display: none'],
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

function getModelButtonArray()
{

    return [
        'format' => 'raw',
        'label' => 'Modèle',
        'value' => function ($model, $key, $index, $column) {
            if ($model->state == Project::STATE_DEVIS_DRAFT) {
                return Html::a(
                    '<i class="material-icons right black-text">star_border</i>',
                    Url::to(['create-model', 'id' => $model->id]),
                    [
                        'id' => 'grid-custom-button',
                        'data-pjax' => true,
                        'action' => Url::to(['create-model', 'id' => $model->id]),
                        'class' => 'btn-floating waves-effect waves-light  yellow lighten-4',
                        'title' => "Modifier le devis"
                    ]
                );
            } else {

                return Html::a(
                    '<i class="material-icons right">star</i>',
                    Url::to(['create-model', 'id' => $model->id]),
                    [
                        'id' => 'grid-custom-button',
                        'data-pjax' => true,
                        'action' => Url::to(['create-model', 'id' => $model->id]),
                        'class' => 'btn-floating waves-effect waves-light btn-yellow',
                        'title' => "Modifier le devis"
                    ]
                );
            }
        }
    ];
}
function getUpdateButtonArray()
{
    return [
        'format' => 'raw',
        'label' => 'Visualiser',
        'value' => function ($model, $key, $index, $column) {
            return Html::a(
                '<i class="material-icons right">build</i>',
                Url::to(['project-simulate', 'project_id' => $model->id]),
                [
                    'id' => 'grid-custom-button',
                    'data-pjax' => true,
                    'action' => Url::to(['project-simulate', 'project_id' => $model->id]),
                    'class' => 'btn-floating waves-effect waves-light btn-green',
                    'title' => "Modifier le devis"
                ]
            );
        }
    ];
}
function getDeleteButtonArray()
{
    return [
        'format' => 'raw',
        'label' => 'Supp.',
        'value' => function ($model, $key, $index, $column) {
            if ($model->state == Project::STATE_DEVIS_DRAFT) {
                return Html::a(
                    '<i class="material-icons center">delete</i>',
                    Url::to(['delete-draft-project', 'id' => $model->id]),
                    [
                        'id' => 'grid-custom-button',
                        'data-pjax' => true,
                        'action' => Url::to(['delete-draft-project', 'id' => $model->id]),
                        'class' => 'btn-floating waves-effect waves-light btn-red',
                        'title' => "Supprimer le devis"
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
        'value' => function ($model, $key, $index, $column) {
            return Html::a(
                '<i class="material-icons center">content_copy</i>',
                Url::to(['duplicate-project', 'id' => $model->id]),
                [
                    'id' => 'grid-custom-button',
                    'data-pjax' => true,
                    'action' => Url::to(['duplicate-project', 'id' => $model->id]),
                    'class' => 'btn-floating waves-effect waves-light btn-blue',
                    'title' => "Dupliquer le devis"
                ]
            );
        }
    ];
}
