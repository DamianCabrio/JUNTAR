<?php

use yii\helpers\Html;
use yii\helpers\Url;
use frontend\models\PresentacionExpositor;
use backend\models\Usuario;

if ($model->imgFlyer != null) {
    $flyer = '<img  class="img-fluid" width="300px" src='.Url::base('').'/'.$model->imgFlyer.'>';
} else {
    $flyer = "(Flyer no cargado o en construcción)";
}
if ($model->imgLogo != null) {
    $logo = '<img class="img-fluid" style="width="auto"; max-height:150px;" src='.Url::base('').'/' . $model->imgLogo . '>';
} else {
    $logo = "(Logo no cargado o en construcción)";
}

if ($model->preInscripcion == 0) {
    $preInscripcion = "No requiere preinscipcion";
} else {
    $preInscripcion = "<b style='color:red;'>*Requiere preinscipcion*</b>";
}
if ($model->codigoAcreditacion != null) {
    $codAcreditacion = $model->codigoAcreditacion;
} else {
    $codAcreditacion = "Código no cargado o en construcción";
}


if ($model->fechaCreacionEvento != null) {
    $fechaPublicacion = $model->fechaCreacionEvento;
} else {
    $fechaPublicacion = "Evento no publicado";
}

if ($model->fechaLimiteInscripcion != null) {
    $fechaLimite = $model->fechaLimiteInscripcion;
} else {
    $fechaLimite = "No posee inscripción";
}


$categoriaEvento = $model->idCategoriaEvento0->descripcionCategoria;
$modalidadEvento = $model->idModalidadEvento0->descripcionModalidad;
$estadoEvento = $model->idEstadoEvento0->descripcionEstado;

$organizadorEvento = $model->idUsuario0->nombre." ".$model->idUsuario0->apellido;
$organizadorEmailEvento = $model->idUsuario0->email;

?>
<div class="container">
    <!--<h2 class="text-center">Su evento cargado</h2>-->
    <h2 class="text-center py-2 px-3 mt-4 mb-3 bg-info text-white"><?= $model->nombreEvento ?></h2>
	
	
    <!--<p class="text-center">Posee los siguientes datos</p>-->
	<div class="row">
		<div class="col-8">
			<div class="row">
				<div class="col-12 text-center">
					<?= $flyer ?>
				</div>
			</div>
			<div class="row">
				<div class="col-12">
					<h2 class="text-center mt-4 mb-3 py-2 px-3 mb-2 bg-info text-white">Descripción</h2>
					<div class="row my-4">
						<div class="col-12 text-center">
							<?= $logo ?>
						</div>
					</div>
					<?= $model->descripcionEvento ?>
				</div>
			</div>
		</div>
		<div class="col-4 p-4" style="background-color:#f2f2f2;">
			<div>
				<h4 class="py-2 px-3 mb-2 bg-primary text-white">Detalles</h4>
				<p><b>Fecha de Inicio:</b></p>
				<p><?= $model->fechaInicioEvento ?></p>
				<hr/>
				<p><b>Fecha de Fin:</b></p>
				<p><?= $model->fechaFinEvento ?></p>
				<hr/>
				<p><b>Lugar:</b></p>
				<p><?= $model->lugar ?></p>
				<hr/>
				<p><b>Modalidad:</b></p>
				<p><?= $modalidadEvento ?></p>
				<hr/>
				<p><b>Estado:</b></p>
				<p><?= $estadoEvento ?></p>
				<hr/>
			</div>
			<div>
				<h4 class="py-2 px-3 mb-2 bg-primary text-white">Pre-inscripcion</h4>
				<p><?= $preInscripcion ?></p>
				<hr/>
				<p><b>Fecha limite de Pre-inscripcion:</b></p>
				<p><?= $model->fechaLimiteInscripcion ?></p>
				<hr/>
			</div>
			<div>
				<h4 class="py-2 px-3 mb-2 bg-primary text-white">Organizador</h4>
				<p><?= $organizadorEvento ?></p>
				<hr/>
				<p><b>Contacto:</b></p>
				<p><?= $organizadorEmailEvento ?></p>
				<hr/>
			</div>
			<div>
				<h4 class="py-2 px-3 mb-2 bg-primary text-white">Codigo QR</h4>
				<p><?= $codAcreditacion ?></p>
				<hr/>
			</div>
			<div>
				<h4 class="py-2 px-3 mb-2 bg-primary text-white">Otros datos</h4>
				<p><b>Capacidad:</b></p>
				<p><?= $model->capacidad ?> Personas</p>
				<hr/>
				<p><b>Categoria:</b></p>
				<p><?= $categoriaEvento ?></p>
				<hr/>
				<p><b>Fecha de Publicacion:</b></p>
				<p><?= $fechaPublicacion ?></p>
				<hr/>
			</div>

        </div>
    </div>
        <h2 class="text-center mt-4 mb-3 py-2 px-3 bg-info text-white"><?= Html::encode('Agenda') ?></h2>
		<table class="table table-bordered" style="font-size: 0.8rem;">
			<thead>
				<th scope="col" class="text-center">#</th>
				<th scope="col" class="text-center">Título</th>
				<th scope="col" class="text-center">Descripción</th>
				<th scope="col" class="text-center">Día</th>
				<th scope="col" class="text-center">Hora Inicio </th>
				<th scope="col" class="text-center">Hora Fin </th>
				<th scope="col" class="text-center">Links a recursos </th>
				<th scope="col" class="text-center" colspan="2">Expositores</th>
			</thead>
			<tbody>
        <?php
        $cont = 0;
        foreach ($presentacion as $objPresentacion) :
            $cont++;
            $arrExpoPre = PresentacionExpositor::find()->where(['idPresentacion' => $objPresentacion->idPresentacion ])->all();
        ?>
			<tr>
				<th class="align-middle"><?= $cont ?></th>
				<td class="align-middle"><?= $objPresentacion->tituloPresentacion ?><br/><?= Html::a('(Más información)', ['presentacion/view', 'presentacion' => $objPresentacion->idPresentacion]) ?></td>
				<td class="align-middle"><?= $objPresentacion->descripcionPresentacion ?></td>
				<td class="align-middle"><?= $objPresentacion->diaPresentacion ?></td>
				<td class="align-middle"><?= $objPresentacion->horaInicioPresentacion ?></td>
				<td class="align-middle"><?= $objPresentacion->horaFinPresentacion ?></td>
				<td class="align-middle"><?= $objPresentacion->linkARecursos ?></td>
				<td class="align-middle">
					<?php
					foreach ($arrExpoPre as $objExpoPre) {
						$objUsuario = Usuario::findOne($objExpoPre->idExpositor); ?>
						<ul class="my-2">
							<li>Nombre: <?= Html::encode($objUsuario->nombre . ", " . $objUsuario->apellido) ?></li>
							<li>Contacto: <?= Html::encode($objUsuario->email) ?></li>
						</ul>
					<?php } ?>
				</td>
				<td class="align-middle"><?= Html::a('+', ['cargar-expositor', 'idPresentacion' => $objPresentacion->idPresentacion], ['class' => 'btn btn-outline-success btn-sm']) ?></td>
					   
				<?php endforeach; ?>
			</tr>
		</tbody>
	</table>    
</div>