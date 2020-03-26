<?php

use app\helper\_enum\UserRoleEnum;
use app\widgets\TopTitle;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\devis\DevisSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Liste des devis';
$this->params['breadcrumbs'][] = $this->title;

?>

<?= TopTitle::widget(['title' => $this->title]) ?>

<div class="container">
    <div class="devis-index">

        <!-- New -->

        <div class="row">
            <div class="card">

                <div class="card-content">

                    <br />
                    <?php Pjax::begin(['id' => '1']); ?>

                    <?= GridView::widget([
                        'id' => 'AvantContrat_id',
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'tableOptions' => [
                            'class' => ['highlight']
                        ],
                        'columns' => getCollumnArray()
                    ]); ?>

                    <?php Pjax::end(); ?>

                </div>
            </div>
        </div>

    </div>
</div>

<?php

/**
 * Used to display all data needed for the table.
 * 
 * @return Array All data for table.
 */
function getCollumnArray()
{
    $result = [];
    array_push($result, getIdArray());
    array_push($result, getInternalNameArray());
    array_push($result, getUsernameArray());
    if (Yii::$app->user->can(UserRoleEnum::OPERATIONAL_MANAGER_DEVIS) || Yii::$app->user->can(UserRoleEnum::ACCOUNTING_SUPPORT_DEVIS)) {
        array_push($result, getCelluleArray());
    }
    array_push($result, getCompanyArray());
    array_push($result, getStatusArray());
    array_push($result, getUpdateButtonData());
    array_push($result, getDocumentButtonData());
    array_push($result, getPdfButtonData());

    return $result;
}


function getIdArray()
{
    return [
        'attribute' => 'id_capa',
        'format' => 'raw',
        'label' => 'CapaID',
        'filterInputOptions' => [
            'class' => 'form-control',
            'placeholder' => 'Filtre CapaId'
        ],
        'value' => function ($data) {
            return Html::a($data['id_capa'], ['devis/view', 'id' => $data['id']]);
        }
    ];
}

function getInternalNameArray()
{
    return [
        'attribute' => 'internal_name',
        'format' => 'text',
        'label' => 'Nom du projet',
        'filterInputOptions' => [
            'class' => 'form-control',
            'placeholder' => 'Filtre Nom Projet'
        ]
    ];
}

function getUsernameArray()
{
    return [
        'attribute' => 'capa_user.username',
        'format' => 'text',
        'label' => 'Resp projet',
        'filterInputOptions' => [
            'class' => 'form-control',
            'placeholder' => 'Filtre Responsable'
        ]
    ];
}

function getVersionArray()
{
    return [
        'attribute' => 'version',
        'format' => 'text',
        'label' => 'Version du fichier',
        'filterInputOptions' => [
            'class' => 'form-control',
            'placeholder' => 'Filtre Version'
        ]
    ];
}

function getCelluleArray()
{
    return [
        'attribute' => 'cellule.name',
        'format' => 'text',
        'label' => 'Cellule',
        'filterInputOptions' => [
            'class' => 'form-control',
            'placeholder' => 'Filtre Cellule'
        ]
    ];
}

function getCompanyArray()
{
    return [
        'attribute' => 'company.name',
        'format' => 'text',
        'label' => 'Entreprise',
        'filterInputOptions' => [
            'class' => 'form-control',
            'placeholder' => 'Filtre Entreprise'
        ]
    ];
}

function getStatusArray()
{
    return [
        'attribute' => 'devis_status.label',
        'format' => 'text',
        'label' => 'Statut',
    ];
}

function getUpdateButtonData()
{
    return [
        'format' => 'raw',
        'value' => function ($model, $key, $index, $column) {
            return Html::a(
                '<i class="material-icons right">build</i>',
                Url::to(['devis/update', 'id' => $model->id]),
                [
                    'id' => 'grid-custom-button',
                    'data-pjax' => true,
                    'action' => Url::to(['devis/update', 'id' => $model->id]),
                    'class' => 'btn-floating btn-large waves-effect waves-light orange',
                ]
            );
        }
    ];
}

function getDocumentButtonData()
{
    return [
        'format' => 'raw',
        'value' => function ($model, $key, $index, $column) {
            return Html::a(
                '<i class="material-icons right">cloud_download</i>',
                Url::to(['devis/view', 'id' => $model->id]),
                [
                    'id' => 'grid-custom-button',
                    'data-pjax' => true,
                    'action' => Url::to(['devis/update', 'id' => $model->id]),
                    'class' => 'btn-floating btn-large waves-effect waves-light blue',
                ]
            );
        }
    ];
}

function getPdfButtonData()
{
    return [
        'format' => 'raw',
        'value' => function ($model, $key, $index, $column) {
            return Html::a(
                '<i class="material-icons right">picture_as_pdf</i>',
                Url::to(['devis/pdf', 'id' => $model->id]),
                [
                    'id' => 'grid-custom-button',
                    'data-pjax' => true,
                    'action' => Url::to(['devis/pdf', 'id' => $model->id]),
                    'class' => 'btn-floating btn-large waves-effect waves-light purple',
                ]
            );
        }
    ];
}
