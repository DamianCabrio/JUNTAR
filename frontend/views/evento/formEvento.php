<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\Evento */
/* @var $form ActiveForm */
?>
<div class="formEvento">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'idUsuario') ?>
    <?= $form->field($model, 'nombreEvento') ?>
    <?= $form->field($model, 'descripcionEvento') ?>
    <?= $form->field($model, 'lugar') ?>
    <?= $form->field($model, 'fechaInicio')->input('date') ?>
    <?= $form->field($model, 'fechaFin')->input('date') ?>
    <?= $form->field($model, 'modalidad') ?>
    <?= $form->field($model, 'capacidad') ?>
    <?= $form->field($model, 'preInscripcion') ?>
    <?= $form->field($model, 'fechaLimiteInscripcion')->input('date') ?>
    <?= $form->field($model, 'codigoAcreditacion') ?>
    <?= $form->field($model, 'linkPresentaciones') ?>
    <?= $form->field($model, 'linkFlyer') ?>
    <?= $form->field($model, 'linkLogo') ?>

    <div class="form-group">
        <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>

</div><!-- formEvento -->