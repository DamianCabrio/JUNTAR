<?php

use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\RespuestaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Respuestas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="respuesta-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Respuesta', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'idpregunta',
            'idinscripcion',
            'respuesta',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
