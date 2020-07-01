<?php

use yii\helpers\Html;
use yii\grid\GridView;
use \yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\JugadorSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Mis inscripciones';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mis-eventos-gestionados container">

    <h1><?= Html::encode($this->title) ?></h1>
    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
//        'filterModel' => $searchModel,
        'columns' => [
            [
                'attribute' => 'idEvento',
                'label' => 'Evento',
                'value' => 'idEvento0.nombreEvento', //valor referenciado por ActiveQuery en el metodo idClub0
            ],
            [
                'attribute' => 'fechaPreInscripcion',
                'label' => 'Pre-Inscripto',
            ],
            [
                'attribute' => 'fechaInscripcion',
                'label' => 'Inscripto',
            ],
            [
                'attribute' => 'acreditacion',
                "value" => function($model){
                    $acreditacionLabel = [0=> "No acreditado", 1 => "Acreditado"];
                    return $acreditacionLabel[$model->acreditacion];
                },
                'label' => 'Acreditacion',
                "filter" => [0 => "No acreditado", 1 => "Acreditado"]
            ],
            /*[
                'attribute' => 'certificado',
                'label' => 'Certificado',
            ],*/
            [
                'attribute' => 'estado',
                'label' => 'Estado',
                'value' => function($model){
                    $eventoEstadoLabel = [0 => "Preinscrito", 1 => "Inscripto", 2 => "Anulado"];
                    return $eventoEstadoLabel[$model->estado];
                }, //valor referenciado por ActiveQuery en el metodo idClub0
                "filter" => [""]
            ],
//            [
//                'attribute' => 'idPais',
//                'label' => 'Pais',
//                'value' => 'idPais0.Nombre', //valor referenciado por ActiveQuery en el metodo idPais0
//            ],
//            'Fecha',
            ['class' => 'yii\grid\ActionColumn',
                'urlCreator' => function($action, $model, $key, $index ) {
                    if ($action == "view") {
                        return Url::to(['/eventos/ver-evento/'.$model->idEvento0->nombreCortoEvento, ]);
                    }
                    if ($action == "update") {
                        return Url::to(['update-permiso', 'name' => $key]);
                    }
                    if ($action == "delete") {
                        return Url::to(['remove-permiso', 'name' => $key]);
                    }
                },
                'buttons' => [
                    'update' => function($url, $model) {
                        return null;
                    },
                    'view' => function($url, $model) {
                        return Html::a('<img src="' . Yii::getAlias('@web/iconos/eye.svg') . '" class="filter-white" alt="Visualizar" width="20" height="20" title="Visualizar" role="img">', $url, ['class' => 'btn']);
                    },
                    'delete' => function($url, $model) {
                        return null;
                    }
                ]
            ],
        ],
    ]);
    ?>


</div>
