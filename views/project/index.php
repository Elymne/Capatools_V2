<?php

use app\assets\projects\ProjectIndexAsset;
use app\assets\AppAsset;
use app\models\projects\Project;
use app\services\userRoleAccessServices\UserRoleEnum;
use app\services\userRoleAccessServices\UserRoleManager;
use app\widgets\TopTitle;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

AppAsset::register($this);
ProjectIndexAsset::register($this);
$this->title = 'Liste des projets';
$this->params['breadcrumbs'][] = $this->title;
?>

<!-- HTML : start -->
<?= TopTitle::widget(['title' => $this->title]) ?>
<div class="container">
    <div class="project-index">
        <div class="row">
            <!-- CardView : FILTER-CARD -->
            <div class="card">
                <div class="card-content">
                    <label>Filtres</label>
                </div>
                <div class="card-action">
                    <div class="col s12 l6">
                        <?= Select2::widget([
                            'id' => 'company-name-search',
                            'name' => 'droplist_company',
                            'data' => $companiesName,
                            'pluginLoading' => false,
                            "theme" => Select2::THEME_MATERIAL,
                            'options' => ['placeholder' => 'Selectionner un client ...'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ]
                        ]) ?>
                    </div>
                    <div class="col s12 l6">
                        <?= Html::input('text', 'textinput_capaid', "", [
                            'id' => 'capa-id-search',
                            'maxlength' => 10,
                            'placeholder' => 'Rechercher un capa id',
                            'onkeyup' => 'capaidFilterSearch()'
                        ]) ?>
                    </div>
                    <br /><br /><br /><br />
                    <div class="col s12">
                        <label class="rigthspace-20px">
                            <input type="checkbox" class="filled-in" checked="checked" id="bc-checkbox" />
                            <span class="span-combobox">Devis envoyé</span>
                        </label>
                        <label class="rigthspace-20px">
                            <input type="checkbox" class="filled-in" checked="checked" id="pc-checkbox" />
                            <span class="span-combobox">Projets en cours</span>
                        </label>
                        <label class="rigthspace-20px">
                            <input type="checkbox" class="filled-in" id="pt-checkbox" />
                            <span class="span-combobox">Projets terminés</span>
                        </label>
                        <label class="rigthspace-20px">
                            <input type="checkbox" class="filled-in" id="pa-checkbox" />
                            <span class="span-combobox">Projets annulés</span>
                        </label>
                    </div>
                </div>
            </div>
            <!-- CardView : GRIDVIEW-MANAGEMENT -->
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
                    <label class="rigthspace-20px">
                        <input type="checkbox" class="filled-in" id="projectmanager-checkbox" />
                        <span class="span-combobox">Resp projet</span>
                    </label>
                    <label class="rigthspace-20px">
                        <input type="checkbox" class="filled-in" id="cellule-checkbox" />
                        <span class="span-combobox">Cellule</span>
                    </label>
                    <label class="rigthspace-20px">
                        <input type="checkbox" class="filled-in" checked="checked" id="company-checkbox" />
                        <span class="span-combobox">Client</span>
                    </label>
                    <label class="rigthspace-20px">
                        <input type="checkbox" class="filled-in" checked="checked" id="status-checkbox" />
                        <span class="span-combobox">Status</span>
                    </label>
                </div>
            </div>
            <!-- CardView : DATA GRIDVIEW -->
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
<!-- HTML : end -->

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
    array_push($result, getProbabilityArray());

    // Buttons displaying.
    array_push($result, getViewButtonArray());
    array_push($result, getPdfButtonArray());
    array_push($result, getExcelButtonArray());

    //todo Pour l'instant, pas d'utilité sur ce bouton.
    //array_push($result, getPieceButtonArray());

    return $result;
}

function getIdArray()
{
    return [
        'attribute' => 'capaidreduc',
        'format' => 'raw',
        'label' => 'CapaID',
        'contentOptions' => ['class' => 'capaid-row'],
        'headerOptions' => ['class' => 'capaid-row'],
        'value' => function ($data) {
            return Html::a($data['capaidreduc'], ['project/view', 'id' => $data['id']], ['target' => '_blank',]);
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
        'attribute' => 'project_manager.fullname',
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

function getViewButtonArray()
{
    return [
        'format' => 'raw',
        'label' => 'Voir',
        'headerOptions' => ['style' => 'width:5%'],
        'contentOptions' => ['style' => 'width:5%'],
        'value' => function ($model, $key, $index, $column) {
            return Html::a(
                '<i class="material-icons center">visibility</i>',
                Url::to(['project/view', 'id' => $model->id]),
                [
                    'id' => 'grid-custom-button',
                    'data-pjax' => true,
                    'target' => '_blank',
                    'action' => Url::to(['project/view', 'id' => $model->id]),
                    'class' => 'btn-floating-minus waves-effect waves-light btn-green',
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
        'headerOptions' => ['style' => 'width:5%'],
        'contentOptions' => ['style' => 'width:5%'],
        'value' => function ($model, $key, $index, $column) {
            // Si le projet est déjà signé ou terminé, on affiche le bouton d'accès au pdf.
            if ($model->state == Project::STATE_DEVIS_SIGNED || $model->state == Project::STATE_DEVIS_FINISHED) {
                return Html::a(
                    '<i class="material-icons center">picture_as_pdf</i>',
                    Url::to(['project/pdf', 'id' => $model->id,]),
                    [
                        'id' => 'grid-custom-button',
                        'target' => '_blank',
                        'data-pjax' => true,
                        'class' => 'btn-floating-minus waves-effect waves-light btn-purple',
                        'title' => "Générer le devis sous forme pdf"
                    ]
                );
            } else {
                // On retourne un tag vide.
                return Html::tag(null);
            }
        }
    ];
}

function getExcelButtonArray()
{
    return [
        'format' => 'raw',
        'label' => 'XLS',
        'headerOptions' => ['style' => 'width:5%'],
        'contentOptions' => ['style' => 'width:5%'],
        'value' => function ($model, $key, $index, $column) {
            return Html::a(
                '<i class="material-icons center">grid_on</i>',
                Url::to(['project/download-excel', 'id' => $model->id]),
                [
                    'id' => 'grid-custom-button',
                    'data-pjax' => true,
                    'action' => Url::to(['devis/update', 'id' => $model->id]),
                    'class' => 'btn-floating-minus waves-effect waves-light btn-green-darker',
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
        'headerOptions' => ['style' => 'width:5%'],
        'contentOptions' => ['style' => 'width:5%'],
        'value' => function ($model, $key, $index, $column) {
            return Html::a(
                '<i class="material-icons center">file_download</i>',
                Url::to(['project/download-piece', 'id' => $model->id]),
                [
                    'id' => 'grid-custom-button',
                    'data-pjax' => true,
                    'action' => Url::to(['project/download-piece', 'id' => $model->id]),
                    'class' => 'btn-floating-minus waves-effect waves-light btn-green-darker',
                    'title' => "Récupérer la proposition technique"
                ]
            );
        }
    ];
}
