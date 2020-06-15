<?php

use yii\helpers\Html;

?>
<div class="container">
    <div class = "row">
        <div class = "col-md-8 col-12 m-auto">
                <h2 class="text-center">Evento Publicado</h2>
                <div class="p-3 mb-2 bg-success text-white text-center">
                    Su evento ha sido publicado exitosamente
                </div>
                <br>
                <hr>
                <div class="d-flex justify-content-center p-4">
                    <div>
                        <?= Html::a('Ver evento', ['ver-evento', 'idEvento' => $model->idEvento], ['class' => 'btn btn-outline-success btn-sm']) ?>
                        <?= Html::a('Editar evento ', ['editar-evento', 'idEvento' => $model->idEvento], ['class' => 'btn btn-outline-success btn-sm']) ?>
                        <?= Html::a('Despublicar evento ', ['despublicar-evento', 'idEvento' => $model->idEvento], ['class' => 'btn btn-outline-danger btn-sm']) ?>
                        <?= Html::a('Cargar presentaciones ', ['presentacion/cargar-presentacion', 'idEvento' => $model->idEvento], ['class' => 'btn btn-outline-success btn-sm']) ?>
                    </div>
                </div>
                <br>
                <hr>     
        </div>
    </div>
</div>