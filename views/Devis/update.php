<?php

use yii\helpers\Html;

use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $model app\models\devis\Devis */

$this->title = 'Mise à jour du devis :'. $model->id_capa ;
$this->params['breadcrumbs'][] = ['label' => 'Devis', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Updateavcontrat';
?>
<div class="devis-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>


<?= $form->field($model, 'internal_name')->textInput(['maxlength' => true,'disabled'=>true])->label("Nom du projet") ?>

<?= $form->field($model, 'company[name]')->textInput()->label("Nom du client") ?>
<?= $form->field($model, 'company[tva]')->textInput()->label("TVA") ?>

<?= $form->field($model, 'service_duration')->textInput()->label("Durée de la prestation (j)") ?>


<?= $form->field($model, 'filename')->textInput(['maxlength' => true,'disabled'=>true])->label('Proposition Technique') ?>
<?=   Html::a('Visualiser', Html::encode(Yii::$app->basePath).'\\uploads\\'.$model->id_capa.'\\'.$model->filename)?>
<?= $form->field($model, 'upfilename')->fileInput()->label('Replacer le fichier:') ?>


<div class="form-group">
    <?= Html::submitButton('Enregistrer', ['class' => 'btn btn-success']) ?>
    <?= Html::a('Annuler', ['index'], ['class'=>'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?>

</div>
