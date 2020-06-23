<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\RespuestaFile */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="respuesta-form">

    <?php $form = ActiveForm::begin([
        'id' => 'responder-pregunta-form',
        'enableAjaxValidation' => true,
    ]); ?>

    <?php if($pregunta->tipo == 1): ?>
    <?= $form->field($model, 'respuesta')->textInput(['maxlength' => true])->label(false) ?>
    <?php endif; ?>
    <?php if($pregunta->tipo == 2): ?>
        <?= $form->field($model, 'respuesta')->textarea(['maxlength' => true])->label(false) ?>
    <?php endif; ?>
    <?php if($pregunta->tipo == 3): ?>
        <?= $form->field($model, 'respuesta')->fileInput(["required"])->label(false) ?>
    <?php endif; ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
