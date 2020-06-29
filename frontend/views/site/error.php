<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

$this->title = $name;
?>
<div class="site-error container">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="alert alert-danger">
        <?= nl2br(Html::encode($message)) ?>
    </div>

    <p class="mt-4"> El error tuvo lugar mientras el servidor web intentaba procesar su petición </p>
    <p> Si sospecha que el error es un problema del servidor, por favor, pongase en contacto con los administradores. </p>
    <p> Sepa disculpar las molestias. ¡Muchas gracias! </p>
    <?= Html::a("Ir al inicio", ["site/index"], ['class' => 'btn btn-success']) ?>
</div>
