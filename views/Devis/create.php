<?php

use yii\helpers\Html;

use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\devis\Devis */

$this->title = 'Création du devis';
$this->params['breadcrumbs'][] = ['label' => 'Devis', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="devis-create">

    <h1><?= Html::encode($this->title) ?></h1>


<?php $form = ActiveForm::begin(); ?>


<?= $form->field($model, 'internal_name')->textInput(['maxlength' => true,])->label("Nom du projet") ?>

<?= $form->field($model, 'companyname')->textInput()->label("Nom du client") ?>
<?= $form->field($model, 'companytva')->textInput()->label("TVA") ?>

<div class="form-group">
    <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>

</div>

