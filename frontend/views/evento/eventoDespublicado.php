<?php

use yii\helpers\Html;

$this->title = "Evento Anulado - " . $model->nombreCortoEvento;
?>
<div class="container">
    <div class = "row">
        <div class = "col-md-8 col-12 m-auto">
                <h2 class="text-center">Evento Suspendido</h2>
                <div class="p-3 mb-2 bg-danger text-white text-center">
                    Su evento ha sido suspendido exitosamente
                </div>
                <br>
                <hr>
                <div class="d-flex justify-content-center p-4">
                    <div>
                        <?= Html::a('Ver evento ', ['eventos/ver-evento/' . $model->nombreCortoEvento], ['class' => 'btn btn-outline-success btn-sm']) ?>
                        <?= Html::a('Editar evento ', ['eventos/editar-evento/' . $model->nombreCortoEvento], ['class' => 'btn btn-outline-success btn-sm']) ?>
                        <?= Html::a('Publicar evento ', ['eventos/publicar-evento/' . $model->nombreCortoEvento], ['class' => 'btn btn-outline-success btn-sm']) ?>
                        <?= Html::a('Cargar presentaciones ', ['presentacion/cargar-presentacion/' . $model->nombreCortoEvento], ['class' => 'btn btn-outline-success btn-sm']) ?>
                    </div>
                </div> 
                <br>
                <hr>   
        </div>
    </div>
</div>