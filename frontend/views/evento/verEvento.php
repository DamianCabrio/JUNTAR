<?php

use yii\helpers\Html;
use frontend\models\PresentacionExpositor;
use backend\models\Usuario;


if ($model->imgFlyer != null) {
    $flyer = '<img  class="img-fluid" width="300px" src=/' . $model->imgFlyer . '>';
} else {
    $flyer = "Dato no cargado";
}
if ($model->imgLogo != null) {
    $logo = '<img class="img-fluid" width="300px" src=/' . $model->imgLogo . '>';
} else {
    $logo = "Dato no cargado";
}

if ($model->preInscripcion == 0) {
    $preIncripcion = "No requiere preinscipcion";
} else {
    $preIncripcion = "Requiere preinscipcion";
}
if ($model->codigoAcreditacion != null) {
    $codAcreditacion = $model->codigoAcreditacion;
} else {
    $codAcreditacion = "Dato no cargado";
}


if ($model->fechaCreacionEvento != null) {
    $fechaPublicacion = $model->fechaCreacionEvento;
} else {
    $fechaPublicacion = "Dato no cargado";
}


$categoriaEvento = $model->idCategoriaEvento0->descripcionCategoria;
$modalidadEvento = $model->idModalidadEvento0->descripcionModalidad;
$estadoEvento = $model->idEstadoEvento0->descripcionEstado;

?>
<div class="container">
    <h2 class="text-center">Su evento cargado</h2>
    <p class="text-center">Posee los siguientes datos

        <table class="table">
            <tbody>
                <tr>
                    <th scope="col">Nombre</th>
                    <td><?= $model->nombreEvento ?></td>
                </tr>
                <tr>
                    <th scope="col">Nombre corto</th>
                    <td><?= $model->nombreCortoEvento ?></td>
                </tr>
                <tr>
                    <th scope="col">Descripción</th>
                    <td><?= $model->descripcionEvento ?></td>
                </tr>
                <tr>
                    <th scope="col">Lugar</th>
                    <td><?= $model->lugar ?></td>
                </tr>
                <tr>
                    <th scope="col">Categoria</th>
                    <td><?= $categoriaEvento ?></td>
                </tr>
                <tr>
                    <th scope="col">Modalidad</th>
                    <td><?= $modalidadEvento ?></td>
                </tr>
                <tr>
                    <th scope="col">Estado</th>
                    <td><?= $estadoEvento ?></td>
                </tr>
                <tr>
                    <th scope="col">Fecha Inicio Evento</th>
                    <td><?= $model->fechaInicioEvento ?></td>
                </tr>
                <tr>
                    <th scope="col">Fecha Fin Evento</th>
                    <td><?= $model->fechaFinEvento ?></td>
                </tr>
                <tr>
                    <th scope="col">Logo</th>
                    <td><?= $logo ?></td>
                </tr>
                <tr>
                    <th scope="col">Flyer</th>
                    <td><?= $flyer ?></td>
                </tr>
                <tr>
                    <th scope="col">Capacidad espectadores</th>
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
                    <th scope="col">Código Acreditación</th>
                    <td><?= $codAcreditacion ?></td>
                </tr>
                <tr>
                    <th scope="col">Fecha de publicación </th>
                    <td><?= $fechaPublicacion ?></td>
                </tr>
            </tbody>
        </table>
        <div>
        </div>

        <h2 class="text-center"><?= Html::encode('Presentaciones') ?></h2>
        <?php
        $cont = 0;
        foreach ($presentacion as $objPresentacion) :
            $cont++;
            $arrExpoPre = PresentacionExpositor::find()->where(['idPresentacion' => $objPresentacion->idPresentacion ])->all();

        ?>
            <table class="table">
                <thead>
                    <th scope="col"></th>
                    <th scope="col">Titulo Presentacion</th>
                    <th scope="col">Descripcion Presentacion</th>
                    <th scope="col">Dia</th>
                    <th scope="col">Hora Inicio </th>
                    <th scope="col">Hora Fin </th>
                    <th scope="col">Links a recursos </th>
                    <th scope="col">Expositores</th>
                </thead>
                <tbody>
                    <tr>
                        <th><?= $cont ?></th>
                        <td><?= $objPresentacion->tituloPresentacion ?></td>
                        <td><?= $objPresentacion->descripcionPresentacion ?></td>
                        <td><?= $objPresentacion->diaPresentacion ?></td>
                        <td><?= $objPresentacion->horaInicioPresentacion ?></td>
                        <td><?= $objPresentacion->horaFinPresentacion ?></td>
                        <td><?= $objPresentacion->linkARecursos ?></td>
                        <td>
                            <?php
                            foreach ($arrExpoPre as $objExpoPre) {
                                $objUsuario = Usuario::findOne($objExpoPre->idExpositor); ?>
                                <ul>
                                    <li><b>Nombre:</b><?= Html::encode($objUsuario->nombre . ", " . $objUsuario->apellido) ?></li>
                                    <li><b>Contacto:</b><?= Html::encode($objUsuario->email) ?></li>
                                </ul>
                            <?php } ?>
                            <?= Html::a('Añadir Expositor', ['cargar-expositor', 'idPresentacion' => $objPresentacion->idPresentacion], ['class' => 'btn btn-primary']) ?>
                        </td>
                               
                        <?php endforeach; ?>
                    </tr>
                    <br>
                </tbody>
            </table>
        
</div>
</div>