<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\EventoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Eventos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="evento-index container">

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
            'nombreEvento',
            'descripcionEvento',
            'lugar',
            //'modalidad',
            //'linkPresentaciones',
            //'linkFlyer',
            //'linkLogo',
            //'capacidad',
            //'preInscripcion',
            //'fechaLimiteInscripcion',
            //'codigoAcreditacion',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
