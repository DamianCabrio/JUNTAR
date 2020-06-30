<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\Presentacion */

$this->title = $model->tituloPresentacion;
\yii\web\YiiAsset::register($this);
?>
<div class="container">
<div class="presentacion-view">

    <h1><?= Html::encode($this->title) ?></h1>
	<div class="table table-responsive">
    <?= DetailView::widget([
		'model' => $model,
        'attributes' => [
            //'idEvento',
			[
				'attribute'=>'Nombre',
				'value'=>$model->idEvento0->nombreEvento,
			],
            //'tituloPresentacion',
            //'descripcionPresentacion',
			[
				'attribute'=>'Descripción',
				'format' => 'raw',	
				'value'=>$model->descripcionPresentacion,
			],
            //'diaPresentacion',
			[
				'attribute'=>'Día',
				'value'=>date('d/m/Y', strtotime($model->diaPresentacion)),
			],
            //'horaInicioPresentacion',
			[
				'attribute'=>'Hora inicio',
				'value'=>date('H:i', strtotime($model->horaInicioPresentacion)),
			],
            //'horaFinPresentacion',
			[
				'attribute'=>'Hora fin',
				'value'=>date('H:i', strtotime($model->horaFinPresentacion)),
			],
			//'linkARecursos',
			[
				'attribute'=>'Recursos',
				'format' => 'raw',
				'value' => function($model){
					if($model->linkARecursos != NULL){
						return '<a target="_blank" href="' .$model->linkARecursos. '"><i class="material-icons">attachment</i></a>';
					}
					else{
						return 'No hay recursos para mostrar';
					}
				}	
			]	
        ],
	]) ?>
	</div>

</div>
</div>
