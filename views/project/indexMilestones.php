<?php

use app\assets\AppAsset;
use app\assets\projects\ProjectIndexMilestonesAsset;
use app\widgets\TopTitle;
use yii\grid\GridView;
use yii\widgets\Pjax;

$this->title = 'Liste des jalons';
$this->params['breadcrumbs'][] = $this->title;

AppAsset::register($this);
//ProjectIndexMilestonesAsset::register($this);
?>

<?= TopTitle::widget(['title' => $this->title]) ?>

<div class="container">
    <div class="project-index">
        <div class="row">

            <!-- GRIDVIEW - LISTE DES JALONS -->
            <div class="card">
                <div class="card-action">
                    <div class="scroll-box">
                        <?php Pjax::begin(['id' => '1']); ?>
                        <?= GridView::widget([
                            'dataProvider' => $dataProvider,
                            'rowOptions' => [
                                'style' => 'height:20px;',
                                'text-overflow:ellipsis;'
                            ],
                            'tableOptions' => [
                                'id' => 'devis_table',
                                'style' => 'height: 10px',
                                'class' => ['highlight']
                            ],
                            'columns' => getCollumnsArray()
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

    return $result;
}
