<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>
<div class="container">
	<div class="expositores-lista">


		<h1>
			<?= $model->tituloPresentacion . '<br>' . Html::a('<b class="material-icons large align-middle">+Añadir</b>', [Url::to(['evento/cargar-expositor', 'idPresentacion' => $idPresentacion])], ['class' => 'btn agregarExpositor']); ?>
		</h1>


		<?= GridView::widget([
			'dataProvider' => $dataProvider,
			'columns' => [
				['class' => 'yii\grid\SerialColumn'],

				//'idExpositor',
				[
					'attribute' => 'Nombre',
					'format' => 'raw',
					'value' => function ($dataProvider) {
						return $dataProvider->idExpositor0->nombre . ' ' . $dataProvider->idExpositor0->apellido;
					},
					'headerOptions' => ['style' => 'width:30%;text-align:center;'],
				],
				//'idPresentacion',
				[
					'attribute' => 'Contacto',
					'format' => 'raw',
					'value' => function ($dataProvider) {
						return $dataProvider->idExpositor0->email;
					},
					'headerOptions' => ['style' => 'width:30%;text-align:center;'],
				],
				//['class' => 'yii\grid\ActionColumn'],
				[
					'class' => 'yii\grid\ActionColumn',
					//genera una url para cada evento
					'urlCreator' => function ($action, $model, $key, $index) {

						if ($action == "delete") {
							return Url::to(['presentacion-expositor/delete', 'idPresentacion' => $key['idPresentacion'], 'idExpositor' => $key['idExpositor']]);
						}
					},
					//describe los botones de accion
					'buttons' => [
						'delete' => function ($url, $model) {
							return Html::a('<b class="material-icons large align-middle">Borrar</b>', $url, ['class' => 'btn borrarPresentacion', 'data' => [
								'confirm' => 'Esta seguro que desea borrar el expositor?',
								'method' => 'post',
								'class' => 'alert alert-success'
							],]);
						},
					],
					'header' => 'Acciones',
					'headerOptions' => ['style' => 'text-align:center;'],
					'contentOptions' => ['style' => 'text-align:center; vertical-align:middle;'],
				]
			],
		]); ?>


	</div>
</div>