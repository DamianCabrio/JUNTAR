<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Presentacion Expositors';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="presentacion-expositor-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Presentacion Expositor', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'idExpositor',
            'idPresentacion',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
