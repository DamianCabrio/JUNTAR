<?php

use yii\bootstrap4\Modal;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Url;

$this->title = "Responder Formulario";
?>

<div class="responder-formulario container">
    <h3>Haga click en los en cada botón para completar su Preinscripción</h3>
    <h5>Responda con cuidado, no se puede editar las respuestas</h5>
    <?php foreach ($preguntas as $i => $pregunta): ?>
    <?php if($respuestaYaHechas[$i] == false): ?>
        <?php $url = Url::toRoute(["respuesta/create?id=" . $pregunta->id . "&id2=" . $idInscripcion]) ?>
            <?= Html::a('Pregunta ' . ($i + 1), $url, ['class' => 'btn btn-outline-success responderPregunta',
                "data-id" => $url]); ?>
        <?php else: ?>
            <?= Html::button('Pregunta ' . ($i + 1),  ['class' => 'btn btn-outline-secondary', "disabled" => true, "style" => "background-color: #FE1355;"]); ?>
    <?php endif; ?>
    <?php endforeach; ?>

    <br><br>

        <?= Html::a('Volver Atras', Url::toRoute("eventos/ver-evento/" . $evento->nombreCortoEvento), ['class' => 'btn btn-outline-success']); ?>

</div>

<?php
Modal::begin([
    'id' => 'modalPregunta',
    'size' => 'modal-lg'
]);
Modal::end();
?>