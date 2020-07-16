<?php

use app\assets\projects\ProjectIndexAsset;
use app\services\userRoleAccessServices\UserRoleEnum;
use app\services\userRoleAccessServices\UserRoleManager;
use app\widgets\TopTitle;
use kartik\select2\Select2;
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
    array_push($result, getDocumentButtonArray());
    array_push($result, getPdfButtonArray());
    array_push($result, getExcelButtonArray());

    return $result;
}

function getIdArray()
{
    return [
        'attribute' => 'id_capa',
        'format' => 'raw',
        'label' => 'CapaID',
        'contentOptions' => ['class' => 'capaid-row'],
        'headerOptions' => ['class' => 'capaid-row'],
        'value' => function ($data) {
            return Html::a($data['id_capa'], ['project/view', 'id' => $data['id']], ['target' => '_blank',]);
        }
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
                Url::to(['devis/update', 'id' => $model->id]),
                [
                    'id' => 'grid-custom-button',
                    'data-pjax' => true,
                    'action' => Url::to(['devis/update', 'id' => $model->id]),
                    'class' => 'btn-floating waves-effect waves-light btn-green',
                    'title' => "Modifier le devis"
                ]
            );
        }
    ];
}

function getDocumentButtonArray()
{
    return [
        'format' => 'raw',
        'label' => 'upload',
        'value' => function ($model, $key, $index, $column) {

            if ($model->file_path != null) {
                return Html::a(
                    '<i class="material-icons right">cloud_download</i>',
                    Url::to(['project/download-file', 'id' => $model->id]),
                    [
                        'id' => 'grid-custom-button',
                        'data-pjax' => true,
                        'class' => 'btn-floating waves-effect waves-light btn-blue',
                    ]
                );
            } else {
                return Html::a(
                    '<i class="material-icons right">cloud_download</i>',
                    Url::to(['#', 'id' => $model->id]),
                    [
                        'id' => 'grid-custom-button',
                        'data-pjax' => true,
                        'action' => Url::to(['#', 'id' => $model->id]),
                        'class' => 'btn-floating disabled',
                        'title' => "Télécharger le document"
                    ]
                );
            }
        }
    ];
}

function getPdfButtonArray()
{
    return [
        'format' => 'raw',
        'label' => 'PDF',
        'value' => function ($model, $key, $index, $column) {
            return Html::a(
                '<i class="material-icons right">picture_as_pdf</i>',
                Url::to(['devis/pdf', 'id' => $model->id,]),
                [
                    'id' => 'grid-custom-button',
                    'target' => '_blank',
                    'data-pjax' => true,
                    'action' => Url::to(['devis/pdf', 'id' => $model->id]),
                    'class' => 'btn-floating waves-effect waves-light btn-purple',
                    'title' => "Générer le devis sous forme pdf"
                ]
            );
        }
    ];
}

function getExcelButtonArray()
{
    return [
        'format' => 'raw',
        'label' => 'XLS',
        'value' => function ($model, $key, $index, $column) {
            return Html::a(
                '<i class="material-icons right">grid_on</i>',
                Url::to(['devis/download-excel', 'id' => $model->id]),
                [
                    'id' => 'grid-custom-button',
                    'data-pjax' => true,
                    'action' => Url::to(['devis/update', 'id' => $model->id]),
                    'class' => 'btn-floating waves-effect waves-light btn-green-darker',
                    'title' => "Générer le devis sous forme excel"
                ]
            );
        }
    ];
}
