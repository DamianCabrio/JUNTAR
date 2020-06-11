<?php

use yii\helpers\Html;

?>
<div class="container">
<<<<<<< HEAD
    <div class = "row">
        <div class = "col-md-8 col-12 m-auto">
                <h2 class="text-center">Evento cargado</h2>
                <div class="p-3 mb-2 bg-success text-white text-center">
                    Su evento ha sido cargado exitosamente
                </div>
                <br>
                <hr>
                <div>
                    <?= Html::a('Ver evento ', ['ver-evento', 'idEvento' => $model->idEvento], ['class' => 'btn btn-outline-success btn-sm']) ?>
                    <?= Html::a('Editar evento ', ['editar-evento', 'idEvento' => $model->idEvento], ['class' => 'btn btn-outline-success btn-sm']) ?>
                    <?= Html::a('Publicar evento ', ['publicar-evento', 'idEvento' => $model->idEvento], ['class' => 'btn btn-outline-success btn-sm']) ?>
                    <?= Html::a('Cargar presentaciones ', ['presentacion/cargar-presentacion', 'idEvento' => $model->idEvento], ['class' => 'btn btn-outline-success btn-sm']) ?>
=======
    <h2 class="text-center">Evento cargado</h2>
    <div class="p-3 mb-2 bg-success text-white text-center">
        Su evento ha sido cargado exitosamente con los siguientes datos
    </div>

    <table class="table table-striped">
        <tbody>
            <tr>
                <!--<th scope="col">numero de evento</th>
                <th scope="col">Usuario Organizador</th> -->
                <th scope="col">Nombre</th>
                <td><?= $model->nombreEvento ?></td>
            </tr>
            <tr>
                <th scope="col">Descripcion</th>
                <td><?= $model->descripcionEvento ?></td>
            </tr>
            <tr>
                <th scope="col">Lugar</th>
                <td><?= $model->lugar ?></td>
            </tr>
            <tr>
                <th scope="col">Fecha Inicio Evento</th>
                <td><?= $model->fechaInicio ?></td>
            </tr>
            <tr>
                <th scope="col">Fecha Fin Evento</th>
                <td><?= $model->fechaFin ?></td>
            </tr>
            <tr>
                <th scope="col">Modalidad</th>
                <td><?= $model->modalidad ?></td>
            </tr>
            <tr>
                <th scope="col">Link a Recursos</th>
                <td><?= $recursos ?></td>
            </tr>
            <tr>
                <th scope="col">Link Flyer</th>
                <td><?= $flyer ?></td>
            </tr>
            <tr>
                <th scope="col">Logo</th>
                <td><?= $logo ?></td>
            </tr>
            <tr>
                <th scope="col">Capacidad</th>
                <td><?= $model->capacidad ?></td>
            </tr>
            <tr>
                <th scope="col">Preinscripcion</th>
                <td><?= $preIncripcion ?></td>
            </tr>
            <tr>
                <th scope="col">Fecha Límite </th>
                <td><?= $model->fechaLimiteInscripcion ?></td>
            </tr>
            <tr>
                <th scope="col">Codigo Acreditación</th>
                <td><?= $codAcreditacion ?></td>
            </tr>
        </tbody>
    </table>
    <div>
        <br>
        <hr>

        <div class="">

            <br>
            <div class="d-flex justify-content-center">
                <div class="btn-group" role="group" aria-label="Basic example">
                    
                        <h4 class="text-center"> <?= Html::a('¿Agregar presentacion al evento?', ['presentacion/cargar-presentacion', 'idEvento' => $model->idEvento], ['class' => 'btn btn-outline-success p-3']) ?></h4>
                    
>>>>>>> 0aa7babc4896c9ceff66de1cae96c2d89427c6c6
                </div>
        </div>
    </div>
</div>