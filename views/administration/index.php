<?php

use app\widgets\TopTitle;
use yii\helpers\Html;
use yii\grid\GridView;
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

                    <?php Pjax::begin(); ?>

                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        //'filterModel' => $searchModel,
                        'tableOptions' => [
                            'class' => ['highlight']
                        ],
                        'columns' => [
                            [
                                'attribute' => 'username',
                                'format' => 'raw',
                                'label' => '<span class="material-icons">arrow_drop_down</span> Salarier',
                                'encodeLabel' => false,
                                'value' => function ($data) {
                                    return Html::a($data['username'], ['administration/view', 'id' => $data['id']]);
                                }
                            ],
                            [
                                'label' => '<span class="material-icons">arrow_drop_down</span> Email',
                                'encodeLabel' => false,
                                'format' => 'ntext',
                                'attribute' => 'email',
                            ],
                            [
                                'label' => '<span class="material-icons">arrow_drop_down</span> Cellule',
                                'encodeLabel' => false,
                                'format' => 'ntext',
                                'attribute' => 'cellule.name',
                            ]
                        ],
                    ]); ?>

                    <?php Pjax::end(); ?>

                </div>
            </div>
        </div>

    </div>
</div>

<?php

function getCollumnArray()
{
}
