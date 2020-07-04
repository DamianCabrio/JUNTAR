<?php

use yii\bootstrap4\Modal;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = "Crear Formulario";
?>

<div class="formulario-dinamico container">

    <?php if ($evento->idEstadoEvento != 1): ?>
        <?= Html::a("Agregar Pregunta", Url::toRoute(["eventos/crear-pregunta/" . $evento->nombreCortoEvento]),
            ['class' => 'btn btn-primary agregarPregunta mb-4', "data-id" => Url::toRoute(["eventos/crear-pregunta/" . $evento->nombreCortoEvento])]) ?>
    <?php else: ?>
        <h3>Los formularios no podran ser modificados una vez se publique el evento</h3>
    <?php endif; ?>

    <?=
    GridView::widget([
        "dataProvider" => $preguntas,
        'summary' => '',
        'options' => ['style' => 'width:100%;'],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'Tipo de pregunta',
                'format' => 'raw',
                'value' => function ($dataProvider) {
                    if ($dataProvider->tipo == 1) {
                        $retorno = "Respuesta Corta";
                    } else if ($dataProvider->tipo == 2) {
                        $retorno = "Respuesta Larga";
                    } else if ($dataProvider->tipo == 3) {
                        $retorno = "Subir Archivo";
                    }
                    return $retorno;
                },
                'headerOptions' => ['style' => 'width:30%;text-align:center;'],
            ],
            [
                'attribute' => 'Respuesta',
                'format' => 'raw',
                'value' => function ($dataProvider) {
                    return $dataProvider->descripcion;
                },
                'headerOptions' => ['style' => 'width:30%;text-align:center;'],
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                //genera una url para cada boton de accion
                'urlCreator' => function ($action, $model, $key, $index) use ($evento) {
                    if ($action == "update") {
                        return Url::to(['eventos/editar-pregunta/' . $evento->nombreCortoEvento . "/" . $key]);
                    }
                    if ($action == "delete") {
                        return Url::to(['eventos/eliminar-pregunta/' . $evento->nombreCortoEvento . "/" . $key]);
                    }
                },
                //describe los botones de accion
                'buttons' => [
                    'update' => function ($url, $model) use ($evento) {
                        if ($evento->idEstadoEvento != 1):
//                                                    return Html::a('<img src="' . Yii::getAlias('@web/icons/pencil.svg') . '" alt="Editar" width="20" height="20" title="Editar" role="img">', $url, ['class' => 'btn editarPresentacion']);
                            return Html::a('<i class="material-icons">edit</i>', $url, ['class' => 'btn btn_icon btn-outline-success editarPregunta']);
                        endif;
                        return "No disponible";
                    },
                    'delete' => function ($url, $model) use ($evento) {
                        if ($evento->idEstadoEvento != 1):
                            return Html::button('<i class="material-icons">remove_circle_outline</i>', ['class' => 'btn btn_icon btn-outline-success borrarPregunta', 'data-toggle' => "modal", "data-target" => "#modalEliminar"])
                                . '<div class="modal fade" id="modalEliminar" tabindex="-1" role="dialog">
                                      <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                          <div class="modal-header">
                                            <h5 class="modal-title" id="modalEliminarLabel">¿Esta seguro que quiere eliminar esta pregunta?</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                              <span aria-hidden="true">&times;</span>
                                            </button>
                                          </div>
                                          <div class="modal-body">
                                            Al eliminar una pregunta todas las respuestas de la misma tambien seran eliminadas
                                          </div>
                                          <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>'.
                                            Html::a("Eliminar", $url, ["class" => "btn btn-outline-success borrarPregunta", "data-method" => "POST"])
                                          .'</div>
                                        </div>
                                      </div>
                                    </div>';
                        endif;
                        return "";
                    }
                ],
                'header' => 'Acciones',
                'headerOptions' => ['style' => 'text-align:center;'],
                'contentOptions' => ['style' => 'text-align:center; vertical-align:middle;'],
            ],
        ]
    ]);
    ?>

    <?= Html::a('Volver Atras', Url::toRoute("eventos/ver-evento/" . $evento->nombreCortoEvento), ['class' => 'btn btn-outline-success']); ?>

    <?php
    Modal::begin([
        'id' => 'modalPregunta',
        'size' => 'modal-lg'
    ]);
    Modal::end();
    ?>

</div>