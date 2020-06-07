<?php

use yii\helpers\Html;


if ($model->linkPresentaciones != null) {
    $recursos = $model->linkPresentaciones;
} else {
    $recursos = "No disponible";
}

if ($model->linkFlyer != null) {
    $flyer = $model->linkFlyer;
} else {
    $flyer = "No disponible";
}
if ($model->linkLogo != null) {
    $logo = $model->linkLogo;
} else {
    $logo = "No disponible";
}
if ($model->preInscripcion == 0) {
    $preIncripcion = "Requiere preinscipcion";
} else {
    $preIncripcion = "No Requiere preinscipcion";
}
if ($model->codigoAcreditacion != null) {
    $codAcreditacion = $model->codigoAcreditacion;
} else {
    $codAcreditacion = "No disponible";
}



?>
<div class="container">
    <h4 class="text-center">Evento cargado</h4>
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
                    <button type="button" class="btn btn-outline-success p-3"><h4 class="text-center"> ¿Agregar presentaciones al evento?</h4></button>
                </div>
            </div>
        </div>

    </div>
</div>