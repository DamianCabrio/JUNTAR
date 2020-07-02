<?php

use yii\bootstrap4\Modal;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Url;

$this->title = "Responder Formulario";
?>
    <noscript><meta http-equiv="refresh"content="0; url=<?= Url::toRoute(["eventos/no-js"]) ?>"></noscript>

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
                'options' => ['class' => 'form-horizontal', 'enctype'=>'multipart/form-data'],
            ])
    ?>
    <?php foreach ($preguntas as $i => $pregunta) : ?>
        <div class='card mb-5'>
            <div class='card-header darkish_bg text-white'>
                <h5>Pregunta <?= ($i + 1) ?></h5>
            </div>
            <div class='card-body'>
                <?= $pregunta->descripcion ?>
            </div>
            <div class='card-footer'>
            <?php if ($respuestaYaHechas[$i] == false) : ?>
                <?php if ($pregunta->tipo == 1): ?>
                    <?= $form->field($model, "respuestaCorta[$i]")->textInput(['maxlength' => true])->label(false) ?>
                    <small id="respuestaCortaHelp" class="form-text text-muted">Maximo 50 caracteres</small>
                <?php endif; ?>
                <?php if ($pregunta->tipo == 2): ?>
                    <?= $form->field($model, "respuesta[$i]")->textarea(['maxlength' => true])->label(false) ?>
                    <small id="respuestaLargaaHelp" class="form-text text-muted">Maximo 500 caracteres</small>
                <?php endif; ?>
                <?php if ($pregunta->tipo == 3): ?>
                    <?= $form->field($model, "file[$i]")->fileInput()->label(false) ?>
                    <small id="respuestaFileaHelp" class="form-text text-muted">Maximo 5 megas. Formatos aceptados: zip, rar, pdf</small>
                <?php endif; ?>

            <?php else: ?>
                <?php if ($pregunta->tipo != 3): ?>
                    <span>Respuesta: <?= Html::encode($respuestaYaHechas[$i]->respuesta) ?></span>
                <?php else: ?>
                    <span>Respuesta: <?= Html::a("Descargar", Url::base(true) . Html::encode($respuestaYaHechas[$i]->respuesta), ['class' => 'btn btn-lg btn-outline-success', "target" => "_blank"]) ?></span>
                <?php endif; ?>
            <?php endif; ?>
            </div>
        </div>
    <?php endforeach; ?>

    <?php if (!$todasRespuestasHechas): ?>
    <?= Html::submitButton("Enviar", ['class' => 'btn btn-lg btn-outline-success']) ?>
    <?php endif; ?>
    <?= Html::a('Volver Atrás', Url::toRoute("eventos/ver-evento/" . $evento->nombreCortoEvento), ['class' => 'btn btn-lg btn-outline-success']); ?>
    <?php ActiveForm::end() ?>

    <br><br>

</div>

<?php
Modal::begin([
    'id' => 'modalPregunta',
    'size' => 'modal-lg',
    'headerOptions' => ['class' => 'darkish_bg text-white']
]);
Modal::end();
?>
