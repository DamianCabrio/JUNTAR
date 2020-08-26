<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel common\models\SolicitudAvalSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$imageClassActivas = $imageClassAprobadas = $imageClassDenegadas = "";
$fondoClassActivas = $fondoClassAprobadas = $fondoClassDenegadas = "";

switch ($selected) {
    case "denegadas":
        $imageClassDenegadas = "filter-white";
        $fondoClassDenegadas = "pinkish_bg text-white";
        break;
    case "aprobadas":
        $imageClassAprobadas = "filter-white";
        $fondoClassAprobadas = "pinkish_bg text-white";
        break;
    default:
        $imageClassActivas = "filter-white";
        $fondoClassActivas = "pinkish_bg text-white";
        break;
}

$this->title = 'Solicitudes de aval FAI';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="solicitud-aval-index">
    <?php Pjax::begin(); ?>
    <div class="row">
        <div class="col-12 p-0">
            <div class="card">
                <h1 class="card-header text-center darkish_bg text-white"><?= Html::encode($this->title) ?></h1>
                <!--<div class="row justify-content-center m-3">-->
                <div class="row d-flex justify-content-center m-3">
                    <div class="card text-center p-0 col-md-4 col-sm-12 border-0">

                        <a class="btn col-md-10 col-sm-12 p-0 bg-light m-auto"
                           href="<?= Html::encode(Url::to(['solicitud-aval/solicitudes-de-aval', 'estado' => 'activas'])) ?>">

                            <h5 class="card-header <?php echo $fondoClassActivas; ?>">
                                <img class="<?php echo $imageClassActivas; ?>"
                                     src="<?php echo Yii::getAlias('@web/iconos/list-unordered.svg') ?>" alt="Activas"
                                     title="Activas" width="40" height="40" role="img">
                                Solicitudes Activas
                            </h5>
                        </a>
                    </div>
                    <div class="card text-center p-0 col-md-4 col-sm-12 border-0">

                        <a class="btn col-md-10 col-sm-12 p-0 bg-light m-auto"
                           href="<?= Html::encode(Url::to(['solicitud-aval/solicitudes-de-aval', 'estado' => 'denegadas'])) ?>">

                            <h5 class="card-header <?php echo $fondoClassDenegadas; ?>">
                                <img class="<?php echo $imageClassDenegadas; ?>"
                                     src="<?php echo Yii::getAlias('@web/iconos/denegarAval.svg') ?>" alt="Denegadas"
                                     title="Denegadas" width="40" height="40" role="img">
                                Denegadas
                            </h5>
                        </a>
                    </div>
                    <div class="card text-center p-0 col-md-4 col-sm-12 border-0">

                        <a class="btn col-md-10 col-sm-12 p-0 bg-light m-auto"
                           href="<?= Html::encode(Url::to(['solicitud-aval/solicitudes-de-aval', 'estado' => 'aprobadas'])) ?>">

                            <h5 class="card-header <?php echo $fondoClassAprobadas; ?>">
                                <img class="<?php echo $imageClassAprobadas; ?>"
                                     src="<?php echo Yii::getAlias('@web/iconos/concederAval.svg') ?>" alt="Aprobadas"
                                     title="Aprobadas" width="40" height="40" role="img">
                                Aprobadas
                            </h5>
                        </a>
                    </div>
                </div>
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
                                    'label' => 'Evento',
//                                    'format' => 'raw',
                                    'value' => function ($dataProvider) {
                                        return ($dataProvider->idEvento0->nombreEvento);
                                    }
                                ],
                                [
                                    'attribute' => 'fechaSolicitud',
                                    'label' => 'Fecha Solicitado',
                                    'value' => function ($dataProvider) {
                                        if ($dataProvider->fechaSolicitud != null && $dataProvider->fechaSolicitud != '') {
                                            return date("d-m-Y", strtotime($dataProvider->fechaSolicitud));
                                        } else {
                                            return $dataProvider->fechaSolicitud;
                                        }
                                    }
                                ],
                                [
                                    'attribute' => 'tokenSolicitud',
                                    'label' => 'Token',
                                    'value' => 'tokenSolicitud',
                                ],
                                [
                                    'attribute' => 'fechaRevision',
                                    'label' => 'Fecha Revisado',
                                    'value' => function ($dataProvider) {
                                        if ($dataProvider->fechaRevision != null && $dataProvider->fechaRevision != '') {
                                            return date("d-m-Y", strtotime($dataProvider->fechaRevision));
                                        } else {
                                            return $dataProvider->fechaRevision;
                                        }
                                    }
                                ],
                                [
                                    'attribute' => 'avalado',
                                    'label' => 'Aval FAI',
                                    'value' => function ($dataProvider) {
                                        if ($dataProvider->avalado === 0) {
                                            return "Denegado";
                                        } else if ($dataProvider->avalado === 1) {
                                            return "Concedido";
                                        } else {
                                            return "Pendiente";
                                        }
                                    },
                                ],
                                [
                                    'attribute' => 'validador',
                                    'label' => 'Revisado por',
                                    'value' => function ($dataProvider) {
                                        if ($dataProvider->validador0 != null && $dataProvider->validador0 != '') {
                                            return ($dataProvider->validador0->nombre . ' ' . $dataProvider->validador0->apellido);
                                        } else {
                                            return "-";
                                        }
                                    },
                                ],
                                ['class' => 'yii\grid\ActionColumn',
                                    'buttons' => [
                                        'view' => function ($url, $model) {
                                            return Html::a('<img class="filter-white" src="' . Yii::getAlias('@web/iconos/eye.svg') . '" alt="Visualizar Evento" title="Visualizar Evento" width="20" height="20" role="img">',
                                                ['/evento/view', 'id' => $model->idEvento],
                                                ['class' => 'btn btn-pink']);
                                        },
                                    ],
                                    'header' => 'Accion',
                                ],
                            ],
                        ]);
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php Pjax::end(); ?>
</div>
