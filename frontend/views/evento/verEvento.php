<?php

use yii\bootstrap4\Html;
use yii\helpers\Url;
use frontend\models\PresentacionExpositor;
use frontend\models\Usuario;

if ($evento->imgFlyer != null) {
    $flyer = '<img  class="img-fluid" width="300px" src='.Url::base('').'/'.$evento->imgFlyer.'>';
} else {
    $flyer = "(Flyer no cargado o en construcción)";
}
if ($evento->imgLogo != null) {
    $logo = '<img class="img-fluid" style="width="auto"; max-height:150px;" src='.Url::base('').'/' . $evento->imgLogo . '>';
} else {
    $logo = "(Logo no cargado o en construcción)";
}

if ($evento->preInscripcion == 0) {
    $preInscripcion = "No requiere preinscipcion";
} else {
    $preInscripcion = "<b style='color:#ff0000;'>*Requiere preinscipcion*</b>";
}
if ($evento->codigoAcreditacion != null) {
    $codAcreditacion = $evento->codigoAcreditacion;
} else {
    $codAcreditacion = "Código no cargado o en construcción";
}


if ($evento->fechaCreacionEvento != null) {
    $fechaPublicacion = $evento->fechaCreacionEvento;
} else {
    $fechaPublicacion = "Evento no publicado";
}

if ($evento->fechaLimiteInscripcion != null) {
    $fechaLimite = $evento->fechaLimiteInscripcion;
} else {
    $fechaLimite = "No posee inscripción";
}


$categoriaEvento = $evento->idCategoriaEvento0->descripcionCategoria;
$modalidadEvento = $evento->idModalidadEvento0->descripcionModalidad;
$estadoEvento = $evento->idEstadoEvento0->descripcionEstado;

$organizadorEvento = $evento->idUsuario0->nombre." ".$evento->idUsuario0->apellido;
$organizadorEmailEvento = $evento->idUsuario0->email;

?>
<div class="evento-view container">
    <!--<h2 class="text-center">Su evento cargado</h2>-->
    <h2 class="text-center py-2 px-3 mt-4 mb-3 bg-info text-white"><?= $evento->nombreEvento ?></h2>

    <h1><?= Html::encode($this->title) ?></h1>
    <h1><?= Html::encode('Cupos restantes:'.$cupos) ?></h1>

    <p>
        <?php
        if (!Yii::$app->user->can('Administrador')) {
            Html::a('Update', ['update', 'id' => $evento->idEvento], ['class' => 'btn btn-primary']);
            Html::a('Delete', ['delete', 'id' => $evento->idEvento], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ]);
        } ?>
        <?php

        switch ($estadoEventoInscripcion){
            case "puedeInscripcion":
                echo Html::a('Inscribirse', ['inscripcion/preinscripcion', 'id' => $evento->idEvento], ['class' => 'btn btn-primary']);
                break;
            case "puedePreinscripcion":
                echo Html::a('Pre-inscribirse', ['inscripcion/preinscripcion', 'id' => $evento->idEvento], ['class' => 'btn btn-primary']);
                break;
            case "sinCupos":
                echo Html::label('Sin cupos');
                break;
            case "yaAcreditado":
                echo Html::label("Usted ya se acredito en este evento");
                break;
            case "inscriptoYEventoIniciado":
                echo Html::label("El evento ya inicio, pasela bien");
                break;
            case "yaPreinscripto":
                echo Html::a('Anular Pre-inscripcion', ['inscripcion/eliminar-inscripcion', 'id' => $evento->idEvento], ['class' => 'btn btn-primary']);
                break;
            case "yaInscripto":
                echo Html::a('Anular Inscripcion', ['inscripcion/eliminar-inscripcion', 'id' => $evento->idEvento], ['class' => 'btn btn-primary']);
                break;
            case "noInscriptoYFechaLimiteInscripcionPasada":
                echo Html::label('No se puede inscribir, el evento ya inicio');
                break;
            case "puedeAcreditarse":
                echo Html::a('Acreditación', ['acreditacion/acreditacion', 'id' => $evento->idEvento], ['class' => 'btn btn-primary']);
                break;
        }

        ?>
	
    <!--<p class="text-center">Posee los siguientes datos</p>-->
	<div class="row">
		<div class="col-12 col-md-8">
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
					<?= $evento->descripcionEvento ?>
				</div>
			</div>
		</div>
		<div class="col-12 col-md-4 p-4" style="background-color:#f2f2f2;">
			<div>
				<h4 class="py-2 px-3 mb-2 bg-primary text-white">Detalles</h4>
				<p><b>Fecha de Inicio:</b></p>
				<p><?= $evento->fechaInicioEvento ?></p>
				<hr/>
				<p><b>Fecha de Fin:</b></p>
				<p><?= $evento->fechaFinEvento ?></p>
				<hr/>
				<p><b>Lugar:</b></p>
				<p><?= $evento->lugar ?></p>
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
				<p><?= $evento->fechaLimiteInscripcion ?></p>
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
				<p><?= $evento->capacidad ?> Personas</p>
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
				<th scope="col" class="text-center w-25">Título</th>
				<!--<th scope="col" class="text-center">Descripción</th>-->
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
        ?>
			<tr>
				<th class="align-middle"><?= $cont ?></th>
				<td class="align-middle w-25"><?= $objPresentacion->tituloPresentacion ?><br/><?= Html::a('(Más información)', ['presentacion/view', 'presentacion' => $objPresentacion->idPresentacion]) ?></td>
				<!--<td class="align-middle"><?= $objPresentacion->descripcionPresentacion ?></td>-->
				<td class="align-middle"><?= $objPresentacion->diaPresentacion ?></td>
				<td class="align-middle"><?= $objPresentacion->horaInicioPresentacion ?></td>
				<td class="align-middle"><?= $objPresentacion->horaFinPresentacion ?></td>
				<?php
				if($objPresentacion->linkARecursos == null || $objPresentacion->linkARecursos == ""){
					?>
					<td class="align-middle">No hay links para mostrar.</td>
					<?php }
				else { ?>
					<td class="align-middle"><a href="<?= $objPresentacion->linkARecursos ?>">Link</a></td>
				<?php } ?>
				<td class="align-middle">
					<?php
					foreach ($objPresentacion->presentacionExpositors as $objExpoPre) {
						$objUsuario = $objExpoPre->idExpositor0 ?>
						<ul class="my-2">
							<li>Nombre: <?= Html::encode($objUsuario->nombre . ", " . $objUsuario->apellido) ?></li>
							<li>Contacto: <?= Html::encode($objUsuario->email) ?></li>
						</ul>
					<?php } ?>
				</td>
				
				<?php 
				if(!Yii::$app->user->isGuest && Yii::$app->user->identity->idUsuario == $evento->idUsuario0->idUsuario){ ?>
					<td class="align-middle"><?= Html::a('+', ['cargar-expositor', 'idPresentacion' => $objPresentacion->idPresentacion], ['class' => 'btn btn-outline-success btn-sm']) ?></td>
				<?php } ?>
					   
				<?php endforeach; ?>
			</tr>
		</tbody>
	</table>    
</div>
