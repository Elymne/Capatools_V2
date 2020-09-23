<?php

use app\assets\AppAsset;
use app\assets\projects\ProjectIndexMilestonesAsset;
use app\widgets\TopTitle;
use yii\grid\GridView;
use yii\widgets\Pjax;

$this->title = "Liste des jalons";
$this->params["breadcrumbs"][] = $this->title;

AppAsset::register($this);
ProjectIndexMilestonesAsset::register($this);
?>

<?= TopTitle::widget(["title" => $this->title]) ?>

<div class="container">
    <div class="project-index">
        <div class="row">

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
                                "id" => "devis_table",
                                "style" => "height: 10px",
                                "class" => ["highlight"]
                            ],
                            "columns" => getCollumnsArray()
                        ]); ?>
                        <?php Pjax::end(); ?>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<?php

/**
 * Fonction qui retourne la liste de tous les éléments à afficher sur le gridView.
 * Voir le paramètre "columns" du GridView au dessus.
 */
function getCollumnsArray()
{
    $result = [];

    array_push($result, getProjectInternalName());
    array_push($result, getNumber());
    array_push($result, getComment());
    array_push($result, getPercent());
    array_push($result, getStatus());
    array_push($result, getEstimateDate());

    return $result;
}

function getProjectInternalName()
{
    return [
        "attribute" => "project.internal_name",
        "format" => "raw",
        "label" => "Nom interne",
        "contentOptions" => ["class" => "project-internal_name-row"],
        "headerOptions" => ["class" => "project-internal_name-row"],
    ];
}

function getNumber()
{
    return [
        "attribute" => "number",
        "format" => "raw",
        "label" => "Numéro de jalon",
        "contentOptions" => ["class" => "project-internal_name-row"],
        "headerOptions" => ["class" => "project-internal_name-row"],
    ];
}

function getComment()
{
    return [
        "attribute" => "comment",
        "format" => "raw",
        "label" => "Description",
        "contentOptions" => ["class" => "project-internal_name-row"],
        "headerOptions" => ["class" => "project-internal_name-row"],
    ];
}

function getPercent()
{
    return [
        "attribute" => "pourcentage",
        "format" => "raw",
        "label" => "Pourcentage",
        "contentOptions" => ["class" => "project-internal_name-row"],
        "headerOptions" => ["class" => "project-internal_name-row"],
    ];
}

// TODO - Peut-être transformer ceci en bouton. Pour le prochain ticket.
function getStatus()
{
    return [
        "attribute" => "statut",
        "format" => "raw",
        "label" => "Status",
        "contentOptions" => ["class" => "project-internal_name-row"],
        "headerOptions" => ["class" => "project-internal_name-row"],
    ];
}


function getEstimateDate()
{
    return [
        "attribute" => "estimate_date",
        "format" => "raw",
        "label" => "Date d'estimation",
        "contentOptions" => ["class" => "project-internal_name-row"],
        "headerOptions" => ["class" => "project-internal_name-row"],
    ];
}
