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
        <?php foreach ($eventos as $evento){
        echo Html::a($evento["nombreEvento"], ['/evento/view', "id" => $evento["idEvento"]], ['class' => 'btn btn-primary m-2']);
        } ?>
        
    </div>
</div>
