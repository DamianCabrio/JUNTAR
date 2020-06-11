<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use frontend\models\PresentacionExpositor;
/* @var $this yii\web\View */
/* @var $model frontend\models\Presentacion */

$this->title = $model->tituloPresentacion;
\yii\web\YiiAsset::register($this);

?>
<div class="container">
    <div class = "row">
        <div class = "col-md-8 col-12 m-auto">
             <h2 class="text-center">Presentacion cargada</h2>
                <div class="p-3 mb-2 bg-success text-white text-center">
                    Su presentacion ha sido cargado exitosamente
                </div>
                <br>
                <hr>
                <div>
                 <?= Html::a('Cargar nueva Presentacion', ['cargar-presentacion', 'idEvento' => $evento->idEvento], ['class' => 'btn btn-outline-success btn-sm']) ?>
                </div>
        </div>
    </div>
</div>