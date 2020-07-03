<?php

use yii\helpers\Html;

$this->title = "No js";
?>

<div class="container">
    <h1>Para visualizar esta pagina debe tener habilitado javascript</h1>
    <h3>Por favor vuelva a intentar ingresar en un dispositivo con javascript</h3>
    <?= Html::a("Ir a inicio", Yii::$app->homeUrl, ['class' => 'btn btn-lg btn-outline-success']) ?>
</div>
