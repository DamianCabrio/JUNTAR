<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\bootstrap4\Modal;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
?>
<div class="container">
    <div class="expositores-lista">


        <h1>
            <?php
            $cadenaAgregar = "";
            if (!Yii::$app->user->isGuest && $model->idEvento0->idUsuario == Yii::$app->user->identity->idUsuario) {
                if ($evento->idEstadoEvento == 1 || $evento->idEstadoEvento == 4 || $evento->idEstadoEvento == 3) {
                    //$cadenaAgregar = Html::a('<b class="material-icons large align-middle">person_add</b><i> Cargar Expositor</i>', ['/evento/cargar-expositor', 'idPresentacion' => $model->idPresentacion], ['class' => 'btn cargarExpositores']);
                }
            }
            ?>
            <?= $model->tituloPresentacion . '<br> ' . $cadenaAgregar; ?>
        </h1>

        <div class="table-responsive">
            <?=
                GridView::widget([
                    'dataProvider' => $dataProvider,
                    'summary' => '',
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        //'idExpositor',
                        [
                            'attribute' => 'Nombre',
                            'format' => 'raw',
                            'value' => function ($dataProvider) {
                                return $dataProvider->idExpositor0->nombre . ' ' . $dataProvider->idExpositor0->apellido;
                            },
                            'headerOptions' => ['style' => 'width:40%;text-align:center;'],
                        ],
                        //'idPresentacion',
                        [
                            'attribute' => 'Contacto',
                            'format' => 'raw',
                            'value' => function ($dataProvider) {
                                return $dataProvider->idExpositor0->email;
                            },
                            'headerOptions' => ['style' => 'width:40%;text-align:center;'],
                        ],
                        //['class' => 'yii\grid\ActionColumn'],
                        [
                            'class' => 'yii\grid\ActionColumn',
                            //genera una url para cada evento
                            'urlCreator' => function ($action, $model, $key, $index) {
                                if ($action == "delete") {
                                    /*
            ?>
                    <div class="modal fade" id="myModal" style="background:#00000082;">
                        <div class="modal-dialog" style="margin-top: 5rem;">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title"></h4>
                                </div>
                                <div class="container"></div>
                                <div class="modal-body">
                                    <p>¿Está seguro de querer borrar este expositor?</p>
                                </div>
                                <div class="modal-footer">
                                    <a href="<? //= Url::to(['presentacion-expositor/delete', 'idPresentacion' => $key['idPresentacion'], 'idExpositor' => $key['idExpositor']]); ?>" class="btn btn-primary">Si</a>
                                    <a href="#" data-dismiss="modal" class="btn">No</a>
                                </div>
                            </div>
                        </div>
                    </div>
            <?php
            */

                                    return Url::to(['presentacion-expositor/delete', 'idPresentacion' => $key['idPresentacion'], 'idExpositor' => $key['idExpositor']]);
                                    //return Url::to(['#']);
                                }
                            },
                            //describe los botones de accion
                            'buttons' => [
                                'delete' => function ($url, $model) {
                                    return Html::a('<i class="material-icons large align-middle">remove_circle_outline</i>', $url, ['class' => 'btn verPresentacion', 'data-toggle' => 'modal', 'href' => '#myModal', 'data' => [
                                                'confirm' => 'Esta seguro que desea Borrar el Expositor?',
                                                'method' => 'post',
                                            ]]);
                                },
                            ],
                            'visible' => !Yii::$app->user->isGuest && $model->idEvento0->idUsuario == Yii::$app->user->identity->idUsuario && ($evento->idEstadoEvento == 1 || $evento->idEstadoEvento == 4 || $evento->idEstadoEvento == 3),
                            'header' => 'Acciones',
                            'headerOptions' => ['style' => 'text-align:center;'],
                            'contentOptions' => ['style' => 'text-align:center; vertical-align:middle;'],
                        ],
                    ],
                ]);
            Modal::begin([
                'id' => 'modalEvento',
                'size' => 'modal-lg'
            ]);
            Modal::end();
            ?>

        </div>
    </div>


</div>
