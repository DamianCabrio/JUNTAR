<?php

use yii\bootstrap4\Modal;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Url;

$this->title = "Responder Formulario";
?>

<div class="responder-formulario container">
    <div class="padding_section">
        <div class="card-header darkish_bg text-white">
            <h3>Formulario de Pre-Inscripción</h3>
            <h5>Responda con <span class="pinkish_text">cuidado</span>, no se pueden editar las respuestas.</h5>
        </div>
    </div>

<!-- acá el foreach -->
    <div class="card">
        <div class="card-header darkish_bg text-white">
            <h5>Pregunta 1</h5>
        </div>
        <div class="card-body">

            <p class="card-text">Pregunta completa acá</p>
            <hr>
            <a href="#" class="btn btn-lg">Responder</a>
            <hr>
            <p class="card-text">Respuesta completa acá sin que se vea el botón</p>

        </div>
    </div>

    <br> <!-- separa por mientras -->

    <?php foreach ($preguntas as $i => $pregunta) : ?>
        <?php if ($respuestaYaHechas[$i] == false) : ?>
            <?php $url = Url::toRoute(["respuesta/create?id=" . $pregunta->id . "&id2=" . $idInscripcion]) ?>
            <?= Html::a('Pregunta ' . ($i + 1), $url, [
                'class' => 'btn btn-outline-success responderPregunta',
                "data-id" => $url
            ]); ?>
        <?php else : ?>
            <?= Html::button('Pregunta ' . ($i + 1),  ['class' => 'btn btn-outline-secondary', "disabled" => true, "style" => "background-color: #FE1355;"]); ?>
        <?php endif; ?>
    <?php endforeach; ?>

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