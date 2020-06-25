<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\RespuestaFile */

$this->title = 'Respuesta';
?>
<div class="respuesta-create  container">

    <h3><?= $pregunta->descripcion; ?></h3>

    <?= $this->render('_form', [
        'model' => $model,
        "pregunta" => $pregunta,
    ]) ?>
</div>
