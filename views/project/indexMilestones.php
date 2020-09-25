<?php

use app\models\projects\Millestone;
use app\assets\AppAsset;
use app\assets\projects\ProjectIndexMilestonesAsset;
use app\services\userRoleAccessServices\UserRoleEnum;
use app\services\userRoleAccessServices\UserRoleManager;
use app\widgets\TopTitle;
use kartik\select2\Select2;
use yii\bootstrap\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

AppAsset::register($this);
ProjectIndexMilestonesAsset::register($this);

$this->title = "Liste des jalons";
$this->params["breadcrumbs"][] = $this->title;

?>

<?= TopTitle::widget(["title" => $this->title]) ?>

<div class="container">
    <div class="project-index">

        <div class="row body-marger">

            <!-- GRIDVIEW - OPTIONS DE FILTRES ET DE RECHERCHES -->
            <div class="card">
                <div class="card-content">
                    <label>Filtres - Recherches</label>
                </div>

                <div class="card-action">
                    <div class="col s3">
                        <p>Filtre nom de projet :</p>
                        <?= getSearchNameFilter() ?>
                    </div>
                    <div class="col s8 offset-s1">
                        <p>Filtre numéro de lot :</p>
                        <?= getSearchNumberFilter() ?>
                    </div>
                </div>

                <div class="card-action">
                    <?php if (UserRoleManager::hasRoles([UserRoleEnum::ACCOUNTING_SUPPORT, UserRoleEnum::ADMIN, UserRoleEnum::SUPER_ADMIN])) : ?>
                        <div class="col s3">
                            <p>Filtre cellule :</p>
                            <?= getSelectListCelluleFilter($celluleNameList) ?>
                        </div>

                        <div class="col s8 offset-s1">
                            <p>Filtre statut :</p>
                            <?= getSelectListStatusFilter() ?>
                        </div>
                    <?php else : ?>
                        <div class="col s8">
                            <p>Filtre statut :</p>
                            <?= getSelectListStatusFilter() ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <!-- GRIDVIEW - OPTIONS DE FILTRES ET DE RECHERCHES -->

            <!-- GRIDVIEW - LISTE DES JALONS -->
            <div class="card">
                <div class="card-action">
                    <div class="scroll-box">
                        <?php Pjax::begin(["id" => "1"]); ?>
                        <?= GridView::widget([
                            "dataProvider" => $dataProvider,
                            "rowOptions" => [
                                "style" => "height:20px;",
                                "text-overflow:ellipsis;"
                            ],
                            "tableOptions" => [
                                "id" => "milestones_table",
                                "style" => "height: 10px",
                                "class" => ["highlight"]
                            ],
                            "columns" => getCollumnsArray()
                        ]); ?>
                        <?php Pjax::end(); ?>
                    </div>
                </div>
            </div>
            <!-- GRIDVIEW - LISTE DES JALONS -->

        </div>
    </div>

</div>


<?php

/**
 * Fonction qui retourne la liste de tous les éléments/paramètres du modèle à afficher sur le gridView.
 * Voir le paramètre "columns" du GridView au dessus.
 */
function getCollumnsArray()
{
    $result = [];

    array_push($result, [
        "attribute" => "project.internal_name",
        "format" => "raw",
        "label" => "Nom interne",
        "contentOptions" => ["class" => "project-internal_name-row"],
        "headerOptions" => ["class" => "project-internal_name-row"],
    ]);

    array_push($result, [
        "attribute" => "project.cellule.name",
        "format" => "raw",
        "label" => "Cellule",
        "contentOptions" => ["class" => "project-cellule-row"],
        "headerOptions" => ["class" => "project-cellule-row"],
    ]);

    array_push($result, [
        "attribute" => "number",
        "format" => "raw",
        "label" => "Numéro de jalon",
        "contentOptions" => ["class" => "project-number-row"],
        "headerOptions" => ["class" => "project-number-row"],
    ]);

    array_push($result, [
        "attribute" => "comment",
        "format" => "raw",
        "label" => "Description",
        "contentOptions" => ["class" => "project-commentary-row"],
        "headerOptions" => ["class" => "project-commentary-row"],
    ]);

    array_push($result, [
        "attribute" => "price",
        'value' => "priceeuros",
        "format" => "raw",
        "label" => "Prix",
        "contentOptions" => ["class" => "project-price-row"],
        "headerOptions" => ["class" => "project-price-row"],
    ]);

    array_push($result, [
        "attribute" => "statut",
        "format" => "raw",
        "label" => "Statut",
        "contentOptions" => ["class" => "project-status-row"],
        "headerOptions" => ["class" => "project-status-row"],
    ]);

    array_push($result, [
        "attribute" => "estimate_date",
        "format" => "raw",
        "label" => "Date d'estimation",
        "contentOptions" => ["class" => "project-date-row"],
        "headerOptions" => ["class" => "project-date-row"],
    ]);

    array_push($result, [
        "attribute" => "last_update_date",
        "format" => "raw",
        "label" => "Date de modification",
        "contentOptions" => ["class" => "project-last_update_date-row"],
        "headerOptions" => ["class" => "project-last_update_date-row"],
    ]);


    array_push($result, [
        'format' => 'raw',
        'label' => 'Action',
        'value' => function ($model, $key, $index, $column) {
            return   getUpdateStatusButton($model);
        }
    ]);


    return $result;
}

