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
        <? $url = Url::to([""]) ?>
        <?= Html::a($eventos[0]["nombreEvento"], ['/evento/view', "id" => $eventos[0]["idEvento"]], ['class'=>'btn btn-primary'])?>
        
    </div>
</div>
