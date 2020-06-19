<?php

use yii\bootstrap4\Html;
use yii\bootstrap4\Modal;
use yii\helpers\Url;
use frontend\models\PresentacionExpositor;
use frontend\models\Usuario;

$this->title = $evento->nombreCortoEvento . " - Juntar";

$openGraph = Yii::$app->opengraph;

$openGraph->getBasic()
	->setUrl(Yii::$app->request->hostInfo . Yii::$app->request->url)
	->setTitle(Html::encode($evento->nombreEvento))
	->setDescription(Html::encode(strtok(wordwrap($evento["descripcionEvento"], 100, "...\n"))))
	->setSiteName("Juntar")
	->setLocale('es_AR')
	->render();

$openGraph->useTwitterCard()
	->setCard('summary')
	->setSite(Yii::$app->request->hostInfo . Yii::$app->request->url)
	->setCreator(Html::encode($evento->idUsuario0->nombre . " " . $evento->idUsuario0->apellido))
	->render();

if ($evento->imgLogo != null) {
	$openGraph->getImage()
		->setUrl(Html::encode($evento->imgLogo))
		->setAttributes([
			'secure_url' => Html::encode($evento->imgLogo),
			'width'      => 100,
			'height'     => 100,
			'alt'        => "Logo Evento",
		])
		->render();
}

if ($evento->imgFlyer != null) {
	$flyer = '<img  class="full_width" src=' . Url::base('') . '/' . $evento->imgFlyer . '>';
} else {
	$flyer = "(Flyer no cargado o en construcción)";
}
if ($evento->imgLogo != null) {
	$logo = '<img class="full_width" src=' . Url::base('') . '/' . $evento->imgLogo . '>';
} else {
	$logo = "(Logo no cargado o en construcción)";
}

