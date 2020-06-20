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
		<?php
		$cadenaAgregar = "";
		if(!Yii::$app->user->isGuest && $model->idEvento0->idUsuario == Yii::$app->user->identity->idUsuario){
			$cadenaAgregar = Html::a('<i class="material-icons large align-middle">add</i>', [Url::to(['evento/cargar-expositor', 'idPresentacion' => $model->idPresentacion])], ['class' => 'agregarExpositor']);
		}
		?>
        <?= $model->tituloPresentacion.' '.$cadenaAgregar; ?>
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
        ],
    ]); ?>


</div>
</div>
