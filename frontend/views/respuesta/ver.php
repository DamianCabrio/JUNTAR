<?php

use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model frontend\models\RespuestaFile */
/* @var $form yii\widgets\ActiveForm */

$this->title = "Respuestas";
?>

<div class="respuesta-form text-center container">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'],
        'id' => 'respuestas-form',
    ]); ?>

    <?php foreach ($preguntas as $i => $pregunta): ?>
    <h5><?=$pregunta->descripcion?></h5>

        <?php if($respuestas[$i] != null){
            $tieneRespuesta = true;
            $respuestaAPregunta = $respuestas[$i]->respuesta;
        }else{
            $tieneRespuesta = false;
            $respuestaAPregunta = "No se contesto";
        }?>
        <?php if($pregunta->tipo == 1): ?>
        <?= Html::input("text", "respuesta".$i, $respuestaAPregunta, ["disabled" => true]) ?>
        <?php elseif($pregunta->tipo == 2): ?>
        //echo Html::textarea("respuesta".$i, $respuestaAPregunta,["disabled" => true]);
        <?= Html::decode($respuestaAPregunta); ?>
        <?php elseif($pregunta->tipo == 3): ?>
            <?php if(!$tieneRespuesta): ?>
            <p><?= $respuestaAPregunta ?></p>
            <?php else: ?>
                <?= Html::a("Descargar", $respuestaAPregunta, ["download" => true]); ?>
            <?php endif; ?>
        <?php endif; ?>
        <br><br>
    <?php endforeach; ?>
    <div class="form-group">
        <?php if($esAjax): ?>
        <?= \yii\bootstrap4\Html::button("Cerrar", ["data-dismiss" => "modal", 'class' => 'btn btn-outline-success'])?>
        <?php else: ?>
            <?= \yii\bootstrap4\Html::a("Volver Atras", Url::previous("verRespuestas") , ['class' => 'btn btn-outline-success'])?>
        <?php endif; ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
