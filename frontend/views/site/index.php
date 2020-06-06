<?php

/* @var $this yii\web\View */

use yii\bootstrap4\Html;

$this->title = 'Proyecto Juntar';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1> Bienvenido! </h1>

        <p class="lead">  </p>

        
    </div>

    <div class="body-content">

        <?= Html::a('Ir a evento', ['/controller/action'], ['class'=>'btn btn-primary'])?>
        
    </div>
</div>
