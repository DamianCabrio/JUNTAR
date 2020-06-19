<?php

use yii\helpers\Html;
use yii\grid\GridView;
use \yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\JugadorSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Mis eventos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mis-eventos-gestionados container">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Crear Evento', [''], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
//        'filterModel' => $searchModel,
        'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],
            'nombreEvento',
//            'Posicion',
            [
                'attribute' => 'idCategoriaEvento',
                'label' => 'Categoria',
                'value' => 'idCategoriaEvento0.descripcionCategoria', //valor referenciado por ActiveQuery en el metodo idClub0
            ],
            [
                'attribute' => 'idModalidadEvento',
                'label' => 'Modalidad',
                'value' => 'idModalidadEvento0.descripcionModalidad', //valor referenciado por ActiveQuery en el metodo idClub0
            ],
            [
                'attribute' => 'fechaCreacionEvento',
                'label' => 'Creación',
            ],
            [
                'attribute' => 'fechaInicioEvento',
                'label' => 'Fecha Inicio',
            ],
            'capacidad',
//            [
//                'attribute' => 'idPais',
//                'label' => 'Pais',
//                'value' => 'idPais0.Nombre', //valor referenciado por ActiveQuery en el metodo idPais0
//            ],
//            'Fecha',
            ['class' => 'yii\grid\ActionColumn',
                'urlCreator' => function($action, $model, $key, $index ) {
                    if ($action == "view") {
                        return Url::to(['/eventos/ver-evento/'.$model->nombreCortoEvento, ]);
                    }
                    if ($action == "update") {
                        return Url::to(['', 'name' => $key]);
                    }
                    if ($action == "delete") {
                        return Url::to(['', 'name' => $key]);
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
