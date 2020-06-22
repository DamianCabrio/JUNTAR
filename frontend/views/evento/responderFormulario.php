<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Url;

$this->title = "Responder Formulario";
?>

<div class="responder-formulario container">

    <?php $form = ActiveForm::begin([
        'id' => 'respuesta-form',
        'enableAjaxValidation' => true,
        'options' => ['enctype' => 'multipart/form-data'],
    ]); ?>

    <?php foreach ($preguntas as $i => $pregunta): ?>

    <?php if($pregunta->tipo == 1): ?>
        <?= $form->field($model, "respuesta[$i]")->textInput(['maxlength' => true])->label("<strong>" . $pregunta->descripcion . "</strong>")  ?>
    <?php endif; ?>

        <?php if($pregunta->tipo == 2): ?>
            <?= $form->field($model, "respuesta[$i]")->textarea(['maxlength' => true], ["style" => "resize: none;"])->label("<strong>" . $pregunta->descripcion . "</strong>")  ?>
        <?php endif; ?>

        <?php if($pregunta->tipo == 3): ?>
            <?= $form->field($model, "respuesta[$i]")->fileInput()->label("<strong>" . $pregunta->descripcion . "</strong>") ?>
        <?php endif; ?>

    <?php endforeach; ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>