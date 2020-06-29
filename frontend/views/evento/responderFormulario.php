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

    <?php foreach ($preguntas as $i => $pregunta) : ?>
           <?php echo "<div class='card pb-5'>" ?>
           <?php echo "<div class='card-header darkish_bg text-white'>" ?>
           <?php echo "<h5>Pregunta " . ($i + 1)."</h5>" ?>
           <?php echo "</div>" ?>
           <?php echo "<div class='card-body'>" ?>
           <?php echo $pregunta->descripcion ?>
           <?php echo "</div>" ?>
           <?php echo "<div class='card-footer'>" ?>
        <?php if ($respuestaYaHechas[$i] == false) : ?>
           <?php $url = Url::toRoute(["respuesta/create?id=" . $pregunta->id . "&id2=" . $idInscripcion]) ?>
            <?= Html::a('Completar ' . ($i + 1), $url, [
                'class' => 'btn btn-lg responderPregunta'
            ]); ?>
        <?php else : ?>
            <?= Html::button('Pregunta ' . ($i + 1),  ['class' => 'btn btn-lg', "disabled" => true, "style" => "background-color: #FE1355;"]); ?>
            <p><?= Html::encode($respuestaYaHechas[$i]->respuesta) ?></p>
        <?php endif; ?>
           <?php echo "</div>" ?>
           <?php echo "</div>" ?>
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