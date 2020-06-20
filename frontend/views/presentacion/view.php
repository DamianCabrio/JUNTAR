<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\Presentacion */

$this->title = $model->tituloPresentacion;
//$this->params['breadcrumbs'][] = ['label' => 'Presentacions', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="container">
<div class="presentacion-view">

    <h1><?= Html::encode($this->title) ?></h1>
	<?php
	if(!Yii::$app->user->isGuest && Yii::$app->user->identity->idUsuario == $model->idEvento0->idUsuario0->idUsuario){
		?>
    <p>
        <?= Html::a('Actualizar', ['update', 'id' => $model->idPresentacion], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Borrar', ['delete', 'id' => $model->idPresentacion], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Estás seguro de querer borrar esta presentación?',
                'method' => 'post',
            ],
        ]) ?>
	
    </p>
	<?php } ?>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'idPresentacion',
            //'idEvento',
			[
				'attribute'=>'Nombre del Evento',
				'value'=>$model->idEvento0->nombreEvento,
			],
            //'tituloPresentacion',
            //'descripcionPresentacion',
			[
				'attribute'=>'Descripción de la Presentación',
				'value'=>$model->descripcionPresentacion,
			],
            //'diaPresentacion',
			[
				'attribute'=>'Dia',
				'value'=>date('d/m/Y', strtotime($model->diaPresentacion)),
			],
            //'horaInicioPresentacion',
			[
				'attribute'=>'Hora de Inicio',
				'value'=>date('H:i', strtotime($model->horaInicioPresentacion)),
			],
            //'horaFinPresentacion',
			[
				'attribute'=>'Hora de Cierre',
				'value'=>date('H:i', strtotime($model->horaFinPresentacion)),
			],
            'linkARecursos',
        ],
    ]) ?>

</div>
</div>
