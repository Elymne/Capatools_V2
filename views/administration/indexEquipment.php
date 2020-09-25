<?php

use app\assets\administration\EquipmentIndexAsset;
use app\widgets\TopTitle;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

$this->title = 'Liste des matériels';
$this->params['breadcrumbs'][] = $this->title;

EquipmentIndexAsset::register($this);

?>

<?= TopTitle::widget(['title' => $this->title]) ?>

<div class="container">
    <div class="capa_user-index">
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
                    <div class="scroll-box">
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
            <a href="/administration/create-equipment" class="btn-floating btn-large gradient-45deg-light-blue-cyan gradient-shadow">
                <i class="material-icons">add</i>
            </a>
        </div>

    </div>
</div>

<?php

function getSearchFilter()
{
    echo Html::input('text', 'textinput_user', '', [
        'id' => 'equipment-name-search',
        'class' => 'form-control',
        'maxlength' => 10,
        'style' => 'width:350px',
        'placeholder' => 'Rechercher un nom de matériel',
        'onkeyup' => 'equipmentNameFilterSearch()'
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
    array_push($result, getPriceDayArray());
    array_push($result, getPriceHourArray());
    array_push($result, getTypeArray());
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

function getPriceDayArray(): array
{
    return [
        'label' => 'Prix journalier',
        'encodeLabel' => false,
        'format' => 'ntext',
        'attribute' => 'price_day',
        'contentOptions' => ['class' => 'price_day-row'],
    ];
}

function getPriceHourArray(): array
{
    return [
        'label' => 'Prix horaire',
        'encodeLabel' => false,
        'format' => 'ntext',
        'attribute' => 'price_hour',
        'contentOptions' => ['class' => 'price_hour-row'],
    ];
}

function getTypeArray(): array
{
    return [
        'label' => 'Type',
        'encodeLabel' => false,
        'format' => 'ntext',
        'attribute' => 'type',
        'contentOptions' => ['class' => 'type-row'],
    ];
}

function getLaboratoryNameArray(): array
{
    return [
        'label' => 'Propriété',
        'encodeLabel' => false,
        'format' => 'ntext',
        'attribute' => 'laboratory.name',
        'contentOptions' => ['class' => 'type-row'],
    ];
}

?>