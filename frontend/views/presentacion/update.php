<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Presentacion */

$this->title = 'Update Presentacion: ' . $model->idPresentacion;
$this->params['breadcrumbs'][] = ['label' => 'Presentacions', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->idPresentacion, 'url' => ['view', 'id' => $model->idPresentacion]];
$this->params['breadcrumbs'][] = 'Update';
?>
<?php
if(!Yii::$app->user->isGuest && Yii::$app->user->identity->idUsuario == $model->idEvento0->idUsuario0->idUsuario){
?>
<div class="presentacion-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
<?php
}
else{
	?>
	<div class="container">
		<div class="row">
			<div class="col-12 text-center">
				<div class="row">
					<div class="col-12" style="padding-top: 4vh; padding-bottom: 4vh;">
						<p class="display-1">403</p>
					</div>
				</div>
				<p><b>Error</b>: usted no tiene permisos para gestionar este evento.</p>
				<p>Si cree que esto es un error del servidor, contacte con un administrador del sistema</p>
			</div>
		</div>
	</div>
<?php } ?>
