<?php

use app\assets\administration\LaboratoryIndexAsset;
use app\widgets\TopTitle;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;


$this->title = 'Liste des laboratoires';
$this->params['breadcrumbs'][] = $this->title;

LaboratoryIndexAsset::register($this);
?>

<?= TopTitle::widget(['title' => $this->title]) ?>

<div class="container">
    <div class="laboratory-index">
        <div class="row">
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
            <a href="/administration/create-docuement" class="btn-floating btn-large gradient-45deg-light-blue-cyan gradient-shadow">
                <i class="material-icons">add</i>
            </a>
        </div>

    </div>
</div>

<?php

function getSearchFilter()
{
    echo Html::input('text', 'textinput_user', '', [
        'id' => 'indexdocument-name-search',
        'class' => 'form-control',
        'maxlength' => 50,
        'style' => 'width:350px',
        'placeholder' => 'Rechercher un nom de document',
        'onkeyup' => 'docuementNameFilterSearch()'
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
    array_push($result, getTypeArray());
    array_push($result, getLastUpdateArray());

    array_push($result, getLaboratoryNameArray());

    return $result;
}

function getNameArray(): array
{
    return [
        'label' => 'Titre du document',
        'encodeLabel' => false,
        'format' => 'ntext',
        'attribute' => 'title',
        'contentOptions' => ['class' => 'title-row'],
    ];
}

function getTypeArray(): array
{
    return [
        'label' => 'Type du document',
        'encodeLabel' => false,
        'format' => 'ntext',
        'attribute' => 'price_contributor_day',
        'contentOptions' => ['class' => 'price_day-row'],
    ];
}


?>