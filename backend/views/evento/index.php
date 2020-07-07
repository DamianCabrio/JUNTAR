<?php

use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\EventoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Eventos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="evento-index">

    <div class="row">
        <div class="col-12 mb-4">
            <div class="card">
                <h1 class="card-header text-center darkish_bg text-white"> <?= Html::encode($this->title) ?> </h1>

                <?php // echo Html::a('Crear Evento', ['create'], ['class' => 'btn btn-pink mt-3 ml-3 col-2'])   ?>

                <div class="card-body">
                    <div class="table-responsive">

                        <?=
                        GridView::widget([
                            'dataProvider' => $dataProvider,
                            'filterModel' => $searchModel,
                            'columns' => [
                                ['class' => 'yii\grid\SerialColumn'],
                                [
                                    'attribute' => 'nombreEvento',
                                    'label' => 'Título',
                                    'value' => 'nombreEvento',
                                ],
                                [
                                    'attribute' => 'nombreUsuario',
                                    'label' => 'Organizador',
                                    'format' => 'raw',
                                    'value' => function ($dataProvider) {
                                        return Html::a($dataProvider->idUsuario0->nombre . ' ' . $dataProvider->idUsuario0->apellido,
                                                        ['/usuario/view', 'id' => $dataProvider->idUsuario],
                                                        ['class' => '']);
                                    }
                                ],
                                [
                                    'attribute' => 'lugar',
                                    'label' => 'Lugar',
                                    'value' => 'lugar',
                                ],
                                [
                                    'attribute' => 'fechaCreacionEvento',
                                    'label' => 'Fecha Creación',
                                    'value' => function($dataProvider) {
                                        if ($dataProvider->fechaCreacionEvento != null && $dataProvider->fechaCreacionEvento != '') {
                                            return date("d-m-Y", strtotime($dataProvider->fechaCreacionEvento));
                                        } else {
                                            return $dataProvider->fechaCreacionEvento;
                                        }
                                    }
                                ],
                                [
                                    'attribute' => 'fechaInicioEvento',
                                    'label' => 'Fecha Inicio',
                                    'value' => function($dataProvider) {
                                        if ($dataProvider->fechaInicioEvento != null && $dataProvider->fechaInicioEvento != '') {
                                            return date("d-m-Y", strtotime($dataProvider->fechaInicioEvento));
                                        } else {
                                            return '';
                                        }
                                    }
                                ],
                                [
                                    'attribute' => 'capacidad',
                                    'label' => 'Capacidad',
                                    'value' => 'capacidad',
                                ],
                                [
                                    'attribute' => 'preInscripcion',
                                    'label' => 'Pre-Inscripcion',
                                    'value' => function ($dataProvider) {
                                        return ($dataProvider->preInscripcion == 0 ? 'No' : 'Si');
                                    },
                                ],
                                [
                                    'attribute' => 'avalado',
                                    'label' => 'Aval FAI',
                                    'value' => function ($dataProvider) {
                                        if ($dataProvider->idAval0 != null && $dataProvider->idAval0 != '') {
                                            return (($dataProvider->idAval0->avalado == 1) ? "Concedido" : "Denegado");
                                        } else {
                                            return "No Solicitado";
                                        }
                                    },
                                ],
                                ['class' => 'yii\grid\ActionColumn',
                                    'buttons' => [
                                        'view' => function ($url, $model) {
                                            return Html::a('<img class="filter-white" src="' . Yii::getAlias('@web/iconos/eye.svg') . '" alt="Visualizar" width="20" height="20" title="Visualizar" role="img">', $url, ['class' => 'btn btn-pink']);
                                        },

                                        'update' => function($url, $model) {
                                            return Html::a('<img class="filter-white" src="' . Yii::getAlias('@web/iconos/pencil.svg') . '" alt="Editar" width="20" height="20" title="Editar" role="img">',
                                                            ['/evento/editar-evento/', 'id' => $model->idEvento],
                                                            ['class' => 'btn btn-pink']);

                                        },
                                        'delete' => function ($url, $model) {
                                            return Html::a('<img class="filter-white" src="' . Yii::getAlias('@web/iconos/trash.svg') . '" alt="Borrar" width="20" height="20" title="Borrar" role="img">', 
                                                    ['/evento/deshabilitar/', 'id' => $model->idEvento], 
                                                    ['class' => 'btn btn-pink']);
                                        }
                                    ],
                                    'header' => 'Acciones',
                                ],
                            ],
                            'pager' => [
                                'class' => '\yii\widgets\LinkPager',
                                // Css for each options. Links
                                'linkOptions' => ['class' => 'btn btn-light pageLink'],
                                'disabledPageCssClass' => 'btn disabled',
                                'options' => ['class' => 'pagination d-flex justify-content-center'],
                                'prevPageLabel' => 'Anterior',
                                'nextPageLabel' => 'Siguiente',
                                //Current Active option value
                                'activePageCssClass' => 'activePage',
                            ],
                        ]);
                        ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>