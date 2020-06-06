<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Expositors';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="expositor-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Expositor', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'idExpositor',
            'idUsuario',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
