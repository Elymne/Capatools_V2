<?php

use yii\helpers\Html;

$this->title = 'Devis ' . $query->id_capa;

?>

<h3><?= Html::encode($this->title) ?></h3>

<div class="row">
    <div class="card teal white">
        <div class="card-content">

            <span class="card-title"> Modification du devis : <?php echo $query->internal_name; ?></span>

            <?= $this->render('_form', [
                'query' => $query,
            ]) ?>

        </div>
    </div>
</div>