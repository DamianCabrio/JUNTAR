<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\controllers\EventoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Eventos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="evento-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Evento', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'idEvento',
            'idUsuario',
            'idCategoria',
            'idEstadoEvento',
            'idModalidadEvento',
            //'nombreEvento',
            //'nombreCortoEvento',
            //'descripcionEvento',
            //'lugar',
            //'fechaInicioEvento',
            //'fechaFinEvento',
            //'imgFlyer',
            //'imgLogo',
            //'capacidad',
            //'preInscripcion',
            //'fechaLimiteInscripcion',
            //'codigoAcreditacion',
            //'fechaCreacionEvento',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
