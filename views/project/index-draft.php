<?php

use app\services\userRoleAccessServices\UserRoleEnum;
use app\services\userRoleAccessServices\UserRoleManager;
use app\widgets\TopTitle;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;

$this->title = 'Liste des projets';
$this->params['breadcrumbs'][] = $this->title;

?>

<?= TopTitle::widget(['title' => $this->title]) ?>

<div class="container">
    <div class="project-index">

        <!-- New -->
        <div class="row">

            <div class="card">
                <div class="card-action">

                    <br />
                    <?php Pjax::begin(['id' => '1']); ?>

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

                    <?php Pjax::end(); ?>

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

function getUpdateButtonArray()
{
    return [
        'format' => 'raw',
        'label' => 'Edit',
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
