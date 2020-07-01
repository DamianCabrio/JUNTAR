<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Evento */

$this->title = $model->nombreEvento;
$this->params['breadcrumbs'][] = ['label' => 'Eventos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="evento-view">
    <div class="row">
        <div class="col-12 mb-4">
            <div class="card">
                <h1 class="card-header text-center darkish_bg text-white"> <?= Html::encode($this->title) ?></h1>

                <div class="m-3">
                    <?= Html::a('Actualizar', ['update', 'id' => $model->idEvento], ['class' => 'btn btn-pink mb-2 col-md-2 col-sm-12']) ?>
                    <?php
                    if ($model->idEstadoEvento0->descripcionEstado == "Activo") {
                        echo Html::a('Deshabilitar', ['deshabilitar', 'id' => $model->idEvento], [
                            'class' => 'btn btn-pink mb-2 col-md-2 col-sm-12',
                            'data' => ['confirm' => '¿Está seguro de querer deshabilitar este evento?'],]);
                    } else {
                        if ($model->idEstadoEvento0->descripcionEstado == "inhabilitado") {
                            echo Html::a('Habilitar', ['habilitar', 'id' => $model->idEvento], [
                                'class' => 'btn btn-primary mb-2 col-md-2 col-sm-12',
                                'data' => ['confirm' => '¿Está seguro de querer habilitar este evento?'],]);
                        }
                    }
                    ?>
                    <?php
//                        print_r($aval);
                    if ($aval != null && $aval != '') {
                        if ($aval->avalado != 1) {
                            echo Html::a('Conceder aval FAI', ['solicitud-aval/conceder-aval', 'id' => $model->idEvento], [
                                'class' => 'btn btn-primary mb-2 col-md-2 col-sm-12',
                                'data' => ['confirm' => '¿Está seguro de querer conceder el aval de la FAI para este evento?'],
                            ]);
                        } else {
                            echo Html::a('Quitar aval FAI', ['solicitud-aval/quitar-aval', 'id' => $model->idEvento], [
                                'class' => 'btn btn-pink mb-2 col-md-2 col-sm-12',
                                'data' => ['confirm' => '¿Está seguro de querer quitar el aval de la FAI para este evento?'],
                            ]);
                        }
                    }
                    ?>
                </div>

                <div class="card-body">

                    <?=
                    DetailView::widget([
                        'model' => $model,
                        'attributes' => [
//            'idEvento',
                            [
                                'attribute' => 'avalado',
                                'label' => 'Aval FAI',
                                'value' => function ($model) use ($aval) {
                                    if ($aval != null && $aval != '') {
                                        return (($aval->avalado == 1) ? "Concedido" : "Denegado");
                                    }else{
                                        return "No fue solicitado";
                                    }
                                },
                            ],
                            [
                                'attribute' => 'idUsuario',
                                'label' => 'Organizador',
                                //formato raw para poder crear un enlace al organizador
                                'format' => 'raw',
                                'value' => function($model) {
                                    return Html::a($model->idUsuario0->nombre . ' ' . $model->idUsuario0->apellido, ['/usuario/view', 'id' => $model->idUsuario], ['class' => '']);
                                },
                            ],
                            [
                                'attribute' => 'idCategoriaEvento',
                                'label' => 'Categoria',
                                'value' => $model->idCategoriaEvento0->descripcionCategoria, //valor referenciado por ActiveQuery
                            ],
                            [
                                'attribute' => 'idEstadoEvento',
                                'label' => 'Estado',
                                'value' => $model->idEstadoEvento0->descripcionEstado, //valor referenciado por ActiveQuery
                            ],
                            [
                                'attribute' => 'idModalidadEvento',
                                'label' => 'Modalidad',
                                'value' => $model->idModalidadEvento0->descripcionModalidad, //valor referenciado por ActiveQuery
                            ],
                            'nombreEvento',
                            'nombreCortoEvento',
                            'descripcionEvento',
                            'lugar',
                            'fechaInicioEvento',
                            'fechaFinEvento',
                            'imgFlyer',
                            'imgLogo',
                            'capacidad',
                            [
                                'attribute' => 'preInscripcion',
                                'label' => 'Pre-Inscripcion',
                                'value' => function ($dataProvider) {
                                    return ($dataProvider->preInscripcion == 0 ? 'No' : 'Si');
                                },
                            ],
//            'preInscripcion',
                            'fechaLimiteInscripcion',
                            'codigoAcreditacion',
                            'fechaCreacionEvento',
                            'eventoToken',
                        ],
                    ])
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
