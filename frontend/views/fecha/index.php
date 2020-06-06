<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Fechas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="fecha-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Fecha', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'idFecha',
            'idEvento',
            'fecha',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
