<?php

use app\widgets\TopTitle;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\assets\companies\ContactViewAsset;

$this->title = 'Liste des contacts';
$this->params['breadcrumbs'][] = $this->title;

ContactViewAsset::register($this);

?>

<?= TopTitle::widget(['title' => $this->title]) ?>

<div class="container">
    <div class="contact-view">
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
            <a href="/company/create-contact" class="btn-floating btn-large gradient-45deg-light-blue-cyan gradient-shadow">
                <i class="material-icons">add</i>
            </a>
        </div>

    </div>
</div>

<?php

function getSearchFilter()
{
    echo Html::input('text', 'textinput_user', '', [
        'id' => 'contact-firstname-search',
        'class' => 'form-control',
        'maxlength' => 10,
        'style' => 'width:350px',
        'placeholder' => 'Rechercher un nom de contact',
        'onkeyup' => 'contactNameFilterSearch()'
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
    array_push($result, getFirstnameArray());
    array_push($result, getSurnameArray());
    array_push($result, getPhoneNumberArray());
    array_push($result, getEmailArray());

    return $result;
}

function getFirstnameArray(): array
{
    return [
        'attribute' => 'firstname',
        'format' => 'raw',
        'label' => 'Prénom',
        'contentOptions' => ['class' => 'firstname-row'],
        'encodeLabel' => false
    ];
}

function getSurnameArray(): array
{
    return [
        'label' => 'Nom',
        'encodeLabel' => false,
        'format' => 'ntext',
        'attribute' => 'surname',
        'contentOptions' => ['class' => 'surname-row'],
    ];
}

function getPhoneNumberArray(): array
{
    return [
        'label' => 'Téléphone',
        'encodeLabel' => false,
        'format' => 'ntext',
        'attribute' => 'phone_number',
        'contentOptions' => ['class' => 'phone_number-row'],
    ];
}

function getEmailArray(): array
{
    return [
        'label' => 'Email',
        'encodeLabel' => false,
        'format' => 'ntext',
        'attribute' => 'email',
        'contentOptions' => ['class' => 'email-row'],
    ];
}

?>