<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\Presentacion */

$this->title = "Eliminar presentación";
//$this->params['breadcrumbs'][] = ['label' => 'Presentacions', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="container">
<div class="presentacion-delete">

	<?php
	if(!Yii::$app->user->isGuest && Yii::$app->user->identity->idUsuario == $model->idEvento0->idUsuario0->idUsuario){
		?>
    <p>Está seguro de querer eliminar esta presentación?</p>
		<?= Html::a('Si', ['delete', 'presentacion' => $model->idPresentacion], [
            'class' => 'btn btn-danger',
        ]) ?>
        <?= Html::a('No', ['', 'id' => $model->idPresentacion], ['class' => 'btn btn-primary']) ?>
	<?php } else{ ?>
		 <div class="row">
			<div class="col-12 text-center">
				<div class="row">
					<div class="col-12" style="padding-top: 4vh; padding-bottom: 4vh;">
						<p class="display-1">403</p>
					</div>
				</div>
				<p><b>Error</b>: usted no tiene permisos para gestionar esta presentacion.</p>
				<p>Si cree que esto es un error del servidor, contacte con un administrador del sistema</p>
			</div>
		</div>
    <?php } ?>
</div>
</div>