/**
 * Fonction qui retourne le composant HTML (champ de text ici) qui va nous servir à filtrer par nom de projet.
 */
function getSearchNameFilter()
{
    echo Html::input('text', 'textinput_name_search', "", [
        'id' => 'project-name-search',
        'maxlength' => 100,
        'style' => 'width:350px',
        'placeholder' => 'Recherche par nom de projet',
        'onkeyup' => 'onInputNameChange()',
        'title' => 'Recherche par nom de projet'
    ]);
}

function getSearchNumberFilter()
{
    echo Html::input('number', 'textinput_number_search', "", [
        'id' => 'project-number-search',
        'maxlength' => 10,
        'style' => 'width:350px',
        'placeholder' => 'Recherche par numéro de projet',
        'onkeyup' => 'onInputNumberChange()',
        'title' => 'Recherche par numéro de projet',
        'min' => 0,
        'max' => 100
    ]);
}

function getSelectListCelluleFilter(array $celluleNameList)
{
    echo Select2::widget([
        'id' => 'selectlist-cellule-search',
        'name' => 'droplist_cellule',
        'data' => $celluleNameList,
        'pluginLoading' => false,
        'hideSearch' => true,
        'options' => ['style' => 'width:350px', 'placeholder' => 'Selectionner une cellule ...'],
        'pluginOptions' => [
            'allowClear' => true
        ],
        'pluginEvents' => [
            "select2:select" => "() => { onSelectCelluleChange() }",
        ]
    ]);
}

function getSelectListStatusFilter()
{
    echo <<<HTML
        <label class="rigthspace-20px">
            <input type="checkbox" class="filled-in" id="inprog-checkbox" onclick="onCheckboxStatusChange()" checked/>
            <span class="span-combobox">En cours</span>
        </label>
        <label class="rigthspace-20px">
            <input type="checkbox" class="filled-in" id="facturing-checkbox" onclick="onCheckboxStatusChange()" checked/>
            <span class="span-combobox">Facturation en cours</span>
        </label>
        <label class="rigthspace-20px">
            <input type="checkbox" class="filled-in" id="factured-checkbox" onclick="onCheckboxStatusChange()" checked/>
            <span class="span-combobox">Facturé</span>
        </label>
        <label class="rigthspace-20px">
            <input type="checkbox" class="filled-in" id="payed-checkbox" onclick="onCheckboxStatusChange()"/>
            <span class="span-combobox">Payé</span>
        </label>
    HTML;
}


function getUpdateStatusButton($milestone)
{
    if ($milestone->statut == Millestone::STATUT_ENCOURS && (UserRoleManager::hasRole(UserRoleEnum::PROJECT_MANAGER || UserRoleManager::hasRole(UserRoleEnum::SUPER_ADMIN) || UserRoleManager::hasRole(UserRoleEnum::ADMIN)))) {
        return  Html::a('A facturer', ['update-millestone-status', 'id' => $milestone->id, 'status' => Millestone::STATUT_FACTURATIONENCOURS, 'direct' => 'index-milestones'], ['class' => 'waves-effect waves-light btn btn-grey']);
    }
    if ($milestone->statut == Millestone::STATUT_FACTURATIONENCOURS && (UserRoleManager::hasRole(UserRoleEnum::ACCOUNTING_SUPPORT)  || UserRoleManager::hasRole(UserRoleEnum::SUPER_ADMIN) || UserRoleManager::hasRole(UserRoleEnum::ADMIN))) {
        return Html::a('Valider la facturation', ['update-millestone-status', 'id' => $milestone->id, 'status' => Millestone::STATUT_FACTURER, 'direct' => 'index-milestones'], ['class' => 'waves-effect waves-light btn btn-grey']);
    }
    if ($milestone->statut == Millestone::STATUT_FACTURER && (UserRoleManager::hasRole(UserRoleEnum::ACCOUNTING_SUPPORT)  || UserRoleManager::hasRole(UserRoleEnum::SUPER_ADMIN) || UserRoleManager::hasRole(UserRoleEnum::ADMIN))) {
        return Html::a('Valider le paiement', ['update-millestone-status', 'id' => $milestone->id, 'status' => Millestone::STATUT_PAYED, 'direct' => 'index-milestones'], ['class' => 'waves-effect waves-light btn btn-grey']);
    }
    return "";
}
