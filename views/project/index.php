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

ProjectIndexAsset::register($this);

?>

<?= TopTitle::widget(['title' => $this->title]) ?>

<div class="container">
    <div class="project-index">

        <!-- New -->
        <div class="row body-marger">

            <div class="card">
                <div class="card-content">
                    <label>Filtres</label>
                </div>
                <div class="card-action">
                    <?php getSearchFilter($companiesName) ?>
                </div>
            </div>

            <div class="card">
                <div class="card-content bottomspace-15px-invert">
                    <label>Réglage du tableau</label>
                </div>
                <div class="card-action topspace-15px-invert">
                    <?php echo getFilterCardContent() ?>
                </div>
            </div>

            <div class="card">
                <div class="card-action">
                    <div class="scroll-box">
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
</div>



<?php


function getSearchFilter($companiesName)
{

    echo Select2::widget([
        'id' => 'company-name-search',
        'name' => 'droplist_company',
        'data' => $companiesName,
        'pluginLoading' => false,
        'options' => ['style' => 'width:350px', 'placeholder' => 'Selectionner un client ...'],
        'pluginOptions' => [
            'allowClear' => true
        ]
    ]);

    echo '<br />';

    echo Html::input('text', 'textinput_capaid', "", [
        'id' => 'capa-id-search',
        'maxlength' => 10,
        'style' => 'width:350px',
        'placeholder' => 'Rechercher un capa id',
        'onkeyup' => 'capaidFilterSearch()'
    ]);

    echo '<br />';
    echo '<br />';

    echo <<<HTML
        <label class="rigthspace-20px">
            <input type="checkbox" class="filled-in" checked="checked" id="bc-checkbox" />
            <span class="span-combobox">Avant-contrats</span>
        </label>
        <label class="rigthspace-20px">
            <input type="checkbox" class="filled-in" checked="checked" id="pc-checkbox"/>
            <span class="span-combobox">Projets en cours</span>
        </label>
        <label class="rigthspace-20px">
            <input type="checkbox" class="filled-in" id="pt-checkbox"/>
            <span class="span-combobox">Projets terminés</span>
        </label>
        <label class="rigthspace-20px">
            <input type="checkbox" class="filled-in" id="pa-checkbox"/>
            <span class="span-combobox">Projets annulés</span>
        </label>
    HTML;
}

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
            <span class="span-combobox">CapaID</span>
        </label>
        <label class="rigthspace-20px">
            <input type="checkbox" class="filled-in" checked="checked" id="projectname-checkbox"/>
            <span class="span-combobox">Nom interne</span>
        </label>
        <label class="rigthspace-20px">
            <input type="checkbox" class="filled-in" id="projectmanager-checkbox"/>
            <span class="span-combobox">Resp projet</span>
        </label>
        <label class="rigthspace-20px">
            <input type="checkbox" class="filled-in" id="cellule-checkbox"/>
            <span class="span-combobox">Cellule</span>
        </label>
        <label class="rigthspace-20px">
            <input type="checkbox" class="filled-in" checked="checked" id="company-checkbox"/>
            <span class="span-combobox">Client</span>
        </label>
        <label class="rigthspace-20px">
            <input type="checkbox" class="filled-in" checked="checked" id="status-checkbox"/>
            <span class="span-combobox">Status</span>
        </label>
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
    if (UserRoleManager::hasRoles([UserRoleEnum::ADMIN, UserRoleEnum::SUPER_ADMIN])) {
        array_push($result, getCelluleArray());
    }
    array_push($result, getCompanyArray());
    array_push($result, getStatusArray());
    array_push($result, getProbabilityArray());

    // Buttons displaying.
    array_push($result, getUpdateButtonArray());
    array_push($result, getPdfButtonArray());
    array_push($result, getExcelButtonArray());
    array_push($result, getPieceButtonArray());

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
        'contentOptions' => ['class' => 'cellule-row', 'style' => 'display: none'],
        'headerOptions' => ['class' => 'cellule-row', 'style' => 'display: none'],
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

function getProbabilityArray()
{
    return [
        'attribute' => 'signing_probability',
        'format' => 'text',
        'label' => 'Proba. signature',
        'contentOptions' => ['class' => 'signing_probability-row'],
        'headerOptions' => ['class' => 'signing_probability-row'],
        'value' => function ($model) {
            return $model->signing_probability . ' %';
        }
    ];
}

function getUpdateButtonArray()
{
    return [
        'format' => 'raw',
        'label' => 'visualiser',
        'value' => function ($model, $key, $index, $column) {
            return Html::a(
                '<i class="material-icons center">visibility</i>',
                Url::to(['project/view', 'id' => $model->id]),
                [
                    'id' => 'grid-custom-button',
                    'data-pjax' => true,
                    'target' => '_blank',
                    'action' => Url::to(['project/view', 'id' => $model->id]),
                    'class' => 'btn-floating waves-effect waves-light btn-green',
                    'title' => "visualiser le devis"
                ]
            );
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
                Url::to(['project/pdf', 'id' => $model->id,]),
                [
                    'id' => 'grid-custom-button',
                    'target' => '_blank',
                    'data-pjax' => true,
                    'action' => Url::to(['project/pdf', 'id' => $model->id]),
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
                Url::to(['project/download-excel', 'id' => $model->id]),
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

function getPieceButtonArray()
{
    return [
        'format' => 'raw',
        'label' => 'Propositon',
        'value' => function ($model, $key, $index, $column) {
            return Html::a(
                '<i class="material-icons right">file_download</i>',
                Url::to(['project/download-piece', 'id' => $model->id]),
                [
                    'id' => 'grid-custom-button',
                    'data-pjax' => true,
                    'action' => Url::to(['project/download-piece', 'id' => $model->id]),
                    'class' => 'btn-floating waves-effect waves-light btn-green-darker',
                    'title' => "Récupérer la proposition technique"
                ]
            );
        }
    ];
}
