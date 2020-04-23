<?php

use app\helper\_clazz\UserRoleManager;
use app\helper\_enum\UserRoleEnum;
use app\models\devis\UploadFile;
use app\widgets\TopTitle;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;

$this->title = 'Liste des devis';
$this->params['breadcrumbs'][] = $this->title;
?>

<?= TopTitle::widget(['title' => $this->title]) ?>

<div class="container">
    <div class="devis-index">

        <!-- New -->

        <div class="row">

            <div class="card">
                <div class="card-content">
                    <span>Filtres</span>
                </div>
                <div class="card-content">
                    <?php echo getFilterCardContent() ?>
                </div>
            </div>

            <div class="card">
                <div class="card-content">
                    <?php echo getHelperCardContent() ?>
                </div>
            </div>

            <div class="card">
                <div class="card-content">

                    <br />
                    <?php Pjax::begin(['id' => '1']); ?>

                    <?= GridView::widget([
                        'id' => 'AvantContrat_id',
                        'dataProvider' => $dataProvider,
                        'rowOptions' => [
                            'style' => 'height:20px;',
                            //                'width:20px;',
                            'text-overflow:ellipsis;'
                        ],
                        'tableOptions' => [
                            'style' => 'height: 20px',
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
 * Used to display combobox.
 * 
 * @return string HTML content.
 */
function getFilterCardContent(): string
{
    return <<<HTML
        <label class="rigthspace-20px">
            <input type="checkbox" class="filled-in" checked="checked" id="capaid-checkbox" />
            <span>CapaID</span>
        </label>
        <label class="rigthspace-20px">
            <input type="checkbox" class="filled-in" checked="checked" id="projectname-checkbox"/>
            <span>Nom du projet</span>
        </label>
        <label class="rigthspace-20px">
            <input type="checkbox" class="filled-in" checked="checked" id="projectmanager-checkbox"/>
            <span>Resp projet</span>
        </label>
        <label class="rigthspace-20px">
            <input type="checkbox" class="filled-in" checked="checked" id="cellule-checkbox"/>
            <span>Cellule</span>
        </label>
        <label class="rigthspace-20px">
            <input type="checkbox" class="filled-in" checked="checked" id="company-checkbox"/>
            <span>Client</span>
        </label>
        <label class="rigthspace-20px">
            <input type="checkbox" class="filled-in" checked="checked" id="status-checkbox"/>
            <span>Status</span>
        </label>
    HTML;
}

/**
 * Used to display combobox.
 * 
 * @return string HTML content.
 */
function getHelperCardContent(): string
{
    return <<<HTML
        <div>
            <a class="btn-floating waves-effect waves-light btn-green rightspace-10px no-click"><i class="material-icons right">cloud_download</i></a>
            <p style="display: inline-block">Modifier le devis</p>

            <a class="btn-floating waves-effect waves-light btn-blue rightspace-10px leftspace-20px no-click"><i class="material-icons right">cloud_download</i></a>
            <p style="display: inline-block">Upload du fichier</p>

            <a class="btn-floating waves-effect waves-light btn-purple rightspace-10px leftspace-20px no-click"><i class="material-icons right">picture_as_pdf</i></a>
            <p style="display: inline-block">Générer le pdf</p>

            <a class="btn-floating waves-effect waves-light btn-green-darker rightspace-10px leftspace-20px no-click"><i class="material-icons right">grid_on</i></a>
            <p style="display: inline-block">Générer le fichier excel</p>
        </div>
    HTML;
}

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
    if (UserRoleManager::hasRoles([UserRoleEnum::ADMINISTRATOR, UserRoleEnum::SUPER_ADMINISTRATOR])) {
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
        'contentOptions' => ['class' => 'capaid-row table-reduced', 'style' => 'width:75'],
        'headerOptions' => ['class' => 'capaid-row'],
        'value' => function ($data) {
            return Html::a($data['id_capa'], ['devis/view', 'id' => $data['id']], ['target' => '_blank']);
        }
    ];
}

function getInternalNameArray()
{
    return [
        'attribute' => 'internal_name',
        'format' => 'text',
        'label' => 'Nom du projet',
        'contentOptions' => ['class' => 'projectname-row'],
        'headerOptions' => ['class' => 'projectname-row'],
    ];
}

function getUsernameArray()
{
    return [
        'attribute' => 'capa_user.username',
        'format' => 'text',
        'label' => 'Resp projet',
        'contentOptions' => ['class' => 'projectmanager-row'],
        'headerOptions' => ['class' => 'projectmanager-row'],
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
        'attribute' => 'devis_status.label',
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
        'value' => function ($model, $key, $index, $column) {
            return Html::a(
                '<i class="material-icons right">build</i>',
                Url::to(['devis/update', 'id' => $model->id]),
                [
                    'id' => 'grid-custom-button',
                    'data-pjax' => true,
                    'action' => Url::to(['devis/update', 'id' => $model->id]),
                    'class' => 'btn-floating waves-effect waves-light btn-green',
                ]
            );
        }
    ];
}

function getDocumentButtonArray()
{
    return [
        'format' => 'raw',
        'value' => function ($model, $key, $index, $column) {

            if (UploadFile::getByDevis($model->id) != null) {
                return Html::a(
                    '<i class="material-icons right">cloud_download</i>',
                    Url::to(['devis/download-file', 'id' => $model->id]),
                    [
                        'id' => 'grid-custom-button',
                        'data-pjax' => true,
                        'action' => Url::to(['devis/update', 'id' => $model->id]),
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
        'value' => function ($model, $key, $index, $column) {
            return Html::a(
                '<i class="material-icons right">picture_as_pdf</i>',
                Url::to(['devis/pdf', 'id' => $model->id]),
                [
                    'id' => 'grid-custom-button',
                    'data-pjax' => true,
                    'action' => Url::to(['devis/pdf', 'id' => $model->id]),
                    'class' => 'btn-floating waves-effect waves-light btn-purple',
                ]
            );
        }
    ];
}

function getExcelButtonArray()
{
    return [
        'format' => 'raw',
        'value' => function ($model, $key, $index, $column) {
            return Html::a(
                '<i class="material-icons right">grid_on</i>',
                Url::to(['devis/download-excel', 'id' => $model->id]),
                [
                    'id' => 'grid-custom-button',
                    'data-pjax' => true,
                    'action' => Url::to(['devis/update', 'id' => $model->id]),
                    'class' => 'btn-floating waves-effect waves-light btn-green-darker',
                ]
            );
        }
    ];
}
