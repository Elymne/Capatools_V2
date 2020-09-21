<?php

use app\assets\companies\CompanyIndexAsset;
use app\widgets\TopTitle;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

$this->title = 'Liste des sociétés';
$this->params['breadcrumbs'][] = $this->title;

CompanyIndexAsset::register($this);

?>

<?= TopTitle::widget(['title' => $this->title]) ?>

<div class="container">
    <div class="company-index">
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
                                'id' => 'company_table',
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
            <a href="/company/create" class="btn-floating btn-large gradient-45deg-light-blue-cyan gradient-shadow">
                <i class="material-icons">add</i>
            </a>
        </div>

    </div>
</div>

<?php


function getSearchFilter()
{
    echo Html::input('text', 'textinput_user', '', [
        'id' => 'companyname-search',
        'class' => 'form-control',
        'maxlength' => 30,
        'style' => 'width:350px',
        'placeholder' => 'Rechercher un nom d\'utilisateur',
        'onkeyup' => 'usernameFilterSearch()'
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
    array_push($result, getEmailArray());
    array_push($result, getPostalCode());
    array_push($result, getCountry());
    array_push($result, getCity());
    array_push($result, getTva());
    array_push($result, getCompanyType());

    return $result;
}

function getNameArray(): array
{
    return [
        'attribute' => 'name',
        'label' => 'Nom du client',
        'format' => 'raw',
        'contentOptions' => ['class' => 'company-row'],
        'encodeLabel' => false,
        'value' => function ($data) {
            return Html::a($data['name'], ['company/view', 'id' => $data['id']]);
        }
    ];
}

function getEmailArray(): array
{
    return [
        'attribute' => 'email',
        'label' => 'Adresse email',
        'encodeLabel' => false,
        'format' => 'ntext',
        'contentOptions' => ['class' => ''],
    ];
}

function getPostalCode(): array
{
    return [
        'attribute' => 'postal_code',
        'label' => 'Code postal',
        'encodeLabel' => false,
        'format' => 'ntext',
        'contentOptions' => ['class' => ''],
    ];
}

function getCountry(): array
{
    return [
        'attribute' => 'country',
        'label' => 'Pays',
        'encodeLabel' => false,
        'format' => 'ntext',
        'contentOptions' => ['class' => ''],
    ];
}

function getCity(): array
{
    return [
        'attribute' => 'city',
        'label' => 'Ville',
        'encodeLabel' => false,
        'format' => 'ntext',
        'contentOptions' => ['class' => ''],
    ];
}

function getTva(): array
{
    return [
        'attribute' => 'tva',
        'label' => 'TVA',
        'encodeLabel' => false,
        'format' => 'ntext',
        'contentOptions' => ['class' => ''],
    ];
}

function getCompanyType(): array
{
    return [
        'attribute' => 'type',
        'label' => 'Type',
        'encodeLabel' => false,
        'format' => 'ntext',
        'contentOptions' => ['class' => ''],
    ];
}
