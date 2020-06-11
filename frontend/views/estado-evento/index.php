<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Estado Eventos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="estado-evento-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Estado Evento', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'idEstadoEvento',
            'descripcionEstado',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
