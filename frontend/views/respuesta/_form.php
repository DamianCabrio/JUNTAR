<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model frontend\models\RespuestaFile */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="respuesta-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'],
        'id' => 'responder-pregunta-form',
    ]); ?>

    <?php if($pregunta->tipo == 1): ?>
    <?= $form->field($model, 'respuesta')->textInput(['maxlength' => true])->label(false) ?>
    <?php endif; ?>
    <?php if($pregunta->tipo == 2): ?>
        <?= $form->field($model, 'respuesta')->textarea(['maxlength' => true])->label(false) ?>
    <?php endif; ?>
    <?php if($pregunta->tipo == 3): ?>
        <?= $form->field($model, 'file')->fileInput()->label(false) ?>
    <?php endif; ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-lg']) ?>
        <?php if($volverAtras): ?>
        <?= Html::a("Volver Atras", Url::toRoute(["eventos/responder-formulario/" . $inscripcion->idEvento0->nombreCortoEvento]) ,['class' => 'btn btn-lg']) ?>
        <?php endif; ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
