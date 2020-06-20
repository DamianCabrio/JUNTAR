<?php

use yii\bootstrap4\Html;
use yii\bootstrap4\Modal;
use yii\helpers\Url;
use yii\grid\GridView;
use frontend\models\PresentacionExpositor;
use frontend\models\Usuario;

if ($evento->imgFlyer != null) {
    $flyer = '<img  class="img-fluid" width="300px" src=' . Url::base('') . '/' . $evento->imgFlyer . '>';
} else {
    $flyer = "(Flyer no cargado o en construcción)";
}
if ($evento->imgLogo != null) {
    $logo = '<img class="img-fluid" style="width="auto"; max-height:150px;" src=' . Url::base('') . '/' . $evento->imgLogo . '>';
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

$organizadorEvento = $evento->idUsuario0->nombre . " " . $evento->idUsuario0->apellido;
$organizadorEmailEvento = $evento->idUsuario0->email;
?>
<div class="evento-view container">
    <!--<h2 class="text-center">Su evento cargado</h2>-->
    <h2 class="text-center py-2 px-3 mt-4 mb-3 bg-info text-white"><?= $evento->nombreEvento ?></h2>

    <h1><?= Html::encode($this->title) ?></h1>
    <h1><?= Html::encode('Cupos restantes:' . $cupos) ?></h1>

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
        }
        ?>
        <?php
        switch ($estadoEventoInscripcion) {
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
        <?php
        Modal::begin([
            'id' => 'modalEvento',
            'size' => 'modal-lg'
        ]);
        Modal::end();
        ?>

        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-end">
                    <?php
                    if (!Yii::$app->user->isGuest && $evento->idUsuario == Yii::$app->user->identity->idUsuario) {

                       if($evento->idEstadoEvento == 3){
                       ?>

                        <div class="text-center">
                             <p>Evento Finalizado</p>
                        </div>
                       <?php 
                       }
                       else{ 
                            if (($evento->idEstadoEvento) == 4) {
                            ?>
                                <?= Html::a('Publicar', ['eventos/publicar-evento/' . $evento->nombreCortoEvento], ['class' => 'btn btn-outline-success btn-sm']) ?>
                            <?php } ?>

                            <?php
                            if (($evento->idEstadoEvento) == 1) {
                            ?>
                                <?= Html::a('Suspender', ['eventos/despublicar-evento/' . $evento->nombreCortoEvento], ['class' => 'btn btn-outline-danger btn-sm']) ?>
                            <?php
                            }
                            ?>
                            <?= Html::a('Editar', ['eventos/editar-evento/' .  $evento->nombreCortoEvento], ['class' => 'btn btn-outline-success btn-sm']) ?>
                        <?php
                        }
                    }
                    ?>
                </div>
                <div>
                </div>

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
                            <hr />
                            <p><b>Fecha de Fin:</b></p>
                            <p><?= $evento->fechaFinEvento ?></p>
                            <hr />
                            <p><b>Lugar:</b></p>
                            <p><?= $evento->lugar ?></p>
                            <hr />
                            <p><b>Modalidad:</b></p>
                            <p><?= $modalidadEvento ?></p>
                            <hr />
                            <p><b>Estado:</b></p>
                            <p><?= $estadoEvento ?></p>
                            <hr />
                        </div>
                        <div>
                            <h4 class="py-2 px-3 mb-2 bg-primary text-white">Pre-inscripcion</h4>
                            <p><?= $preInscripcion ?></p>
                            <hr />
                            <p><b>Fecha limite de Pre-inscripcion:</b></p>
                            <p><?= $evento->fechaLimiteInscripcion ?></p>
                            <hr />
                        </div>
                        <div>
                            <h4 class="py-2 px-3 mb-2 bg-primary text-white">Organizador</h4>
                            <p><?= $organizadorEvento ?></p>
                            <hr />
                            <p><b>Contacto:</b></p>
                            <p><?= $organizadorEmailEvento ?></p>
                            <hr />
                        </div>
                        <div>
                            <h4 class="py-2 px-3 mb-2 bg-primary text-white">Codigo QR</h4>
                            <p><?= $codAcreditacion ?></p>
                            <hr />
                        </div>
                        <div>
                            <h4 class="py-2 px-3 mb-2 bg-primary text-white">Otros datos</h4>
                            <p><b>Capacidad:</b></p>
                            <p><?= $evento->capacidad ?> Personas</p>
                            <hr />
                            <p><b>Categoria:</b></p>
                            <p><?= $categoriaEvento ?></p>
                            <hr />
                            <p><b>Fecha de Publicacion:</b></p>
                            <p><?= $fechaPublicacion ?></p>
                            <hr />
                        </div>

                    </div>
                </div>
				<div class="row padding_section grayish_bg">
				<span class="align-middle">
					<h4 class="text-uppercase align-middle">AGENDA
						<?php
						if (!Yii::$app->user->isGuest && $evento->idUsuario == Yii::$app->user->identity->idUsuario) {
							echo Html::a('<i class="material-icons large align-middle">add</i>', ['/presentacion/cargar-presentacion/' . $evento->nombreCortoEvento], ['class' => 'agregarPresentacion']);
						}
						?></h4>

								</span>
                <!--
        <table class="table table-bordered" style="font-size: 0.8rem;">
        <thead>
        <th scope="col" class="text-center">#</th>
        <th scope="col" class="text-center w-25">Título</th>
        <th scope="col" class="text-center">Descripción</th>
        <th scope="col" class="text-center">Día</th>
        <th scope="col" class="text-center">Hora Inicio </th>
        <th scope="col" class="text-center">Hora Fin </th>
        <th scope="col" class="text-center">Links a recursos </th>
        <th scope="col" class="text-center" colspan="2">Expositores</th>
        </thead>
        <tbody>
    -->
                <?=
                    GridView::widget([
                        'dataProvider' => $dataProvider,
                        //                        'filterModel' => $searchModel,
                        'options' => ['style' => 'width:100%;'],
                        'columns' => [
                            [
				    'class' => 'yii\grid\SerialColumn',
				    'contentOptions' => ['style' => 'text-align:center; vertical-align:middle;'],
			    ],
                            //'idPresentacion',
                            //'tituloPresentacion',
                            [
                                'attribute' => 'Titulo',
                                'format' => 'raw',
                                'value' => function ($dataProvider) {
                                    return $dataProvider->tituloPresentacion . ' <br/><small>'.Html::a('(Más información)', [Url::to(['presentacion/view', 'presentacion' => $dataProvider->idPresentacion])], ['class' => 'verPresentacion']).'</small>'; //<a href="' . Url::to(['presentacion/view', 'presentacion' => $dataProvider->idPresentacion, 'class' => 'verPresentacion']) . '">(Más información)</a>
                                },
                                'headerOptions' => ['style' => 'width:30%;text-align:center;'],
                            ],
                            //'diaPresentacion',
                            [
                                'attribute' => 'Dia',
                                'value' => function ($dataProvider) {
                                    $fechaConBarras = date('d/m/Y', strtotime($dataProvider->diaPresentacion));
                                    return $fechaConBarras;
                                },
                                'headerOptions' => ['style' => 'text-align:center;'],
                                'contentOptions' => ['style' => 'text-align:center; vertical-align:middle;'],
                            ],
                            //'horaInicioPresentacion',
                            [
                                'attribute' => 'Hora de Inicio',
                                'value' => function ($dataProvider) {
                                    $horaSinSegundos = date('H:i', strtotime($dataProvider->horaInicioPresentacion));
                                    return $horaSinSegundos;
                                },
                                'headerOptions' => ['style' => 'text-align:center;'],
                                'contentOptions' => ['style' => 'text-align:center; vertical-align:middle;'],
                            ],
                            //'horaFinPresentacion',
                            /* [
                                'attribute' => 'Hora de Fin',
                                'value' => function ($dataProvider) {
                                    $horaSinSegundos = date('H:i', strtotime($dataProvider->horaFinPresentacion));
                                    return $horaSinSegundos;
                                },
                                'headerOptions' => ['style' => 'text-align:center;'],
                                'contentOptions' => ['style' => 'text-align:center; vertical-align:middle;'],
                            ], */
                            //'linkARecursos',
                            [
                                'attribute' => 'Recursos',
                                'format' => 'raw',
                                'value' => function ($dataProvider) {
                                    //HACER IF
                                    if ($dataProvider->linkARecursos == null || $dataProvider->linkARecursos == "") {
                                        $retorno = '-';
                                    } else {
                                        $retorno = '<a href="' . $dataProvider->linkARecursos . '">Link</a>';
                                    }
                                    return $retorno;
                                },
                                'headerOptions' => ['style' => 'text-align:center;'],
                                'contentOptions' => ['style' => 'text-align:center; vertical-align:middle;'],
                            ],
                            //'expositores',
							[
                                'attribute' => 'Expositores',
                                'format' => 'raw',
                                'value' => function ($dataProvider) {
                                    //HACER IF
									if(count($dataProvider->presentacionExpositors) == 0){
										$string = "No hay expositores";
										if(!Yii::$app->user->isGuest && $dataProvider->idEvento0->idUsuario == Yii::$app->user->identity->idUsuario){
											$string .= ' '.Html::a('<i class="material-icons large align-middle">add</i>', [Url::to(['evento/cargar-expositor', 'idPresentacion' => $dataProvider->idPresentacion])], ['class' => 'agregarExpositor']);
										}
									}
									else{
										$string = '<a class="verExpositores" href="/presentacion-expositor/ver-expositores?idPresentacion='.$dataProvider->idPresentacion.'">Ver Expositores</a>';
											/* $string .='<div class="ver-expositores ">
											<table class="table">
												<thead>
													<th>Nombre</th>
													<th>Contacto</th>
												</thead>
												<tbody>';
										foreach ($dataProvider->presentacionExpositors as $objExpoPre) {
											$objUsuario = $objExpoPre->idExpositor0; 
											//$string .= '<ul class="my-2"><li>Nombre:'.Html::encode($objUsuario->nombre . ", " . $objUsuario->apellido).'</li><li>Contacto:'.Html::encode($objUsuario->email).'</li></ul>';
											$string .= '<td>'.$objUsuario->nombre . ', ' . $objUsuario->apellido.'</td><td>'.$objUsuario->email.'</td>';
										 }
										 $string .= '</tbody>
											</table>
											</div>'; */
									}
									return $string;
								},
                                'headerOptions' => ['style' => 'text-align:center;'],
                                'contentOptions' => ['style' => 'text-align:center; vertical-align:middle;'],
                            ],
							
                            [
                                'class' => 'yii\grid\ActionColumn',
                                //genera una url para cada evento
                                'urlCreator' => function ($action, $model, $key, $index) {
                                    if ($action == "update") {
                                        return Url::to(['presentacion/update', 'presentacion' => $key]);
                                    }
                                    if ($action == "delete") {
                                        return Url::to(['presentacion/borrar', 'presentacion' => $key]);
                                    }
									// if ($action == "view") {
                                        // return Url::to(['evento/cargar-expositor', 'idPresentacion' => $key]);
                                    // }
                                },
                                //describe los botones de accion
                                'buttons' => [
                                    'update' => function ($url, $model) {
                                        return Html::a('<i class="material-icons large align-middle">edit</i>', $url, ['class' => 'btn editarPresentacion']);
                                    },
                                    'delete' => function ($url, $model) {
                                        return Html::a('<i class="material-icons large align-middle">delete</i>', $url, ['class' => 'btn borrarPresentacion']);
                                    },
									// 'view' => function ($url, $model) {
                                        // return Html::a('<img src="' . Yii::getAlias('@web/icons/trash.svg') . '" alt="Borrar" width="20" height="20" title="Borrar" role="img">', $url, ['class' => 'btn agregarExpositor']);
                                    // },
                                ],
				'visible' => !Yii::$app->user->isGuest && $evento->idUsuario == Yii::$app->user->identity->idUsuario,
                                'header' => 'Acciones',
                                'headerOptions' => ['style' => 'text-align:center;'],
                                'contentOptions' => ['style' => 'text-align:center; vertical-align:middle;'],
                            ],
                        ],
                    ]);
                ?>
				</div>
                <!--</tr>
</tbody>
</table> -->
            </div>
        </div>
</div>
