<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Presentacions';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="presentacion-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Presentacion', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'idPresentacion',
            'idEvento',
            'tituloPresentacion',
            'descripcionPresentacion',
            'horaInicioPresentacion',
            //'horaFinPresentacion',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