if ($evento->preInscripcion == 0) {
	$preInscripcion = "No requiere preinscipción";
} else {
	$preInscripcion = "<b style='color:#ff0000;'>*Requiere preinscipción*</b>";
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

$organizadorEvento = $evento->idUsuario0->nombre . " " . $evento->idUsuario0->apellido;
$organizadorEmailEvento = $evento->idUsuario0->email;
?>
<div class="evento-view ">
	<header class="hero gradient-hero">
		<div class="container-fluid center-content text-center padding_hero text-white">
			<h1 class="text-white text-uppercase"><?= $evento->nombreEvento ?></h1>
			<div class="row padding_section">
				<div class="col text-center">
					<h4 class="text-white"><?= $evento->fechaInicioEvento ?></h4>
					<h4><?= $evento->lugar ?></h4>
				</div>
			</div>
			<br>
			<a href="#evento" class="btn btn-primary btn-lg text-uppercase">VER</a>
		</div>
	</header>
<header class="hero gradient-hero">
	<div class="container-fluid center-content text-center padding_hero">
		<h1 class="text-white text-uppercase"><?= $evento->nombreEvento ?></h1>
		<br>
        <?php if(!$esFai): ?>
		<h5 class="text-white">Evento no organizado por la FAI</h5>
        <?php else: ?>
        <h5 class="text-white">Evento organizado por la FAI</h5>
        <?php endif; ?>
		<br>
		<a href="#evento" class="btn btn-primary btn-lg text-uppercase">VER</a>
	</div>
</header>

<div class="container-fluid darkish_bg padding_hero">
	<div class="row">
		<div class="col-12 col-md-6 text-center text-md-right">
			<h3 class="text-white">Inicio: <?= $evento->fechaInicioEvento ?></h3>
		</div>
		<div class="col-12 col-md-6 text-center text-md-left">
			<h3 class="text-white text-md-left">Fin: <?= $evento->fechaFinEvento ?></h3>
		</div>
		<div class="col-12 text-center">
			<h3 class="text-white">Lugar: <?= $evento->lugar ?></h3>
		</div>
		<div class="col-12 text-center">
            <?php if($esDueño): ?>
            <a href="<?= Url::toRoute(['/eventos/editar-evento/' . $evento->nombreCortoEvento]); ?>" class="btn btn-primary btn-lg text-uppercase editarEvento" data-id="<?= Url::toRoute(['/eventos/editar-evento/' . $evento->nombreCortoEvento]) ?>"> editar evento </a>
		    <?php endif; ?>
        </div>
	</div>

	<div id="evento" class="container-fluid padding_event darkish_bg">
		<div class="container">
			<div class="card bg-white">
				<?PHP
				if (!Yii::$app->user->isGuest) {
					echo '  <div class="card-header pinkish_bg"> ' . Html::a('<i class="material-icons large align-middle">edit</i>', ['/eventos/editar-evento/' . $evento->nombreCortoEvento], ['class' => 'text-light text-uppercase']) . '<span class="text-white align-middle"> Estado Evento ' . $estadoEvento . '</span> </div>';
				}
				?>
				<div class="card-body">
					<div class="row padding_section">
						<div class="col-sm-12 col-md-8">
							<div class="padding_section">
								<i class="material-icons align-middle">today</i><span class=" align-middle"> <?= $evento->fechaInicioEvento ?></span>
								<br>
								<br>
								<h2><strong><?= $evento->nombreEvento ?></strong>
								</h2>
								<br>
								<p>Organizado por <?= $organizadorEvento ?></p>
								<br>
								<a href="" data-toggle="modal" data-target="#exampleModal"><i class="material-icons align-middle">file_download</i><span class=" align-middle">Flyer </span></a>

							</div>
						</div>
						<div class="col-sm-12 col-md-4">
							<?= $logo ?>
						</div>
					</div>
					<div class="row padding_section greyish_bg">
						<div class="col-sm-12 col-md-8">
							<div class="">
								<p class="align-middle">CUPOS DISPONIBLES: <?= $cupos ?> <?= $preInscripcion ?></p>

							</div>
						</div>
						<div class="col-sm-12 col-md-4">
							<div class="align-middle">
								<?php
								switch ($estadoEventoInscripcion) {
									case "puedeInscripcion":
										echo Html::a('Inscribirse', ['inscripcion/preinscripcion', "slug" => $evento->nombreCortoEvento], ['class' => 'btn btn-primary']);
										break;
									case "puedePreinscripcion":
										echo Html::a('Pre-inscribirse', ['inscripcion/preinscripcion', "slug" => $evento->nombreCortoEvento], ['class' => 'btn btn-primary']);
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
										echo Html::a('Anular Pre-inscripcion', ['inscripcion/eliminar-inscripcion', "slug" => $evento->nombreCortoEvento], ['class' => 'btn btn-primary']);
										break;
									case "yaInscripto":
										echo Html::a('Anular Inscripcion', ['inscripcion/eliminar-inscripcion', "slug" => $evento->nombreCortoEvento], ['class' => 'btn btn-primary']);
										break;
									case "noInscriptoYFechaLimiteInscripcionPasada":
										echo Html::label('No se puede inscribir, el evento ya inicio');
										break;
									case "puedeAcreditarse":
										echo Html::a('Acreditación', ['acreditacion/acreditacion', "slug" => $evento->nombreCortoEvento], ['class' => 'btn btn-primary']);
										break;
								}
								Modal::begin([
									'id' => 'modalEvento',
									'size' => 'modal-lg'
								]);
								Modal::end();
								?>
							
							</div>

						</div>
					</div>
					<div class="row">
						<div class="col-sm-12 col-md-8 padding_section">
							<h4 class="text-uppercase">SOBRE ESTE EVENTO</h4>
							<br>
							<?= $evento->descripcionEvento ?>
							<br>
							<hr>
							<h5>Contacto del Organizador</h5>
							<?= $organizadorEmailEvento ?>


						</div>
						<div class="col-sm-12 col-md-4 padding_section">
							<ul class="list-group">
								<li class="list-group-item">
									<p><b>Fecha de Inicio: </b></p>
									<span><?= $evento->fechaInicioEvento ?></span>
								</li>
								<li class="list-group-item">
									<p><b>Fecha de Finalización: </b></p>
									<span><?= $evento->fechaFinEvento ?></span>
								</li>
								<li class="list-group-item">
									<p><b>Fecha Límite Pre-Inscripción: </b></p>
									<span><?= $evento->fechaLimiteInscripcion ?></span>
								</li>
								<li class="list-group-item">
									<p><b>Lugar: </b></p>
									<span><?= $evento->lugar ?></span>
								</li>
								<li class="list-group-item">
									<p><b>Modalidad: </b></p>
									<span><?= $modalidadEvento ?></span>
								</li>
								<li class="list-group-item">
									<p><b>Capacidad: </b></p>
									<span><?= $evento->capacidad ?></span>
								</li>
								<li class="list-group-item">
									<p><b>Fecha Pubilcación: </b></p>
									<span><?= $fechaPublicacion ?></span>
								</li>
							</ul>
						</div>
					</div>
					<div class="row padding_section grayish_bg">
						<div class="col-sm-12">
							<span class="align-middle">
								<h4 class="text-uppercase align-middle">AGENDA <?PHP
								if (!Yii::$app->user->isGuest) {
									echo Html::a('<i class="material-icons large align-middle">add</i>', ['/eventos/editar-evento/' . $evento->nombreCortoEvento], ['class' => '']);
								}
								?></h4>

							</span>

							<br>
							<div class="table-responsive">
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
												<td class="align-middle w-25"><?= $objPresentacion->tituloPresentacion ?><br /><?= Html::a('(Más información)', ['presentacion/view', 'presentacion' => $objPresentacion->idPresentacion]) ?></td>
												<!--<td class="align-middle"><?= $objPresentacion->descripcionPresentacion ?></td>-->
												<td class="align-middle"><?= $objPresentacion->diaPresentacion ?></td>
												<td class="align-middle"><?= $objPresentacion->horaInicioPresentacion ?></td>
												<td class="align-middle"><?= $objPresentacion->horaFinPresentacion ?></td>
												<?php
												if ($objPresentacion->linkARecursos == null || $objPresentacion->linkARecursos == "") {
												?>
													<td class="align-middle">No hay links para mostrar.</td>
												<?php } else { ?>
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
												if (!Yii::$app->user->isGuest && Yii::$app->user->identity->idUsuario == $evento->idUsuario0->idUsuario) { ?>
													<td class="align-middle">
														<div class="btn-group" role="group" aria-label="Basic example">
															<?= Html::a('<i class="material-icons">edit</i>', ['cargar-expositor', 'idPresentacion' => $objPresentacion->idPresentacion], ['class' => 'btn btn_icon btn-outline-success']) ?>
															<?= Html::a('<i class="material-icons">add</i>', ['cargar-expositor', 'idPresentacion' => $objPresentacion->idPresentacion], ['class' => 'btn btn_icon btn-outline-success']) ?>
															<?= Html::a('<i class="material-icons">remove_circle_outline</i>', ['cargar-expositor', 'idPresentacion' => $objPresentacion->idPresentacion], ['class' => 'btn btn_icon btn-outline-success']) ?>
														</div>

													</td>
												<?php } ?>
											<?php endforeach; ?>
											</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<?php if ($estadoEvento == 'Finalizado' and !Yii::$app->user->isGuest and $estadoEventoInscripcion == 'yaAcreditado'): ?>
          <h4 class="py-2 px-3 mb-2 bg-primary text-white">Certificado</h4>
            <?= $this->render('/certificado/index', [
              "evento" => $evento,
              'OrganizadorEmail' =>$organizadorEmailEvento,
              'categoria' => $categoriaEvento,
              'presentaciones' => $presentacion,
            ]); ?>

	<!-- Modal -->
	<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Flyer</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<?= $flyer ?>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
				</div>
			</div>
		</div>
	</div>
