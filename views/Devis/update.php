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
<?php
if($model->filename!='')
{  
  echo Html::a('Visualiser', ['viewpdf','id'=> $model->id,],['class'=>'btn btn-primary']);
  echo $form->field($model, 'upfilename')->fileInput()->label('Remplacer le fichier:') ;
}
else
{
   echo $form->field($model, 'upfilename')->fileInput()->label('Ajouter le fichier:') ;

}
?>


<div class="form-group">
    <?= Html::submitButton('Enregistrer', ['class' => 'btn btn-success']) ?>
    <?= Html::a('Annuler', ['index'], ['class'=>'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?>

</div>
