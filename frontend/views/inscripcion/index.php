<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\InscripcionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Inscripcions';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="inscripcion-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Inscripcion', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'idInscripcion',
            'idUsuario',
            'idEvento',
            'estado',
            'fecha_preinscripcion',
            //'fecha_inscripcion',
            //'acreditacion',
            //'certificado',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
