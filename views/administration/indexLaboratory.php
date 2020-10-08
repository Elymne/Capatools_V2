<?php

use app\assets\administration\LaboratoryIndexAsset;
use app\assets\AppAsset;
use app\widgets\TopTitle;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;


$this->title = 'Liste des laboratoires';
$this->params['breadcrumbs'][] = $this->title;

AppAsset::register($this);
LaboratoryIndexAsset::register($this);
?>

<?= TopTitle::widget(['title' => $this->title]) ?>

<div class="container">
    <div class="laboratory-index">
        <div class="row body-marger">
            <div class="card">
                <div class="card-content">
                    <label>
                        Filtres
                    </label>
                </div>
                <div class="card-action">
                    <?php getSearchFilter() ?>
                </div>
            </div>
            <div class="card">
                <div class="card-action">
                    <div>
                        <?php Pjax::begin(); ?>
                        <?= GridView::widget([
                            'dataProvider' => $dataProvider,
                            'tableOptions' => [
                                'id' => 'admin_table',
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

        <div style="bottom: 50px; right: 25px;" class="fixed-action-btn direction-top">
            <a href="/administration/create-laboratory" class="btn-floating btn-large gradient-45deg-light-blue-cyan gradient-shadow">
                <i class="material-icons">add</i>
            </a>
        </div>

    </div>
</div>

<?php

function getSearchFilter()
{
    echo Html::input('text', 'textinput_user', '', [
        'id' => 'laboratory-name-search',
        'class' => 'form-control',
        'maxlength' => 50,
        'style' => 'width:350px',
        'placeholder' => 'Rechercher un nom de laboratoire',
        'onkeyup' => 'laboratoryNameFilterSearch()'
    ]);

    echo '<br />';
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
    array_push($result, getPriceContributorDayArray());
    array_push($result, getPriceContributorHourArray());

    array_push($result, getPriceECDayArray());
    array_push($result, getPriceECHourArray());

    array_push($result, getLaboratoryNameArray());

    return $result;
}

function getNameArray(): array
{
    return [
        'attribute' => 'name',
        'format' => 'raw',
        'label' => 'Nom',
        'contentOptions' => ['class' => 'name-row'],
        'encodeLabel' => false
    ];
}

function getPriceContributorDayArray(): array
{
    return [
        'label' => 'Prix journalier (contribuable)',
        'encodeLabel' => false,
        'format' => 'ntext',
        'attribute' => 'price_contributor_day',
        'contentOptions' => ['class' => 'price_day-row'],
    ];
}

function getPriceContributorHourArray(): array
{
    return [
        'label' => 'Prix horaire (contribuable)',
        'encodeLabel' => false,
        'format' => 'ntext',
        'attribute' => 'price_contributor_hour',
        'contentOptions' => ['class' => 'price_hour-row'],
    ];
}

function getPriceECDayArray(): array
{
    return [
        'label' => 'Prix journalier (contribuable)',
        'encodeLabel' => false,
        'format' => 'ntext',
        'attribute' => 'price_ec_day',
        'contentOptions' => ['class' => 'price_day-row'],
    ];
}

function getPriceECHourArray(): array
{
    return [
        'label' => 'Prix horaire (contribuable)',
        'encodeLabel' => false,
        'format' => 'ntext',
        'attribute' => 'price_ec_hour',
        'contentOptions' => ['class' => 'price_hour-row'],
    ];
}

function getLaboratoryNameArray(): array
{
    return [
        'label' => 'Propriété',
        'encodeLabel' => false,
        'format' => 'ntext',
        'attribute' => 'cellule.name',
        'contentOptions' => ['class' => 'type-row'],
    ];
}

?>