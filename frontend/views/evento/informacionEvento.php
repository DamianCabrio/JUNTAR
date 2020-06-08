<?php

use backend\models\Usuario;
use frontend\models\Expositor;
use frontend\models\PresentacionExpositor;
use yii\helpers\Html;
use yii\widgets\DetailView;

if ($evento->linkPresentaciones != null) {
    $recursos = $evento->linkPresentaciones;
} else {
    $recursos = "No disponible";
}

if ($evento->linkFlyer != null) {
    $flyer = "<a href=" . $evento->linkFlyer . ">" . $evento->linkFlyer . "</a>";
} else {
    $flyer = "No disponible";
}
if ($evento->linkLogo != null) {
    $logo = "<a href=" . $evento->linkLogo . ">" . $evento->linkLogo . "</a>";
} else {
    $logo = "No disponible";
}
if ($evento->preInscripcion == 0) {
    $preIncripcion = "No requiere preinscipcion";
} else {
    $preIncripcion = "Requiere preinscipcion";
}
if ($evento->codigoAcreditacion != null) {
    $codAcreditacion = $evento->codigoAcreditacion;
} else {
    $codAcreditacion = "No disponible";
}

/* @var $this yii\web\View */
/* @var $model frontend\models\Presentacion */

$this->title = $evento->nombreEvento;
\yii\web\YiiAsset::register($this);
?>
<div class="presentacion-view">

    <h2 class="text-center"><?= Html::encode($this->title) ?></h2>
    <p>
        <?= Html::a('Cargar nueva Presentacion al Evento', ['presentacion/cargar-presentacion', 'idEvento' => $evento->idEvento], ['class' => 'btn btn-primary']) ?>
    </p>

    <table class="table table-striped">
        <tbody>
            <tr>
                <th scope="col">Nombre</th>
                <td><?= $evento->nombreEvento ?></td>
            </tr>
            <tr>
                <th scope="col">Descripcion</th>
                <td><?= $evento->descripcionEvento ?></td>
            </tr>
            <tr>
                <th scope="col">Lugar</th>
                <td><?= $evento->lugar ?></td>
            </tr>
            <tr>
                <th scope="col">Fecha Inicio Evento</th>
                <td><?= $evento->fechaInicio ?></td>
            </tr>
            <tr>
                <th scope="col">Fecha Fin Evento</th>
                <td><?= $evento->fechaFin ?></td>
            </tr>
            <tr>
                <th scope="col">Modalidad</th>
                <td><?= $evento->modalidad ?></td>
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
                <th scope="col">Link Logo</th>
                <td><?= $logo ?></td>
            </tr>
            <tr>
                <th scope="col">Capacidad</th>
                <td><?= $evento->capacidad ?></td>
            </tr>
            <tr>
                <th scope="col">Preinscripcion</th>
                <td><?= $preIncripcion ?></td>
            </tr>
            <tr>
                <th scope="col">Fecha Límite </th>
                <td><?= $evento->fechaLimiteInscripcion ?></td>
            </tr>
            <tr>
                <th scope="col">Codigo Acreditación</th>
                <td><?= $codAcreditacion ?></td>
            </tr>
        </tbody>
    </table>
    <h2 class="text-center"><?= Html::encode('Presentaciones') ?></h2>
    <?php
    $cont = 0;
    foreach ($presentacion as $objPresentacion) :
        $cont++;
        $arrExpoPre = PresentacionExpositor::find()->where(['idPresentacion' => $objPresentacion->idPresentacion])->all();

    ?>



        <table class="table table-striped">
            <thead>
                <th scope="col">#</th>
                <th scope="col">Titulo Presentacion</th>
                <th scope="col">Descripcion Presentacion</th>
                <th scope="col">Hora Inicio Presentacion</th>
                <th scope="col">Hora Fin Presentacion</th>
                <th scope="col">Expositores</th>
            </thead>
            <tbody>
                <tr>
                    <th scope="row"><?= $cont ?></th>
                    <td><?= $objPresentacion->tituloPresentacion ?></td>
                    <td><?= $objPresentacion->descripcionPresentacion ?></td>
                    <td><?= $objPresentacion->horaInicioPresentacion ?></td>
                    <td><?= $objPresentacion->horaFinPresentacion ?></td>
                    <td>
                        <?php
                        foreach ($arrExpoPre as $objExpoPre) {
                            $objExpositor = Expositor::findOne($objExpoPre->idExpositor);
                            $objUsuario = Usuario::findOne($objExpositor->idUsuario); ?>
                            <ul>
                                <li><b>Nombre:</b><?= Html::encode($objUsuario->nombre . ", " . $objUsuario->apellido) ?></li>
                                <li><b>Contacto:</b><?= Html::encode($objUsuario->email) ?></li>
                            </ul>
                        <?php } ?>
                        <?= Html::a('Añadir Expositor', ['cargar-expositor', 'idPresentacion' => $objPresentacion->idPresentacion], ['class' => 'btn btn-primary']) ?>

                    </td>
                </tr>
            </tbody>
        </table>
    <?php endforeach; ?>
</div>