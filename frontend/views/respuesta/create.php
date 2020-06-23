<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\RespuestaFile */

$this->title = 'RespuestaFile';
?>
<div class="respuesta-create">

    <h3><?= $pregunta->descripcion; ?></h3>

    <?= $this->render('_form', [
        'model' => $model,
        "pregunta" => $pregunta,
    ]) ?>

</div>
