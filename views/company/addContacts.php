<?php

use yii\helpers\Html;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\widgets\ActiveForm;
use app\assets\AppAsset;
use app\widgets\TopTitle;

/* @var $this yii\web\View */
/* @var $model app\models\devis\Devis */

$this->title = 'Ajout de contacts';

AppAsset::register($this);

?>

<?= TopTitle::widget(['title' => $this->title]) ?>

<div class="container">
    <div class="company-addContacts">

        <div class="row">
            <div class="col s8 offset-s2">

                <?php $form = ActiveForm::begin(['id' => 'dynamic-form', 'options' => ['enctype' => 'multipart/form-data']]); ?>

                <div class="card">

                    <div class="card-content">
                        <label>Echéancier de paiement</label>
                    </div>

                    <div class="card-action">
                        <?php DynamicFormWidget::begin([
                            'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                            'widgetBody' => '.container-items', // required: css class selector
                            'widgetItem' => '.item', // required: css class
                            'limit' => 4, // the maximum times, an element can be cloned (default 999)
                            'min' => 1, // 0 or 1 (default 1)
                            'insertButton' => '.add-item', // css class
                            'deleteButton' => '.remove-item', // css class
                            'model' => $milestones[0],
                            'formId' => 'dynamic-form',
                            'formFields' => [
                                'id',
                                'prix_jalon',
                                'price',
                                'delivery_date',
                                'comments'
                            ],
                        ]); ?>

                        <div class="container-items">
                            <!-- widgetContainer -->
                            <?php foreach ($milestones as $i => $milestone) : ?>
                                <div class="item panel panel-default">
                                    <!-- widgetBody -->
                                    <div class="panel-heading">
                                        <h3 class="panel-title pull-left">Jalon </h3>
                                        <div class="pull-right">
                                            <button type="button" class="add-item waves-effect waves-light btn btn-grey"><i class="glyphicon glyphicon-plus"></i></button>
                                            <button type="button" class="remove-item waves-effect waves-light btn btn-grey"><i class="glyphicon glyphicon-minus"></i></button>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="panel-body">
                                        <?php
                                        // necessary for update action.
                                        if (!$milestone->isNewRecord) {
                                            echo Html::activeHiddenInput($milestone, "[{$i}]id");
                                        }
                                        ?>

                                        <div class="row">
                                            <div>
                                                <?= $form->field($milestone, "[{$i}]label")->textInput(['autocomplete' => 'off', 'maxlength' => true])->label('Nom du jalon') ?>
                                                <?= $form->field($milestone, "[{$i}]price")->textInput(['class' => 'priceHt', 'autocomplete' => 'off', 'maxlength' => true])->label('Prix HT') ?>
                                                <?= $form->field($milestone, "[{$i}]comments")->textarea(['autocomplete' => 'off', 'maxlength' => true])->label('Commentaire') ?>
                                            </div>
                                        </div><!-- .row -->

                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <?php DynamicFormWidget::end(); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?= Html::submitButton('Enregistrer', ['class' => 'waves-effect waves-light btn btn-blue ']) ?>
                    <?= Html::a('Annuler', ['index'], ['class' => 'waves-effect waves-light btn btn-grey']) ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>

    </div>
</div>

<?php
