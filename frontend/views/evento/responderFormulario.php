<?php

use yii\bootstrap4\Modal;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Url;

$this->title = "Responder Formulario";
?>

<div class="responder-formulario container">
    <div class="pb-5">
        <div class="card-header darkish_bg text-white">
            <h3>Formulario de Pre-Inscripción</h3>
            <h5>Responda con <span class="pinkish_text">cuidado</span>, no se pueden editar las respuestas.</h5>
        </div>
    </div>
    <?php
    $form = ActiveForm::begin([
        'id' => 'respuestas-form',
        'options' => ['class' => 'form-horizontal'],
    ]) ?>
    <?php foreach ($preguntas as $i => $pregunta) : ?>
        <div class='card mb-5'>
           <div class='card-header darkish_bg text-white'>
           <h5>Pregunta <?= ($i + 1) ?></h5>
        </div>
        <div class='card-body'>
           <?= $pregunta->descripcion ?>
        </div>
        <div class='card-footer'>
            <?php if($pregunta->tipo == 1): ?>
                <?= $form->field($model, 'respuestaCorta')->textInput(['maxlength' => true])->label(false) ?>
            <?php endif; ?>
            <?php if($pregunta->tipo == 2): ?>
                <?= $form->field($model, 'respuesta')->textarea(['maxlength' => true])->label(false) ?>
            <?php endif; ?>
            <?php if($pregunta->tipo == 3): ?>
                <?= $form->field($model, 'file')->fileInput()->label(false) ?>
            <?php endif; ?>
        <?php if ($respuestaYaHechas[$i] == false) : ?>
           <?php $url = Url::toRoute(["respuesta/create?id=" . $pregunta->id . "&id2=" . $idInscripcion]) ?>
            <?= Html::a('Completar ' . ($i + 1), $url, [
                'class' => 'btn btn-lg responderPregunta'
            ]); ?>
        <?php else : ?>

        <?php if($pregunta->tipo == 3): ?>
            <span>Respuesta: <?= Html::encode($respuestaYaHechas[$i]->respuesta) ?></span>
        <?php else: ?>
                <span>Respuesta: <?= Html::a("Descargar", Html::encode($respuestaYaHechas[$i]->respuesta), ['class' => 'btn btn-lg btn-outline-success']) ?></span>
        <?php endif; ?>
        <?php endif; ?>
        </div>
        </div>
    <?php endforeach; ?>
    <?php ActiveForm::end() ?>

    <br><br>

    <?= Html::a('Volver Atrás', Url::toRoute("eventos/ver-evento/" . $evento->nombreCortoEvento), ['class' => 'btn btn-lg btn-outline-success']); ?>

</div>

<?php
Modal::begin([
    'id' => 'modalPregunta',
    'size' => 'modal-lg',
    'headerOptions' => ['class' => 'darkish_bg text-white']

]);
Modal::end();
?>