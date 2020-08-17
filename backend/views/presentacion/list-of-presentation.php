<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\PresentacionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Presentacions';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="presentacion-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Crear Presentación', ['create', 'idEvent' => $event], ['class' => 'btn btn-pink']) ?>
    </p>
    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemView' => '_list-presentation',
    ]); ?>
</div>
