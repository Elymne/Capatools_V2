<?php

use app\widgets\TopTitle;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\user\CapaUserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Liste des salariés';
$this->params['breadcrumbs'][] = $this->title;
?>

<?= TopTitle::widget(['title' => $this->title]) ?>

<div class="container">
    <div class="capa_user-index">
        <div class="row">

            <div class="card">
                <div class="card-content">
                    <label>
                        Filtres
                    </label>
                </div>
                <div class="card-action">
                    <?php getSearchFilter($cellulesNames, $savedDroplistCellule, $savedTextinputUser) ?>
                </div>
            </div>

            <div class="card">
                <div class="card-action">

                    <?php Pjax::begin(); ?>

                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'tableOptions' => [
                            'class' => ['highlight']
                        ],
                        'columns' => getCollumnArray(),
                    ]); ?>

                    <?php Pjax::end(); ?>

                </div>
            </div>

        </div>

        <div style="bottom: 50px; right: 25px;" class="fixed-action-btn direction-top">
            <a href="/administration/create" class="btn-floating btn-large gradient-45deg-light-blue-cyan gradient-shadow">
                <i class="material-icons">add</i>
            </a>
        </div>

    </div>
</div>

<?php


function getSearchFilter(array $cellules, $savedDroplistCellule, $savedTextinputUser)
{

    echo Html::beginForm(['administration/index'], 'post', ['enctype' => 'multipart/form-data']);

    if ($savedDroplistCellule == null) $savedDroplistCellule = -1;
    if ($savedTextinputUser == null) $savedTextinputUser = "";

    echo Select2::widget([
        'name' => 'droplist_cellule',
        'data' => $cellules,
        'pluginLoading' => false,
        'value' => $savedDroplistCellule,
        'options' => ['style' => 'width:350px', 'placeholder' => 'Selectionner une cellule ...'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);

    echo Html::input('text', 'textinput_user', $savedTextinputUser, ['class' => 'form-control', 'maxlength' => 10, 'style' => 'width:350px', 'placeholder' => 'Rechercher un nom d\'utilisateur']);

    echo '<br />';

    //echo Html::a('Filtrer', ['administration/index-filtered'], ['class' => 'btn waves-effect waves-light update-button btn-blue']);
    echo Html::submitButton('Rechercher', ['class' => 'btn waves-effect waves-light update-button btn-blue']);
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
    array_push($result, getUsernameArray());
    array_push($result, getEmailArray());
    array_push($result, getCelluleArray());

    // Button input.
    array_push($result, getUpdateButtonArray());

    return $result;
}

function getUsernameArray(): array
{
    return [
        'attribute' => 'username',
        'format' => 'raw',
        'label' => '<span class="material-icons">arrow_drop_down</span> Salarié',
        'encodeLabel' => false,
        'value' => function ($data) {
            return Html::a($data['username'], ['administration/view', 'id' => $data['id']]);
        }
    ];
}

function getEmailArray(): array
{
    return [
        'label' => '<span class="material-icons">arrow_drop_down</span> Email',
        'encodeLabel' => false,
        'format' => 'ntext',
        'attribute' => 'email',
    ];
}

function getCelluleArray(): array
{
    return [
        'label' => '<span class="material-icons">arrow_drop_down</span> Cellule',
        'encodeLabel' => false,
        'format' => 'ntext',
        'attribute' => 'cellule.name',
    ];
}

function getUpdateButtonArray()
{
    return [
        'format' => 'raw',
        'label' => 'Modification',
        'value' => function ($model, $key, $index, $column) {
            return Html::a(
                '<i class="material-icons right">edit</i> Modifier',
                Url::to(['administration/update', 'id' => $model->id]),
                [
                    'id' => 'grid-custom-button',
                    'data-pjax' => true,
                    'action' => Url::to(['administration/update', 'id' => $model->id]),
                    'class' => 'btn waves-effect waves-light update-button btn-green',
                ]
            );
        }
    ];
}
